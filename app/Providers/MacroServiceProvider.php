<?php

namespace App\Providers;

use App\Macros\QueryBuilderMacro;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        QueryBuilderMacro::register();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        QueryBuilderMacro::boot();
    }
}
