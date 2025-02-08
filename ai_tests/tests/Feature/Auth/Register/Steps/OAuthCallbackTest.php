<?php

use App\Actions\Clinic\CreateClinicAction;
use App\DTOs\Auth\RegisterUserDTO;
use App\Livewire\Auth\Register\Steps\OAuthCallback;
use App\Models\Clinic;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;


use function Pest\Laravel\assertDatabaseHas;


beforeEach(function (): void {
    $this->userData = [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'username' => 'johndoe',
        'email' => 'john@example.com',
        'password' => 'password',
    ];

});

it('renders successfully', function (): void {
    Livewire::test(OAuthCallback::class, ['userData' => $this->userData])
        ->assertStatus(200);
});

it('validates the input correctly', function (): void {
    Livewire::test(OAuthCallback::class, ['userData' => $this->userData])
        ->set('name', '')
        ->set('type', '')
        ->call('createClinicAction')
        ->assertHasErrors(['name', 'type']);
});

it('creates a clinic and user successfully', function (): void {
    Livewire::test(OAuthCallback::class, ['userData' => $this->userData])
        ->set('name', 'Test Clinic')
        ->set('type', 'Hospital')
        ->call('createClinicAction')
        ->assertHasNoErrors();

    assertDatabaseHas('clinics', ['name' => 'Test Clinic', 'type' => 'Hospital']);
    assertDatabaseHas('users', ['username' => 'johndoe', 'email' => 'john@example.com']);

    $user = User::where('username', 'johndoe')->first();
    expect($user->organization_id)->not->toBeNull();
});

it('handles exceptions during clinic creation', function (): void {
    $mockAction = Mockery::mock(CreateClinicAction::class);
    $mockAction->shouldReceive('handle')->andThrow(new Exception('Test Exception'));

    $this->app->bind(CreateClinicAction::class, function () use ($mockAction) {
        return $mockAction;
    });

    Livewire::test(OAuthCallback::class, ['userData' => $this->userData])
        ->set('name', 'Test Clinic')
        ->set('type', 'Hospital')
        ->call('createClinicAction');

    $this->assertTrue(true);
})->skip('Need to find way to test exception logs');
