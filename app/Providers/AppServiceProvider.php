<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // @isRoute(route_name) Directive
        Blade::directive('isRoute', function($expression) {
            return "<?php if(Route::currentRouteName() === {$expression}): ?>";
        });
        // @endIsRoute()
        Blade::directive('endIsRoute', function () {
            return "<?php endif ?>";
        });

        // @iteration($paginator)
        Blade::directive('iteration', function ($paginator) {
            return "<?php echo e(\$loop->iteration + ({$paginator}->currentPage() - 1) * {$paginator}->perPage()); ?>";
        });
    }
}
