<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * "Full access" admins were granted every module that existed at the time —
     * the `team` module came later. Give it to every admin who holds all other
     * modules in full, so full access keeps meaning full access. Partial
     * grants are left alone: team management stays an explicit grant for them.
     */
    public function up(): void
    {
        $modules = config('permissions.modules', []);
        $others = array_values(array_diff(array_keys($modules), ['team']));

        DB::table('users')->where('role', 'admin')->whereNotNull('permissions')->orderBy('id')
            ->each(function ($user) use ($modules, $others) {
                $perms = json_decode((string) $user->permissions, true);
                if (! is_array($perms) || $perms === []) {
                    return;
                }

                if (array_is_list($perms)) { // legacy flat list: each entry = the whole module, old names renamed
                    $map = [];
                    foreach ($perms as $module) {
                        $map[User::LEGACY_MODULE_KEYS[$module] ?? $module] = ['*'];
                    }
                    $perms = $map;
                }

                if (isset($perms['team'])) {
                    return;
                }

                foreach ($others as $module) {
                    $granted = (array) ($perms[$module] ?? []);
                    $all = array_keys($modules[$module]['features'] ?? []);
                    // "*" or every feature listed one by one both mean the whole module
                    if (! in_array('*', $granted, true) && ($all === [] || array_diff($all, $granted) !== [])) {
                        return;
                    }
                }

                $perms['team'] = ['*'];
                DB::table('users')->where('id', $user->id)->update(['permissions' => json_encode($perms)]);
            });
    }

    public function down(): void
    {
        // grants are data, not schema — leave them as they are
    }
};
