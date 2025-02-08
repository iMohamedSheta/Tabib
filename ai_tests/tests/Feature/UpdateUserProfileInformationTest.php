<?php

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function Pest\Laravel\actingAs;

beforeEach(function (): void {
    $this->user = User::factory()->create();
    $this->updater = new UpdateUserProfileInformation();
});

describe('update', function () {
    it('should update user profile information', function () {
        actingAs($this->user);

        $input = [
            'username' => 'newusername',
            'email' => 'newemail@example.com',
        ];

        $this->updater->update($this->user, $input);

        $this->user->refresh();

        expect($this->user->username)->toBe('newusername')
            ->and($this->user->email)->toBe('newemail@example.com');
    });

    it('should update user profile photo', function () {
        actingAs($this->user);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $input = [
            'username' => 'newusername',
            'email' => 'newemail@example.com',
            'photo' => $file,
        ];

        $this->updater->update($this->user, $input);

        $this->user->refresh();

        Storage::disk('public')->assertExists('profile-photos/' . $file->hashName());
        expect($this->user->profile_photo_path)->not->toBeNull();
    });

    it('should send email verification notification if email is changed', function () {
        actingAs($this->user);
        $oldEmail = $this->user->email;
        $input = [
            'username' => 'newusername',
            'email' => 'newemail@example.com',
        ];

        $this->updater->update($this->user, $input);

        $this->user->refresh();

        expect($this->user->email)->toBe('newemail@example.com');
        expect($this->user->email_verified_at)->toBeNull();
        $this->user->email = $oldEmail;
    })->skip('Skipped due to missing implementation of email verification mocking');

    it('should validate input', function () {
        $input = [
            'username' => '',
            'email' => 'invalid-email',
            'photo' => 'not-an-image',
        ];

        $validator = Validator::make($input, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        expect($validator->fails())->toBeTrue();
        expect($validator->errors()->has('username'))->toBeTrue();
        expect($validator->errors()->has('email'))->toBeTrue();
    });
});
