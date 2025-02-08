<?php

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    $this->creator = new CreateNewUser();
});

describe('CreateNewUser', function () {
    it('should create a new user', function () {
        $input = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => 'on',
        ];

        $user = $this->creator->create($input);

        expect($user)->toBeInstanceOf(User::class);
        expect($user->username)->toBe('testuser');
        expect($user->email)->toBe('test@example.com');
        expect(Hash::check('password', $user->password))->toBeTrue();

        assertDatabaseHas('users', [
            'username' => 'testuser',
            'email' => 'test@example.com',
        ]);
    });

    it('should validate the input', function () {
        $input = [
            'username' => null,
            'email' => 'invalid-email',
            'password' => 'short',
            'password_confirmation' => 'mismatch',
            'terms' => null,
        ];

        try {
            $this->creator->create($input);
        } catch (
            Illuminate\Validation\ValidationException $e
        ) {
            expect($e->errors())->toBeArray();
            expect($e->errors())->toHaveKeys(['username', 'email', 'password']);

            return;
        }

        $this->fail('Expected validation exception was not thrown.');
    });

    it('should require terms if terms and privacy policy feature is enabled', function () {
        // Mock the Jetstream configuration to enable terms and privacy policy.
        config(['jetstream.features' => ['terms']]);

        $input = [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        try {
            $this->creator->create($input);
        } catch (Illuminate\Validation\ValidationException $e) {
            expect($e->errors())->toBeArray();
            expect($e->errors())->toHaveKey('terms');

            // Restore the original Jetstream configuration.
            config(['jetstream.features' => []]);

            return;
        }

        config(['jetstream.features' => []]);
        $this->fail('Expected validation exception was not thrown.');
    });
});
