<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;

class SyncJobStatuses extends Command
{
    protected $signature = 'jobs:sync-statuses';
    protected $description = 'Sync job statuses based on dates and active status';

    public function handle()
    {
        $jobs = Job::all();
        $updated = 0;

        foreach ($jobs as $job) {
            $originalStatus = $job->getRawOriginal('status');
            $newStatus = $job->calculated_status;

            if ($originalStatus !== $newStatus) {
                $job->status = $newStatus;
                $job->save();
                $updated++;
            }
        }

        $this->info("Updated {$updated} job statuses.");

        return Command::SUCCESS;
    }
}
