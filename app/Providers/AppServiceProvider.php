<?php

namespace HLW\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        // set German locale for php date time and Carbon
        setlocale(LC_TIME, 'German');
        Carbon::setLocale('de');
        // mock date TODO: remove
        $mockdate = Carbon::create(2017,6,30);
        Carbon::setTestNow($mockdate);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
