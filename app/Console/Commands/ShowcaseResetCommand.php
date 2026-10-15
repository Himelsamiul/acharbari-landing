<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\IndustryPack;
use App\Support\AdminGenre;
use Illuminate\Console\Command;

class ShowcaseResetCommand extends Command
{
    protected $signature = 'showcase:reset {genre}';

    protected $description = 'Clear a genre demo admin\'s sandbox (demo_settings) back to the pack defaults — the real store is never touched';

    public function handle(): int
    {
        $genre = $this->argument('genre');
        if (! IndustryPack::valid($genre)) {
            $this->error('Unknown genre: ' . $genre . ' — valid: ' . implode(', ', IndustryPack::keys()));

            return self::INVALID;
        }

        $cleared = AdminGenre::reset($genre);
        if ($cleared > 0) {
            $this->info("{$genre} demo admin sandbox reset — panel back to pack defaults.");
        } else {
            $this->line("No {$genre} demo admin found — run `php artisan showcase:sync` first.");
        }

        return self::SUCCESS;
    }
}
