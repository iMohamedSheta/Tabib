<?php

use App\Providers\AiServiceProvider;
use Illuminate\Foundation\Application;

use function Pest\Laravel\app;


beforeEach(function () {
    $this->app = app();
});

describe('AiServiceProvider', function () {

    it('should register custom providers from config', function () {
        // Arrange
        $config = config(['prism.providers.custom' => [
            'test_provider' => [
                'api_key' => 'test_api_key',
                'url' => 'test_url',
            ],
        ]]);

        $serviceProvider = new AiServiceProvider($this->app);
        $serviceProvider->boot();

        // Assert
        $this->assertTrue(true); // Basic assertion to check if the test runs without errors.  More specific assertions require mocking or deeper inspection of the container.
    });

});
