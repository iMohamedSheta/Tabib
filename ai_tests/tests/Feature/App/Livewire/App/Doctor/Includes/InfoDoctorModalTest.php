<?php

use App\Livewire\App\Doctor\Includes\InfoDoctorModal;
use App\Models\Doctor;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->doctor = Doctor::factory()->create();
    $this->clinics = [1 => 'Clinic 1', 2 => 'Clinic 2'];
    $this->mountingData = ['doctor' => $this->doctor, 'clinics' => $this->clinics];
});

it('renders successfully', function (): void {
    Livewire::test(InfoDoctorModal::class, $this->mountingData)
        ->assertStatus(200);
});

it('passes doctor and clinics data to the view', function (): void {
    Livewire::test(InfoDoctorModal::class, $this->mountingData)
        ->assertSet('doctor', $this->doctor)
        ->assertSet('clinics', $this->clinics);
});

it('should have doctor property locked', function (): void {
    $component = Livewire::test(InfoDoctorModal::class, $this->mountingData);

    $propertyName = 'doctor';
    $propertyInfo = new ReflectionProperty($component->instance()::class, $propertyName);

    $attributes = $propertyInfo->getAttributes();

    $hasLockedAttribute = false;
    foreach ($attributes as $attribute) {
        if (\Livewire\Attributes\Locked::class === $attribute->getName()) {
            $hasLockedAttribute = true;
            break;
        }
    }

    expect($hasLockedAttribute)->toBeTrue();
});
