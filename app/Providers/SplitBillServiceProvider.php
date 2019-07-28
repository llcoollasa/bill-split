<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SplitBillServiceInterface;
use App\Services\SplitBillService;

class SplitBillServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(SplitBillServiceInterface::class, SplitBillService::class);
    }
}
