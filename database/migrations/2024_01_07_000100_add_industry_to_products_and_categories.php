<?php

use App\Http\Controllers\Admin\IndustryPack;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Industry scoping: every product/category belongs to exactly one industry
     * preset, so the landing page and the admin panel can filter by ab_industry().
     * Existing rows are backfilled — no data is lost.
     */
    public function up(): void
    {
        foreach (['products', 'categories'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('industry')->nullable()->index();
            });
        }

        // Genre demo products keep their own genre (slug pattern demo-<genre>-<n>)
        foreach (IndustryPack::keys() as $key) {
            if ($key === 'organic') {
                continue; // organic rows fall through to the default below
            }
            DB::table('products')
                ->where('slug', 'like', 'demo-' . $key . '-%')
                ->update(['industry' => $key]);
        }
        DB::table('products')->whereNull('industry')->update(['industry' => 'organic']);

        // Genre-managed category keys belong to their genre (first genre wins on
        // shared keys like `set`); everything else stays with the default organic pack
        $claimed = [];
        foreach (IndustryPack::all() as $key => $pack) {
            if ($key === 'organic') {
                continue;
            }
            $keys = [];
            foreach (IndustryPack::products($key) as $p) {
                $keys[] = $p['category_key'];
            }
            $keys = array_values(array_unique(array_diff($keys, $claimed)));
            $claimed = array_merge($claimed, $keys);
            if ($keys) {
                DB::table('categories')->whereIn('key', $keys)->update(['industry' => $key]);
            }
        }
        DB::table('categories')->whereNull('industry')->update(['industry' => 'organic']);
    }

    public function down(): void
    {
        foreach (['products', 'categories'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropIndex(['industry']);
                $table->dropColumn('industry');
            });
        }
    }
};
