<?php

namespace App\DTOs\Auth;

use App\Enums\User\Auth\OAuthProviderEnum;
use Illuminate\Support\Facades\Hash;

class RegisterUserDTO
{
    public function __construct(
        public $first_name,
        public $last_name,
        public $role,
        public $phone = null,
        public $email = null,
        public $username = null,
        public $password = null,
        public $profile_photo_path = null,
        public $email_verified_at = null,
        public $oauth_id = null,
        public ?OAuthProviderEnum $oauth_provider = null,
        public $oauth_token = null,
        public $oauth_token_expires_in = null,
        public $oauth_scopes = null,
    ) {
        $this->oauth_scopes = $this->oauth_scopes ? json_encode($oauth_scopes) : null;
        $this->password = $this->password ? Hash::make($password) : null;
    }

    public function userData(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'username' => $this->username,
            'password' => $this->password,
            'role' => $this->role,
            'profile_photo_path' => $this->profile_photo_path,
            'email_verified_at' => $this->email_verified_at,
            'oauth_id' => $this->oauth_id,
            'oauth_provider' => $this->oauth_provider,
            'oauth_token' => $this->oauth_token,
            'oauth_token_expires_in' => $this->oauth_token_expires_in,
            'oauth_scopes' => $this->oauth_scopes,
        ];
    }
}
