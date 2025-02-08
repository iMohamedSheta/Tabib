<?php

use App\Livewire\App\Calendar\Calendar;
use App\Models\Clinic;
use App\Models\Event;
use Livewire\Livewire;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    // Create a clinic for testing
    $this->clinic = Clinic::factory()->create();

    // Create some events for testing
    $this->events = Event::factory(3)->create();
});

it('can render the calendar component', function (): void {
    Livewire::test(Calendar::class)
        ->assertStatus(200);
});

it('fetches events and formats them correctly', function (): void {
    // Create some events
    $events = Event::factory(2)->create([
        'title' => 'Test Event',
        'start_at' => now(),
        'end_at' => now()->addHour(),
        'all_day' => false,
        'data' => json_encode(['backgroundColor' => '#000000', 'overlap' => false]),
    ]);

    Livewire::test(Calendar::class)
        ->assertViewHas('events', Event::all()->map(function ($event): array {
            $data = json_decode($event->data);

            return [
                'id' => $event->id,
                'title' => $event->title ?? '',
                'start' => $event->start_at ?? null,
                'end' => $event->end_at ?? null,
                'allDay' => $event->all_day ?? false,
                'editable' => true,
                'backgroundColor' => $data->backgroundColor ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'textColor' => '#FFFFFF',
                'className' => 'event',
                'overlap' => $data->overlap ?? false,
            ];
        })->toArray());
});

it('can delete an event', function (): void {
    $event = Event::factory()->create();

    Livewire::test(Calendar::class)
        ->call('deleteEventAction', $event->id)
        ->assertDispatched('deleted:event');

    $this->assertDatabaseMissing('events', ['id' => $event->id]);
});

it('can get a list of clinics', function (): void {
    $clinics = Clinic::factory(2)->create();

    $expectedClinics = Clinic::all()->pluck('name', 'id')->toArray();

    Livewire::test(Calendar::class)
        ->call('getClinics')
        ->assertReturn($expectedClinics);
});
