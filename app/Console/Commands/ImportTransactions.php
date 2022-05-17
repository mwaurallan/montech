<?php

namespace App\Console\Commands;

use App\Imports\TransactionImport;
use Illuminate\Console\Command;

class ImportTransactions extends Command
{
    protected $signature = 'import:excel';

    protected $description = 'Laravel Excel importer';

    public function handle()
    {
        $this->output->title('Starting import');
        (new TransactionImport)->withOutput($this->output)->import('transactions.csv');
        $this->output->success('Import successful');
    }

}
