<?php

use App\Actions\Fortify\UpdateUserPassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

uses(Tests\TestCase::class)->in('Feature');

beforeEach(function (): void {
    $this->user = User::factory()->create();
});

describe('UpdateUserPassword', function () {
    it('should update user password successfully', function () {
        $updater = new UpdateUserPassword();
        $newPassword = Str::random(12);

        $updater->update($this->user, [
            'current_password' => 'password',
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $this->user->refresh();

        expect(Hash::check($newPassword, $this->user->password))->toBeTrue();
    });

    it('should throw validation error if current password does not match', function () {
        $updater = new UpdateUserPassword();
        $newPassword = Str::random(12);

        try {
            $updater->update($this->user, [
                'current_password' => 'wrong_password',
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            expect($e->errors())->toHaveKey('current_password');

            return;
        }

        $this->fail('Expected validation exception was not thrown.');
    });

    it('should throw validation error if password does not meet requirements', function () {
        $updater = new UpdateUserPassword();

        try {
            $updater->update($this->user, [
                'current_password' => 'password',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            expect($e->errors())->toHaveKey('password');

            return;
        }

        $this->fail('Expected validation exception was not thrown.');
    });
});
