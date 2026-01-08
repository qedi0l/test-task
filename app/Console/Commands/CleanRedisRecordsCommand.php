<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\CleanOldRedisRecords;

class CleanRedisRecordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean old User records that are older than 5 minutes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Cleaning old Users...');

        // Dispatch the job to clean up old records
        CleanOldRedisRecords::dispatch();
    }
}
