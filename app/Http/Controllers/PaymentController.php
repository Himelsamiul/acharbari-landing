<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\Payment\BkashGateway;
use App\Services\Payment\NagadGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Gateway return-callbacks: verify the payment server-side, flag the order
 * paid/failed, then hand the customer back to the success page.
 */
class PaymentController extends Controller
{
    public function bkashCallback(Request $request, string $code)
    {
        $order = Order::where('order_code', $code)->firstOrFail();
        $paymentID = (string) $request->query('paymentID', '');
        $status = strtolower((string) $request->query('status', ''));

        if ($status === 'success' && $paymentID !== '') {
            $executed = BkashGateway::executePayment($paymentID);

            if ($executed !== null) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_txn_id' => $executed['trxID'],
                ]);

                return redirect()->route('order.success', $order->order_code);
            }

            // maybe executed but response missed — verify before declaring failure
            $queried = BkashGateway::queryPayment($paymentID);
            if (($queried['transactionStatus'] ?? '') === 'Completed') {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_txn_id' => $queried['trxID'] ?? '',
                ]);

                return redirect()->route('order.success', $order->order_code);
            }
        }

        Log::warning('bKash callback not completed', ['order' => $code, 'status' => $status, 'paymentID' => $paymentID]);
        $order->update(['payment_status' => 'failed']);

        return redirect()->route('order.success', $order->order_code)->with('payment_failed', true);
    }

    public function nagadCallback(Request $request, string $code)
    {
        $order = Order::where('order_code', $code)->firstOrFail();
        $refId = (string) ($request->query('payment_reference_id') ?? $request->query('paymentRefId') ?? '');
        $status = strtolower((string) ($request->query('status') ?? $request->query('payment_status') ?? ''));

        if ($refId !== '' && $status !== 'cancel' && $status !== 'failure') {
            $completed = NagadGateway::complete($order, $refId);

            if ($completed !== null) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_txn_id' => $completed['trxID'],
                ]);

                return redirect()->route('order.success', $order->order_code);
            }
        }

        Log::warning('Nagad callback not completed', ['order' => $code, 'status' => $status, 'refId' => $refId]);
        $order->update(['payment_status' => 'failed']);

        return redirect()->route('order.success', $order->order_code)->with('payment_failed', true);
    }
}
