<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

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
        $this->configureVite();
        $this->configurePulse();
        $this->configureCommands();
        $this->configureTelescope();
        $this->configureModals();
        $this->configureURLs();
    }

    private function configureVite()
    {
        Vite::usePrefetchStrategy('aggressive');
        // Vite::prefetch(3); // After the page is loaded for the first time,
        // lazily load all the chunks of our website to the user.
    }

    private function configurePulse()
    {
        Gate::define('viewPulse', function (User $user) {
            return $this->app->environment('local') || $user->isManager();
        });
    }

    private function configureCommands(): void
    {
        DB::prohibitDestructiveCommands($this->app->environment('production'));
    }

    private function configureTelescope(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    private function configureModals(): void
    {
        Model::shouldBeStrict();
        Model::unguard();
    }

    private function configureURLs(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
