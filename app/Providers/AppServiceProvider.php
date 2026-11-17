<?php

namespace HLW\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // necessary for mysql compatibility
        Schema::defaultStringLength(191);

        // German locale for Carbon
        Carbon::setLocale('de');

        // the views are built with Bootstrap 4
        Paginator::useBootstrapFour();

        // Implicitly grant "super_admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        // inline svg icons, e.g. @svg('arena', ['class' => 'align-middle'])
        Blade::directive('svg', function ($expression) {
            return "<?php echo \\HLW\\Support\\Svg::render({$expression}); ?>";
        });
    }
}
