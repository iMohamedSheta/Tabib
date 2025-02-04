<?php

namespace App\Providers;

use App\Macros\CacheMacro;
use App\Macros\QueryBuilderMacro;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    #[\Override]
    public function register(): void
    {
        // QueryBuilderMacro::register();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        QueryBuilderMacro::boot();
        CacheMacro::boot();
    }
}
