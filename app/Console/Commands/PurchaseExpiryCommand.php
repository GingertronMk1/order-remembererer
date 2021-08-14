<?php

namespace App\Console\Commands;

use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PurchaseExpiryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'purchase:expire {--S|--sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all available purchase expirys';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Purchase::where('expired', false)->where('expires_at', '<', Carbon::now())->each(function (Purchase $purchase) {
            fwrite(STDOUT, "Expiring purchase {$purchase->id}".PHP_EOL);
            $purchase->expire($this->options('sync'));
        });
    }
}
