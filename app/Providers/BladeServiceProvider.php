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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::directive('iteration', fn ($paginator): string => sprintf('<?php echo e($loop->iteration + (%s->currentPage() - 1) * %s->perPage()); ?>', $paginator, $paginator));

        // @isRoute(route_name, route_name_2)
        Blade::directive('isRoute', fn ($routes): string => sprintf('<?php if(in_array(Route::currentRouteName(), array_map("trim", explode(",", %s)))): ?>', $routes));
        // @endIsRoute()
        Blade::directive('endIsRoute', fn (): string => '<?php endif ?>');

        // @iteration($paginator)
        Blade::directive('iteration', fn ($paginator): string => sprintf('<?php echo e($loop->iteration + (%s->currentPage() - 1) * %s->perPage()); ?>', $paginator, $paginator));

        Blade::directive('laravelPWA', fn ($expression): string => "<?php \$config = (new \App\Services\Internal\PWA\ManifestService)->generate(); echo \$__env->make( 'vendor.laravelpwa.meta' , ['config' => \$config])->render(); ?>");
    }
}
