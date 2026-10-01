<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Live server e purano static public/robots.txt ("User-agent: * Disallow:")
 * admin-er custom robots ke hashiye dito (FTP deploy kokhono delete kore na).
 * Ei migration admin setting (ba default) diye physical file ta overwrite kore.
 */
return new class extends Migration
{
    public function up(): void
    {
        \App\Http\Controllers\Admin\SeoController::syncRobotsFile();
    }

    public function down(): void
    {
        // robots file sync — down e kichu korar dorkar nei
    }
};
