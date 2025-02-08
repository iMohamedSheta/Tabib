<?php

use App\Actions\Clinic\CreateClinicAction;
use App\Livewire\Auth\Register\Register;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function (): void {
    // Create an organization
    $this->organization = Organization::factory()->create();

    // Define rules for each step, matching the form request
    $this->stepOneRules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|in:hospital,clinic,polyclinic',
    ];

    $this->stepTwoRules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ];

    $this->stepThreeRules = [
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'policy' => 'accepted',
    ];
});

describe('Register Component', function () {
    it('renders successfully', function () {
        Livewire::test(Register::class)
            ->assertStatus(200);
    });

    it('initializes with step 1', function () {
        Livewire::test(Register::class)
            ->assertSet('step', 1);
    });

    it('can move to the next step', function () {
        Livewire::test(Register::class)
            ->set('name', 'test')
            ->set('type', 'clinic')
            ->call('submitStepOne')
            ->assertSet('step', 2);
    });

    it('validates step one correctly', function () {
        Livewire::test(Register::class)
            ->call('submitStepOne')
            ->assertHasErrors(['name', 'type']);
    });

    it('validates step two correctly', function () {
        Livewire::test(Register::class)
            ->set('step', 2)
            ->call('submitStepTwo')
            ->assertHasErrors(['first_name', 'last_name', 'phone']);
    });

    it('validates step three correctly', function () {
        Livewire::test(Register::class)
            ->set('step', 3)
            ->call('submitStepThree')
            ->assertHasErrors(['username', 'password', 'policy']);
    });

    it('registers a clinic admin successfully', function () {
        Livewire::test(Register::class)
            ->set('name', 'test')
            ->set('type', 'clinic')
            ->call('submitStepOne')
            ->set('first_name', 'test')
            ->set('last_name', 'test')
            ->set('phone', '01092322465')
            ->call('submitStepTwo')
            ->set('username', 'test')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->set('policy', true)
            ->call('submitStepThree')
            ->assertHasNoErrors();

        assertDatabaseHas('users', ['username' => 'test', 'role' => ClinicAdmin::class]);
        assertDatabaseHas('clinics', ['name' => 'test', 'type' => 'clinic']);
    });

    it('rolls back the transaction if an error occurs during registration', function () {
        // Mock the CreateClinicAction to throw an exception
        $this->mock(CreateClinicAction::class, function ($mock) {
            $mock->shouldReceive('handle')->andThrow(new Exception('Simulated error'));
        });

        // Ensure that the DB facade receives the rollBack call
        DB::shouldReceive('rollBack')->once();

        // Call the submitStepThree method, which should trigger the exception
        Livewire::test(Register::class)
            ->set('name', 'test')
            ->set('type', 'clinic')
            ->call('submitStepOne')
            ->set('first_name', 'test')
            ->set('last_name', 'test')
            ->set('phone', '01092322465')
            ->call('submitStepTwo')
            ->set('username', 'test')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->set('policy', true)
            ->call('submitStepThree');
    });
});
