<?php

namespace HLW\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // necessary for mysql compatibility
        Schema::defaultStringLength(191);
        // set German locale for php date time and Carbon
        setlocale(LC_TIME, 'German');
        Carbon::setLocale('de');
        // mock date TODO: remove
        //$mockdate = Carbon::create(2017,11,14);
        //Carbon::setTestNow($mockdate);
    }
}
