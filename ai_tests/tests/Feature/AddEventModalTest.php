<?php

use App\Adapters\Dates\CalendarDatepickerAdapter;
use App\Enums\Calendar\CalendarTypeEnum;
use App\Enums\Invoice\InvoiceStatusEnum;
use App\Livewire\App\Calendar\Includes\AddEventModal;
use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\Doctor;
use App\Models\Event;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->organization = Organization::factory()->create();
    $this->user = User::factory()->create(['organization_id' => $this->organization->id]);
    $this->actingAs($this->user);

    $this->clinic = Clinic::factory()->create(['organization_id' => $this->organization->id]);
    $this->clinicService = ClinicService::factory()->create(['clinic_id' => $this->clinic->id, 'price' => 100]);
    $this->doctor = Doctor::factory()->create(['organization_id' => $this->organization->id, 'user_id' => User::factory()->create(['organization_id' => $this->organization->id])->id]);
});

it('renders successfully', function (): void {
    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->assertStatus(200);
});

it('can search patients', function (): void {
    $patient = Patient::factory()->create(['organization_id' => $this->organization->id]);
    $user = User::find($patient->user_id);

    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->set('search', $user->first_name)
        ->assertSee($user->first_name);
});

it('can search doctors', function (): void {
    $doctorUser = User::find($this->doctor->user_id);
    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->set('searchDoctor', $doctorUser->first_name)
        ->assertSee($doctorUser->first_name);
});

it('can add a new patient with an event', function (): void {
    $startDate = Carbon::now()->format('Y/m/d');
    $endDate = Carbon::now()->addDay()->format('Y/m/d');

    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->set('first_name', 'John')
        ->set('last_name', 'Doe')
        ->set('phone', '1234567890')
        ->set('age', 30)
        ->set('gender', 'male')
        ->set('clinic_id', $this->clinic->id)
        ->set('service_id', $this->clinicService->id)
        ->set('doctor_id', $this->doctor->id)
        ->set('start', $startDate)
        ->set('end', $endDate)
        ->call('addPatientWithEventAction')
        ->assertDispatched('added-event');

    $this->assertDatabaseHas('patients', [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '1234567890',
        'age' => 30,
        'gender' => 'male',
        'clinic_id' => $this->clinic->id,
        'organization_id' => $this->organization->id,
    ]);

    $this->assertDatabaseHas('events', [
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
        'doctor_id' => $this->doctor->id,
        'clinic_service_id' => $this->clinicService->id,
        'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
        'start_at' => CalendarDatepickerAdapter::handle($startDate),
        'end_at' => $endDate,
    ]);
});

it('can add an event with an existing patient', function (): void {
    $patient = Patient::factory()->create(['organization_id' => $this->organization->id]);

    $startDate = Carbon::now()->format('Y/m/d');
    $endDate = Carbon::now()->addDay()->format('Y/m/d');

    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->set('patient_id', $patient->id)
        ->set('clinic_id', $this->clinic->id)
        ->set('service_id', $this->clinicService->id)
        ->set('doctor_id', $this->doctor->id)
        ->set('start', $startDate)
        ->set('end', $endDate)
        ->call('addEventWithExistingPatientAction')
        ->assertDispatched('added-event');

    $this->assertDatabaseHas('events', [
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
        'doctor_id' => $this->doctor->id,
        'patient_id' => $patient->id,
        'clinic_service_id' => $this->clinicService->id,
        'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
        'start_at' => CalendarDatepickerAdapter::handle($startDate),
        'end_at' => $endDate,
    ]);
});

it('can confirm invoice receipt', function (): void {
    $patient = Patient::factory()->create(['organization_id' => $this->organization->id]);
    $event = Event::factory()->create([
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
        'patient_id' => $patient->id,
        'clinic_service_id' => $this->clinicService->id,
    ]);

    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->set('invoiceView.event_id', $event->id)
        ->set('paid_price', 50)
        ->call('confirmInvoiceReceiptAction')
        ->assertDispatched('added');

    $this->assertDatabaseHas('invoices', [
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
        'patient_id' => $patient->id,
        'price' => $this->clinicService->price,
        'paid_price' => 50,
        'status' => InvoiceStatusEnum::PENDING->value,
    ]);
});

it('shows error if paid price is more than service price', function (): void {
    $patient = Patient::factory()->create(['organization_id' => $this->organization->id]);
    $event = Event::factory()->create([
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
        'patient_id' => $patient->id,
        'clinic_service_id' => $this->clinicService->id,
    ]);

    Livewire::test(AddEventModal::class, ['clinics' => [$this->clinic->id => $this->clinic->name]])
        ->set('invoiceView.event_id', $event->id)
        ->set('paid_price', 150)
        ->call('confirmInvoiceReceiptAction')
        ->assertHasErrors(['paid_price']);

    $this->assertDatabaseMissing('invoices', [
        'organization_id' => $this->organization->id,
        'clinic_id' => $this->clinic->id,
        'patient_id' => $patient->id,
        'price' => $this->clinicService->price,
        'paid_price' => 150,
    ]);
});
