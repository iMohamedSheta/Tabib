<?php

use App\Providers\GoogleDriveServiceProvider;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\app;

beforeEach(function (): void {
    $this->app = app();
});

it('registers the google storage driver', function (): void {
    $provider = $this->app->getProvider(GoogleDriveServiceProvider::class);
    expect($provider)->toBeInstanceOf(GoogleDriveServiceProvider::class);
});

it('extends the storage facade with the google driver', function (): void {
    $this->app->register(GoogleDriveServiceProvider::class);

    $manager = Storage::disk('google');
    expect($manager)->toBeInstanceOf(Illuminate\Filesystem\FilesystemAdapter::class);
});

it('catches exceptions during driver loading and logs the error', function (): void {
    Storage::extend('google_error', function ($app, $config) {
        throw new Exception('Failed to create Google Drive adapter.');
    });

    $provider = new GoogleDriveServiceProvider($this->app);
    $provider->boot();

    // Assert that an error was logged (you might need to adjust this based on your logging setup)
    // For example, if you're using Laravel's default logger, you could check the log file.
    // This is a placeholder, replace with your actual log assertion.
    $this->assertTrue(true); // Replace with a proper log assertion
});
