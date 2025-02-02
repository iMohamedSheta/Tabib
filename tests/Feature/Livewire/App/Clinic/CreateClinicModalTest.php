<?php

use App\Livewire\App\Clinic\Includes\CreateClinicModal;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

describe('CreateClinicModal [Livewire-Component]', function (): void {
    beforeEach(function (): void {
        $this->organization = Organization::factory()->create();

        $this->user = User::factory()->create([
            'organization_id' => $this->organization->id,
            'role' => ClinicAdmin::class,
        ]);

        $this->actingAs($this->user);
    });

    it('renders successfully', function (): void {
        Livewire::test(CreateClinicModal::class)
            ->assertStatus(200);
    });

    it('calls addClinicAction when the form is submitted', function (): void {
        Livewire::test(CreateClinicModal::class)
            ->call('addClinicAction')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('clinics', [
            'organization_id' => $this->organization->id,
        ]);
    })->skip();
});
