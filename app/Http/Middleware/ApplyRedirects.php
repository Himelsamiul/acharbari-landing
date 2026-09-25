<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class ApplyRedirects
{
    public function handle(Request $request, Closure $next)
    {
        $path = '/' . trim($request->path(), '/');

        $redirect = Redirect::map()[$path] ?? null;

        if ($redirect && rtrim($redirect['to'], '/') !== $path) {
            $to = str_starts_with($redirect['to'], 'http') ? $redirect['to'] : url($redirect['to']);
            return redirect()->away($to, $redirect['code']);
        }

        return $next($request);
    }
}
