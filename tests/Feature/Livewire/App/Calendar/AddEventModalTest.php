<?php

use App\Adapters\Dates\CalendarDatepickerAdapter;
use App\Enums\Calendar\CalendarTypeEnum;
use App\Enums\Invoice\InvoiceStatusEnum;
use App\Livewire\App\Calendar\Includes\AddEventModal;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\ClinicService;
use App\Models\Doctor;
use App\Models\Event;
use App\Models\Invoice;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Livewire\Livewire;

describe('AddEventModal [Livewire-Component]', function () {
    beforeEach(function (): void {
        $this->organization = Organization::factory()->create();

        // Create a ClinicAdmin user for the organization
        $this->user = User::factory()->create([
            'organization_id' => $this->organization->id,
            'role' => ClinicAdmin::class,
        ]);

        // Create a clinic for the organization
        $clinic = Clinic::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $this->clinicService = ClinicService::factory()->create([
            'organization_id' => $this->organization->id,
            'clinic_id' => $clinic->id,
        ]);

        $this->doctor = Doctor::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $this->clinics = [$clinic->id => $clinic->name];
        $this->mountingData = ['clinics' => $this->clinics];

        $this->clinicId = $clinic->id;
        $this->serviceId = $this->clinicService->id;

        // Create a ClinicAdmin model linked to the created user
        $this->clinicAdmin = ClinicAdmin::factory()->create([
            'organization_id' => $this->organization->id,
            'user_id' => $this->user->id,
        ]);

        $this->actingAs($this->user);
    });

    it('renders successfully', function (): void {
        Livewire::test(AddEventModal::class)
            ->assertStatus(200);
    });

    it('validates the input correctly when adding a new patient', function (): void {
        Livewire::test(AddEventModal::class)
            ->set('start', '')
            ->set('end', '')
            ->set('first_name', '')
            ->set('last_name', '')
            ->set('phone', '')
            ->set('age', '')
            ->set('gender', '')
            ->set('clinic_id', '')
            ->set('service_id', '')
            ->call('addPatientWithEventAction')
            ->assertHasErrors(['start', 'first_name', 'last_name', 'phone', 'age', 'gender', 'clinic_id', 'service_id']);
    });

    it('can add an event with a new patient', function (): void {
        $startDate = '2025/01/13 7:40م (اثنين)';

        Livewire::test(AddEventModal::class)
            ->set('clinics', $this->mountingData['clinics'])
            ->set('start', $startDate)
            ->set('end', null)
            ->set('first_name', 'John')
            ->set('last_name', 'Doe')
            ->set('phone', '1234567890')
            ->set('service_id', $this->serviceId)
            ->set('age', 30)
            ->set('gender', 'male')
            ->set('clinic_id', $this->clinicId)
            ->set('doctor_id', $this->doctor->id)
            ->call('addPatientWithEventAction')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '1234567890',
            'role' => Patient::class,
        ]);

        $this->assertDatabaseHas('events', [
            'start_at' => CalendarDatepickerAdapter::handle($startDate),
            'end_at' => null,
        ]);

        expect(Event::count())->toBe(1);
        $event = Event::first();
        expect($event->title)->toContain('John Doe');

        $this->assertDatabaseHas('patients', [
            'organization_id' => $this->organization->id,
        ]);

        $patient = Patient::first();
        expect($patient->user->first_name)->toBe('John');
        expect($patient->user->last_name)->toBe('Doe');
    });

    it('validates the input correctly when adding with an existing patient', function (): void {
        Livewire::test(AddEventModal::class)
            ->set('start', '')
            ->set('service_id', '')
            ->set('patient_id', '')
            ->set('clinic_id', '')
            ->call('addEventWithExistingPatientAction')
            ->assertHasErrors(['start', 'patient_id', 'service_id', 'clinic_id']);
    });

    it('can add an event with an existing patient', function (): void {
        $patient = Patient::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $startDate = '2025/01/13 7:40م (اثنين)';

        Livewire::test(AddEventModal::class)
            ->set('start', $startDate)
            ->set('end', $startDate)
            ->set('clinics', $this->mountingData['clinics'])
            ->set('service_id', $this->serviceId)
            ->set('patient_id', $patient->id)
            ->set('clinic_id', $this->clinicId)
            ->set('doctor_id', $this->doctor->id)
            ->call('addEventWithExistingPatientAction')
            ->assertHasNoErrors();

        expect(Event::count())->toBe(1);
        $event = Event::first();
        expect($event->title)->toContain($patient->user->first_name . ' ' . $patient->user->last_name);
    });

    it('validates confirm invoice input', function (): void {
        Livewire::test(AddEventModal::class)
            ->set('invoiceView.event_id', '')
            ->set('paid_price', '')
            ->call('confirmInvoiceReceiptAction')
            ->assertHasErrors(['invoiceView.event_id', 'paid_price']);
    });

    it('can confirm invoice receipt', function (): void {
        $patient = Patient::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $startDate = '2025/01/13 7:40م (اثنين)';

        $event = Event::create([
            'organization_id' => $this->organization->id,
            'clinic_id' => $this->clinicId,
            'patient_id' => $patient->id,
            'clinic_service_id' => $this->serviceId,
            'created_by' => $this->user->id,
            'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
            'title' => 'test',
            'start_at' => CalendarDatepickerAdapter::handle($startDate),
            'end_at' => null,
            'all_day' => false,
            'data' => json_encode(['backgroundColor' => '#ffffff']),
        ]);

        Livewire::test(AddEventModal::class)
            ->set('invoiceView.event_id', $event->id)
            ->set('paid_price', $this->clinicService->price)
            ->call('confirmInvoiceReceiptAction')
            ->assertHasNoErrors();

        expect(Invoice::count())->toBe(1);
        $invoice = Invoice::first();
        expect($invoice->status)->toBe(InvoiceStatusEnum::PAID->value);
    });

    it('can confirm invoice receipt with pending status', function (): void {
        $patient = Patient::factory()->create([
            'organization_id' => $this->organization->id,
        ]);

        $startDate = '2025/01/13 7:40م (اثنين)';

        $event = Event::create([
            'organization_id' => $this->organization->id,
            'clinic_id' => $this->clinicId,
            'patient_id' => $patient->id,
            'clinic_service_id' => $this->serviceId,
            'created_by' => $this->user->id,
            'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
            'title' => 'test',
            'start_at' => CalendarDatepickerAdapter::handle($startDate),
            'end_at' => null,
            'all_day' => false,
            'data' => json_encode(['backgroundColor' => '#ffffff']),
        ]);

        Livewire::test(AddEventModal::class)
            ->set('invoiceView.event_id', $event->id)
            ->set('paid_price', $this->clinicService->price - 1)
            ->call('confirmInvoiceReceiptAction')
            ->assertHasNoErrors()
            ->assertDispatched('added');

        expect(Invoice::count())->toBe(1);
        $invoice = Invoice::first();
        expect($invoice->status)->toBe(InvoiceStatusEnum::PENDING->value);
    });
});
