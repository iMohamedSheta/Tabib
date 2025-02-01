<?php

use App\Livewire\App\Clinic\ClinicTable;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    // Create a ClinicAdmin user for the organization
    $this->user = User::factory()->create([
        'organization_id' => $this->organization->id,
        'role' => ClinicAdmin::class,
    ]);

    // Create a ClinicAdmin model linked to the created user
    $this->clinicAdmin = ClinicAdmin::factory()->create([
        'organization_id' => $this->organization->id,
        'user_id' => $this->user->id,
    ]);

    $this->actingAs($this->user);
});

it('renders successfully with clinics data', function (): void {
    Clinic::factory()->count(3)->create(['organization_id' => $this->organization->id]);

    Livewire::test(ClinicTable::class)
    ->assertSee(Clinic::first()->name)
    ->assertSee(Clinic::skip(1)->first()->name);
});

it('shows the correct pagination', function (): void {
    Clinic::factory()->count(25)->create(['organization_id' => $this->organization->id]);

    Livewire::test(ClinicTable::class, ['perPage' => 10])
    ->assertSee(Clinic::first()->name)
    ->assertDontSee(Clinic::skip(10)->first()->name)
    ->set('page', 2)
    ->assertDontSee(Clinic::first()->name)
    ->assertSee(Clinic::skip(10)->first()->name);
});
