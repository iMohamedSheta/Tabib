<?php

use App\Livewire\App\Calendar\Calendar;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\ClinicService;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use Livewire\Livewire;

describe('Calendar [Livewire-Component]', function () {
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

    it('mounts and retrieves events with correct format', function (): void {
        Event::factory()->create([
            'data' => json_encode(['backgroundColor' => '#ff0000', 'overlap' => true]),
            'clinic_id' => $this->clinic->id,
            'organization_id' => $this->organization->id,
        ]);
        Event::factory()->create(
            [
                'data' => json_encode(['backgroundColor' => '#1f1f1f', 'editable' => true, 'textColor' => '#FFFFFF']),
                'clinic_id' => $this->clinic->id,
                'organization_id' => $this->organization->id,
                'all_day' => false,
            ]
        );

        Livewire::test(Calendar::class)
            ->assertViewHas('events')
            ->assertViewHas('config')
            ->assertViewHas('clinics');

        $events = Livewire::test(Calendar::class)->get('events');

        expect($events)->toBeArray();
        expect($events)->toHaveCount(2);
        expect($events[0]['backgroundColor'])->toBe('#ff0000');
        expect($events[0]['overlap'])->toBeTrue();
        expect($events[1])->toBeArray();
        expect($events[1]['backgroundColor'])->toBe('#1f1f1f');
        expect($events[1]['allDay'])->toBe(0);
        expect($events[1]['editable'])->toBeTrue();
        expect($events[1]['textColor'])->toBe('#FFFFFF');
    });

    it('renders the calendar view with config', function (): void {
        Livewire::test(Calendar::class)
            ->assertViewIs('livewire.app.calendar.calendar')
            ->assertViewHas('config')
            ->assertViewHas('clinics');
    });

    it('get clinics list', function (): void {
        Clinic::factory()->count(2)->create(
            [
                'organization_id' => $this->organization->id,
            ]
        );
        $clinics = Livewire::test(Calendar::class)->call('getClinics')->get('clinics');
        expect($clinics)->toBeArray();
        expect($clinics)->toHaveCount(3);
    });

    it('deletes an event and dispatches a success message', function (): void {
        $event = Event::factory()->create(
            [
                'data' => json_encode(['backgroundColor' => '#ff0000', 'overlap' => true]),
                'clinic_id' => $this->clinic->id,
                'organization_id' => $this->organization->id,
            ]
        );

        $this->assertDatabaseHas('events', ['id' => $event->id]);

        Livewire::test(Calendar::class)
            ->call('deleteEventAction', $event->id)
            ->assertDispatched('deleted:event');

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    });
});
