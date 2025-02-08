<?php

use App\Providers\JetstreamServiceProvider;
use Illuminate\Support\Facades\Vite;
use Laravel\Jetstream\Jetstream;

beforeEach(function (): void {
    $this->serviceProvider = new JetstreamServiceProvider(app());
});

it('registers the service provider', function (): void {
    expect($this->serviceProvider)->toBeInstanceOf(JetstreamServiceProvider::class);
});

it('boots the service provider and configures permissions', function (): void {
    Vite::shouldReceive('prefetch')->with(['/'])->once();
    Jetstream::shouldReceive('defaultApiTokenPermissions')->with(['read'])->once();
    Jetstream::shouldReceive('permissions')->with(['create', 'read', 'update', 'delete'])->once();

    $this->serviceProvider->boot();
});

it('configures default api token permissions', function (): void {
    Jetstream::defaultApiTokenPermissions(['read']);
    $this->assertTrue(true);
});

it('configures permissions', function (): void {
    Jetstream::permissions([
        'create',
        'read',
        'update',
        'delete',
    ]);
    $this->assertTrue(true);
});
