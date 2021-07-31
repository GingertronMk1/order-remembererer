<?php

namespace App\Providers;

use App\Models\Cuisine;
use App\Models\Order;
use App\Models\Team;
use App\Models\Vendor;
use App\Policies\CuisinePolicy;
use App\Policies\OrderPolicy;
use App\Policies\TeamPolicy;
use App\Policies\VendorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Team::class => TeamPolicy::class,
        Cuisine::class => CuisinePolicy::class,
        Vendor::class => VendorPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
