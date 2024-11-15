<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('iteration', function ($paginator) {
            return "<?php echo e(\$loop->iteration + ({$paginator}->currentPage() - 1) * {$paginator}->perPage()); ?>";
        });

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

        Blade::directive('laravelPWA', function($expression) {
            return "<?php \$config = (new \App\Services\PWA\ManifestService)->generate(); echo \$__env->make( 'vendor.laravelpwa.meta' , ['config' => \$config])->render(); ?>";
        });
    }
}
