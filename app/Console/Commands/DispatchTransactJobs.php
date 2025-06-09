<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\TransactJobs;

class DispatchTransactJobs extends Command
{
    protected $signature = 'start:notif';
    protected $description = 'Dispatch the TransactJobs to the queue';

    public function handle(): void
    {
        TransactJobs::dispatch();
        $this->info('TransactJobs dispatched!');
    }
}
