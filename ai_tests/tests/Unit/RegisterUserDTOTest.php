<?php

use App\DTOs\Auth\RegisterUserDTO;
use App\Enums\User\Auth\OAuthProviderEnum;
use Illuminate\Support\Facades\Hash;

beforeEach(function (): void {
    $this->firstName = 'John';
    $this->lastName = 'Doe';
    $this->role = 'Patient';
    $this->phone = '1234567890';
    $this->email = 'test@example.com';
    $this->username = 'johndoe';
    $this->password = 'password';
    $this->profilePhotoPath = 'path/to/photo.jpg';
    $this->emailVerifiedAt = now();
    $this->oauthId = 'oauth_id';
    $this->oauthProvider = OAuthProviderEnum::FACEBOOK;
    $this->oauthToken = 'oauth_token';
    $this->oauthTokenExpiresIn = now()->addHour();
    $this->oauthScopes = ['scope1', 'scope2'];
});

it('can create a RegisterUserDTO instance', function (): void {
    $dto = new RegisterUserDTO(
        $this->firstName,
        $this->lastName,
        $this->role,
        $this->phone,
        $this->email,
        $this->username,
        $this->password,
        $this->profilePhotoPath,
        $this->emailVerifiedAt,
        $this->oauthId,
        $this->oauthProvider,
        $this->oauthToken,
        $this->oauthTokenExpiresIn,
        $this->oauthScopes,
    );

    expect($dto)->toBeInstanceOf(RegisterUserDTO::class);
    expect($dto->first_name)->toBe($this->firstName);
    expect($dto->last_name)->toBe($this->lastName);
    expect($dto->role)->toBe($this->role);
    expect($dto->phone)->toBe($this->phone);
    expect($dto->email)->toBe($this->email);
    expect($dto->username)->toBe($this->username);
    expect($dto->profile_photo_path)->toBe($this->profilePhotoPath);
    expect($dto->email_verified_at)->toBe($this->emailVerifiedAt);
    expect($dto->oauth_id)->toBe($this->oauthId);
    expect($dto->oauth_provider)->toBe($this->oauthProvider);
    expect($dto->oauth_token)->toBe($this->oauthToken);
    expect($dto->oauth_token_expires_in)->toBe($this->oauthTokenExpiresIn);
    expect($dto->oauth_scopes)->toBe(json_encode($this->oauthScopes));
    expect(Hash::check($this->password, $dto->password))->toBeTrue();
});

it('can return user data as an array', function (): void {
    $dto = new RegisterUserDTO(
        $this->firstName,
        $this->lastName,
        $this->role,
        $this->phone,
        $this->email,
        $this->username,
        $this->password,
        $this->profilePhotoPath,
        $this->emailVerifiedAt,
        $this->oauthId,
        $this->oauthProvider,
        $this->oauthToken,
        $this->oauthTokenExpiresIn,
        $this->oauthScopes,
    );

    $userData = $dto->userData();

    expect($userData['first_name'])->toBe($this->firstName);
    expect($userData['last_name'])->toBe($this->lastName);
    expect($userData['email'])->toBe($this->email);
    expect($userData['phone'])->toBe($this->phone);
    expect($userData['username'])->toBe($this->username);
    expect($userData['role'])->toBe($this->role);
    expect($userData['profile_photo_path'])->toBe($this->profilePhotoPath);
    expect($userData['email_verified_at'])->toBe($this->emailVerifiedAt);
    expect($userData['oauth_id'])->toBe($this->oauthId);
    expect($userData['oauth_provider'])->toBe($this->oauthProvider);
    expect($userData['oauth_token'])->toBe($this->oauthToken);
    expect($userData['oauth_token_expires_in'])->toBe($this->oauthTokenExpiresIn);
    expect($userData['oauth_scopes'])->toBe(json_encode($this->oauthScopes));
    expect(Hash::check($this->password, $userData['password']))->toBeTrue();
});

it('can handle null values for optional parameters', function (): void {
    $dto = new RegisterUserDTO(
        $this->firstName,
        $this->lastName,
        $this->role,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
    );

    $userData = $dto->userData();

    expect($dto->phone)->toBeNull();
    expect($dto->email)->toBeNull();
    expect($dto->username)->toBeNull();
    expect($dto->password)->toBeNull();
    expect($dto->profile_photo_path)->toBeNull();
    expect($dto->email_verified_at)->toBeNull();
    expect($dto->oauth_id)->toBeNull();
    expect($dto->oauth_provider)->toBeNull();
    expect($dto->oauth_token)->toBeNull();
    expect($dto->oauth_token_expires_in)->toBeNull();
    expect($dto->oauth_scopes)->toBeNull();

    expect($userData['phone'])->toBeNull();
    expect($userData['email'])->toBeNull();
    expect($userData['username'])->toBeNull();
    expect($userData['password'])->toBeNull();
    expect($userData['profile_photo_path'])->toBeNull();
    expect($userData['email_verified_at'])->toBeNull();
    expect($userData['oauth_id'])->toBeNull();
    expect($userData['oauth_provider'])->toBeNull();
    expect($userData['oauth_token'])->toBeNull();
    expect($userData['oauth_token_expires_in'])->toBeNull();
    expect($userData['oauth_scopes'])->toBeNull();
});
