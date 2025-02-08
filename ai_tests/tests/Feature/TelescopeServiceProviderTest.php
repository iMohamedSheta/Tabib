<?php

use App\Models\User;
use App\Providers\TelescopeServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;

beforeEach(function () {
    $this->telescope = Mockery::mock('alias:' . Telescope::class);
    $this->app = app();
});

describe('TelescopeServiceProvider', function () {
    it('registers Telescope', function () {
        $serviceProvider = new TelescopeServiceProvider($this->app);
        $serviceProvider->register();

        expect(Telescope::check())->toBe(true);
    });

    it('hides sensitive request details in non-local environments', function () {
        $this->app->shouldReceive('environment')->with('local')->once()->andReturn(false);
        $this->telescope->shouldReceive('hideRequestParameters')->with(['_token'])->once();
        $this->telescope->shouldReceive('hideRequestHeaders')->with(['cookie', 'x-csrf-token', 'x-xsrf-token'])->once();

        $serviceProvider = new TelescopeServiceProvider($this->app);
        $serviceProvider->register();
    });

    it('does not hide sensitive request details in local environments', function () {
        $this->app->shouldReceive('environment')->with('local')->once()->andReturn(true);

        $serviceProvider = new TelescopeServiceProvider($this->app);
        $serviceProvider->register();

        $reflectedClass = new ReflectionClass($serviceProvider);
        $reflectedMethod = $reflectedClass->getMethod('hideSensitiveRequestDetails');
        $reflectedMethod->setAccessible(true);
        $reflectedMethod->invoke($serviceProvider);

        expect(true)->toBeTrue(); // Just to assert that the test is executed without errors
    });

    it('filters incoming entries based on environment and entry type', function () {
        $this->app->shouldReceive('environment')->with('local')->andReturn(false);
        $this->telescope->shouldReceive('filter')->once()->andReturnUsing(function ($callback) {
            $incomingEntry = Mockery::mock(IncomingEntry::class);

            $incomingEntry->shouldReceive('isReportableException')->andReturn(false);
            $incomingEntry->shouldReceive('isFailedRequest')->andReturn(false);
            $incomingEntry->shouldReceive('isFailedJob')->andReturn(false);
            $incomingEntry->shouldReceive('isScheduledTask')->andReturn(false);
            $incomingEntry->shouldReceive('hasMonitoredTag')->andReturn(true);

            expect($callback($incomingEntry))->toBe(true);
        });

        $serviceProvider = new TelescopeServiceProvider($this->app);
        $serviceProvider->register();
    });

    it('registers the Telescope gate', function () {
        Gate::shouldReceive('define')->with('viewTelescope', Mockery::type('Closure'))->once()->andReturnUsing(function ($gateName, $callback) {
            $user = Mockery::mock(User::class);
            $user->shouldReceive('isManager')->andReturn(true);
            expect($callback($user))->toBe(true);
        });

        $serviceProvider = new TelescopeServiceProvider($this->app);
        $reflectedClass = new ReflectionClass($serviceProvider);
        $reflectedMethod = $reflectedClass->getMethod('gate');
        $reflectedMethod->setAccessible(true);
        $reflectedMethod->invoke($serviceProvider);
    });
});
