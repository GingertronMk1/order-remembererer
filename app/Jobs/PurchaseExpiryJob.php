<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\Purchase;
use App\Models\User;
use App\Notifications\PurchaseExpiredNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurchaseExpiryJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $purchase;

    /**
     * Create a new job instance.
     */
    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $data = [];

        $this->purchase->invitations->each(function ($invitation) use (&$data) {
            $user_id = $invitation->user_id;
            $order = Order::where('user_id', $user_id)->where('vendor_id', $this->purchase->vendor_id)->first();
            $user = User::find($user_id);
            if ($order) {
                $data[$user_id] = ['name' => $user ? $user->id : 'Error finding user'];
                foreach ([
                    'food',
                    'drink',
                    'other',
                ] as $aspect) {
                    if ($invitation->accepted[$aspect] && $order->{$aspect}) {
                        $data[$user_id][$aspect] = $order->{$aspect};
                    } else {
                        $data[$user_id][$aspect] = 'N/A';
                    }
                }
            }
        });

        $this->purchase->data = $data;
        $this->purchase->expired = true;
        if ($this->purchase->save()) {
            $this->purchase->user->notify(new PurchaseExpiredNotification($this->purchase));
        }
    }
}
