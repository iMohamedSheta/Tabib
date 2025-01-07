<?php

use App\Enums\User\UserRoleEnum;
use App\Models\User;

test('login screen can be rendered', function (): void {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function (): void {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'username' => $user->username,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    // $response->assertRedirect(UserRoleEnum::authRedirectRouteBasedOnType());
});

test('users cannot authenticate with invalid password', function (): void {
    $user = User::factory()->create();

    $this->post('/login', [
        'username' => $user->username,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});
