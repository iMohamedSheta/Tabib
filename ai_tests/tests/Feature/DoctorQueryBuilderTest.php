<?php

use App\Models\Doctor;
use App\Models\Organization;
use App\Models\User;
use App\QueryBuilders\DoctorQueryBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    $this->doctor = Doctor::factory()->create(['organization_id' => $this->organization->id, 'user_id' => $this->user->id]);
    $this->doctorQueryBuilder = new DoctorQueryBuilder();
});

it('can get organization doctors', function (): void {
    $doctors = $this->doctorQueryBuilder->getOrganizationDoctors()->get();

    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->doctor_id)->toEqual($this->doctor->id);
    expect($doctors->first()->organization_id)->toEqual($this->organization->id);
});

it('can search doctors by first name', function (): void {
    $search = $this->user->first_name;
    $doctors = $this->doctorQueryBuilder->searchDoctors($search)->get();

    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->doctor_id)->toEqual($this->doctor->id);
});

it('can search doctors by last name', function (): void {
    $search = $this->user->last_name;
    $doctors = $this->doctorQueryBuilder->searchDoctors($search)->get();

    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->doctor_id)->toEqual($this->doctor->id);
});

it('can search doctors by phone', function (): void {
    $search = $this->user->phone;
    $doctors = $this->doctorQueryBuilder->searchDoctors($search)->get();

    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->doctor_id)->toEqual($this->doctor->id);
});

it('can search doctors by specialization', function (): void {
    $search = $this->doctor->specialization;
    $doctors = $this->doctorQueryBuilder->searchDoctors($search)->get();

    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->doctor_id)->toEqual($this->doctor->id);
});

it('returns empty collection when no doctors match search term', function (): void {
    $search = 'nonexistent';
    $doctors = $this->doctorQueryBuilder->searchDoctors($search)->get();

    expect($doctors)->toBeEmpty();
});

it('can search doctors by concatenated first and last name', function (): void {
    $search = $this->user->first_name . ' ' . $this->user->last_name;
    $doctors = $this->doctorQueryBuilder->searchDoctors($search)->get();

    expect($doctors)->toHaveCount(1);
    expect($doctors->first()->doctor_id)->toEqual($this->doctor->id);
});
