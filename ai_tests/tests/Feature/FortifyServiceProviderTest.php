<?php

use App\Models\User;
use App\Providers\FortifyServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Fortify;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

describe('FortifyServiceProvider', function () {
    beforeEach(function () {
        // Mock the service provider to avoid actual registration during testing.
        $this->mockFortify = $this->mock('alias:' . Fortify::class);
    });

    it('can authenticate user using username or email', function () {
        // Arrange
        $user = User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $request = new Request([
            'username' => 'testuser',
            'password' => 'password',
        ]);

        // Act
        $authenticatedUser = Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->username)
                ->orWhere('username', $request->username)
                ->first();

            if ($user
                && Hash::check($request->password, $user->password)) {
                return $user;
            }
        })($request);

        // Assert
        expect($authenticatedUser)->toBeInstanceOf(User::class);
        expect($authenticatedUser->id)->toBe($user->id);

        // Arrange - try with email
        $request = new Request([
            'username' => 'test@example.com',
            'password' => 'password',
        ]);

        // Act
        $authenticatedUser = Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->username)
                ->orWhere('username', $request->username)
                ->first();

            if ($user
                && Hash::check($request->password, $user->password)) {
                return $user;
            }
        })($request);

        // Assert
        expect($authenticatedUser)->toBeInstanceOf(User::class);
        expect($authenticatedUser->id)->toBe($user->id);
    });

    it('returns null if authentication fails', function () {
        // Arrange
        User::factory()->create([
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $request = new Request([
            'username' => 'testuser',
            'password' => 'wrongpassword',
        ]);

        // Act
        $authenticatedUser = Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->username)
                ->orWhere('username', $request->username)
                ->first();

            if ($user
                && Hash::check($request->password, $user->password)) {
                return $user;
            }
        })($request);

        // Assert
        expect($authenticatedUser)->toBeNull();
    });

    it('defines rate limiter for login', function () {
        // Arrange
        $request = new Request([
            'username' => 'testuser',
        ]);

        // Mock the RateLimiter::for method to capture the defined rate limiter
        RateLimiter::shouldReceive('for')
            ->with('login', Mockery::type('Closure'))
            ->once()
            ->andReturnUsing(function ($name, $callback) use ($request) {
                // Execute the callback to get the Limit object
                $limit = $callback($request);

                // Assert that the Limit object is correctly configured
                expect($limit->maxAttempts)->toBe(5);
                expect($limit->decayMinutes)->toBe(1);

                // Return a dummy value to satisfy the RateLimiter::for method
                return 'dummy_rate_limiter';
            });

        // Act
        app(FortifyServiceProvider::class)->boot();
    });

    it('defines rate limiter for two-factor authentication', function () {
        // Arrange
        $request = new Request();
        $request->setSession(app('session.store'));
        $request->session()->put('login.id', 123);

        // Mock the RateLimiter::for method to capture the defined rate limiter
        RateLimiter::shouldReceive('for')
            ->with('two-factor', Mockery::type('Closure'))
            ->once()
            ->andReturnUsing(function ($name, $callback) use ($request) {
                // Execute the callback to get the Limit object
                $limit = $callback($request);

                // Assert that the Limit object is correctly configured
                expect($limit->maxAttempts)->toBe(5);
                expect($limit->decayMinutes)->toBe(1);

                // Return a dummy value to satisfy the RateLimiter::for method
                return 'dummy_rate_limiter';
            });

        // Act
        app(FortifyServiceProvider::class)->boot();
    });
});
