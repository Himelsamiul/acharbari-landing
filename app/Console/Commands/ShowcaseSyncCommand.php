<?php

namespace App\Console\Commands;

use App\Services\ShowcaseSync;
use Illuminate\Console\Command;

class ShowcaseSyncCommand extends Command
{
    protected $signature = 'showcase:sync';

    protected $description = 'Upsert the showcase catalogue: 6 demo products per genre + one lp-<genre> landing-design product each (idempotent, never deactivates other genres)';

    public function handle(): int
    {
        (new ShowcaseSync)->run();

        $this->info('Showcase catalogue synced — demo products + landing-design rows are in place.');

        return self::SUCCESS;
    }
}
