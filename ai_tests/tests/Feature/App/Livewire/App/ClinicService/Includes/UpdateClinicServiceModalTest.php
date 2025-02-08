<?php

use App\Actions\ClinicService\UpdateClinicServiceAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal;
use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();

    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);

    $this->clinic = Clinic::factory()->create(['organization_id' => $this->organization->id]);

    $this->clinicService = ClinicService::factory()->create(['clinic_id' => $this->clinic->id]);

    $this->clinics = [$this->clinic->id => $this->clinic->name];

    $this->actingAs($this->user);
});

it('renders successfully with localized content', function (): void {
    Livewire::test(UpdateClinicServiceModal::class, ['clinicService' => $this->clinicService, 'clinics' => $this->clinics])
        ->assertSee('تعديل');
});

it('updates a clinic service successfully', function (): void {
    Livewire::test(UpdateClinicServiceModal::class, [
        'clinicService' => $this->clinicService,
        'clinics' => $this->clinics,
    ])
        ->set('name', 'Updated Service Name')
        ->set('price', 150.00)
        ->set('description', 'Updated description')
        ->set('color', '#FFFFFF')
        ->set('clinic_id', $this->clinic->id)
        ->call('updateClinicServiceAction')
        ->assertDispatched('updated');

    $this->assertDatabaseHas('clinic_services', [
        'id' => $this->clinicService->id,
        'name' => 'Updated Service Name',
        'price' => 150.00,
        'description' => 'Updated description',
        'color' => '#FFFFFF',
        'clinic_id' => $this->clinic->id,
    ]);
});

it('validates the input correctly', function (): void {
    Livewire::test(UpdateClinicServiceModal::class, [
        'clinicService' => $this->clinicService,
        'clinics' => $this->clinics,
    ])
        ->set('name', '')
        ->set('price', 'invalid')
        ->set('description', '')
        ->set('color', '')
        ->set('clinic_id', null)
        ->call('updateClinicServiceAction')
        ->assertHasErrors(['name', 'price', 'clinic_id']);
});

it('flashes an error message when the update action fails', function (): void {
    $this->mock(UpdateClinicServiceAction::class, function ($mock) {
        $mock->shouldReceive('handle')
            ->once()
            ->andReturn((object) [
                'success' => false,
                'status' => ActionResponseStatusEnum::AUTHORIZE_ERROR,
            ]);
    });

    Livewire::test(UpdateClinicServiceModal::class, [
        'clinicService' => $this->clinicService,
        'clinics' => $this->clinics,
    ])
        ->set('name', 'Updated Service Name')
        ->set('price', 150.00)
        ->set('description', 'Updated description')
        ->set('color', '#FFFFFF')
        ->set('clinic_id', $this->clinic->id)
        ->call('updateClinicServiceAction');

    expect(session('flash.message'))->toBe('غير مسموح لك بتعديل خدمة طبية!!');
});
