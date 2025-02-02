<?php

namespace App\Providers;

use EchoLabs\Prism\Providers\Gemini\Gemini;
use Illuminate\Support\ServiceProvider;

class AiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    #[\Override]
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerCustomProviders();
    }

    private function registerCustomProviders(): void
    {
        foreach (config('prism.providers.custom') as $providerKey => $provider) {
            $this->app['prism-manager']->extend("custom.{$providerKey}", fn ($app, $config): \EchoLabs\Prism\Providers\Gemini\Gemini => new Gemini(
                apiKey: $config['api_key'] ?? '',
                url: $config['url'] ?? '',
            ));
        }
    }
}
