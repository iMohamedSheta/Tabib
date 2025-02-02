<?php

use App\Actions\ClinicService\UpdateClinicServiceAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Livewire\App\ClinicService\Includes\UpdateClinicServiceModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\ClinicService;
use App\Models\Organization;
use App\Models\User;
use App\Responses\ActionResponse;
use Livewire\Livewire;

describe('UpdateClinicServiceModal [Livewire-Component]', function (): void {
    beforeEach(function (): void {
        $this->organization = Organization::factory()->create();

        $this->user = User::factory()->create([
            'organization_id' => $this->organization->id,
            'role' => ClinicAdmin::class,
        ]);

        $this->actingAs($this->user);

        $this->clinic = Clinic::factory()->create([
            'organization_id' => $this->organization->id,
        ]);
        $this->clinics = [$this->clinic->id => $this->clinic->name];

        $this->clinicService = ClinicService::factory()->create([
            'clinic_id' => $this->clinic->id,
            'organization_id' => $this->organization->id,
        ]);

        $this->mountingData = [
            'clinicService' => $this->clinicService,
            'clinics' => $this->clinics,
        ];
    });

    it('mounts with clinic service data', function (): void {
        Livewire::test(UpdateClinicServiceModal::class, $this->mountingData)
            ->assertSet('clinicServiceId', $this->clinicService->id)
            ->assertSet('name', $this->clinicService->name)
            ->assertSet('price', $this->clinicService->price)
            ->assertSet('description', $this->clinicService->description)
            ->assertSet('color', $this->clinicService->color)
            ->assertSet('clinic_id', $this->clinicService->clinic_id);
    });

    it('renders successfully', function (): void {
        Livewire::test(UpdateClinicServiceModal::class, $this->mountingData)
            ->assertStatus(200);
    });

    it('validates the input correctly', function (): void {
        Livewire::test(UpdateClinicServiceModal::class, $this->mountingData)
            ->set('name', '')
            ->set('price', '')
            ->set('description', '')
            ->set('color', '')
            ->set('clinic_id', '')
            ->call('updateClinicServiceAction')
            ->assertHasErrors(['name', 'price']);
    });

    it('updates a clinic service successfully', function (): void {
        Livewire::test(UpdateClinicServiceModal::class, $this->mountingData)
            ->set('name', 'Updated Service')
            ->set('price', 150.00)
            ->set('description', 'Updated Description')
            ->set('color', '#000000')
            ->set('clinicServiceId', $this->clinicService->id)
            ->call('updateClinicServiceAction')
            ->assertHasNoErrors()
            ->assertDispatched('updated');

        $this->assertDatabaseHas('clinic_services', [
            'id' => $this->clinicService->id,
            'name' => 'Updated Service',
            'price' => 150.00,
            'description' => 'Updated Description',
            'color' => '#000000',
        ]);
    });

    it('handles update failure due to authorization', function (): void {
        $unauthorizedUser = User::factory()->create(['organization_id' => $this->organization->id]);
        $this->actingAs($unauthorizedUser);

        $actionMock = Mockery::mock(UpdateClinicServiceAction::class);
        $actionMock->shouldReceive('handle')
            ->once()
            ->andReturn(new ActionResponse(
                success: false,
                status: ActionResponseStatusEnum::AUTHORIZE_ERROR,
                message: 'غير مسموح لك بتعديل خدمة طبية!!'
            ));

        app()->bind(UpdateClinicServiceAction::class, fn () => $actionMock);

        Livewire::test(UpdateClinicServiceModal::class, $this->mountingData)
            ->set('name', 'Updated Service')
            ->set('price', 150.00)
            ->set('description', 'Updated Description')
            ->set('color', '#000000')
            ->set('clinic_id', $this->clinic->id)
            ->call('updateClinicServiceAction')
            ->assertNotDispatched('updated');
    });

    it('handles update failure due to general error', function (): void {
        $actionMock = Mockery::mock(UpdateClinicServiceAction::class);
        $actionMock->shouldReceive('handle')
            ->once()
            ->andThrow(new Exception('General error'));

        app()->bind(UpdateClinicServiceAction::class, fn () => $actionMock);

        Livewire::test(UpdateClinicServiceModal::class, $this->mountingData)
            ->set('name', 'Updated Service')
            ->set('price', 150.00)
            ->set('description', 'Updated Description')
            ->set('color', '#000000')
            ->set('clinic_id', $this->clinic->id)
            ->call('updateClinicServiceAction')
            ->assertNotDispatched('updated');
    });
});
