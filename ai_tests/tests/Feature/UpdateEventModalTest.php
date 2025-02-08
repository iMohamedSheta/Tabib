<?php

use App\Livewire\App\Calendar\Includes\UpdateEventModal;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

it('renders successfully', function () {
    Livewire::test(UpdateEventModal::class)
        ->assertStatus(200);
});

it('updates an event successfully', function () {
    $event = Event::factory()->create();

    $newEventData = [
        'id' => $event->id,
        'title' => 'Updated Event Title',
        'start' => now()->addDay()->toDateTimeString(),
        'end' => now()->addDays(2)->toDateTimeString(),
    ];

    Livewire::test(UpdateEventModal::class)
        ->call('updateEventAction', $newEventData)
        ->assertDispatched('updated-event');

    $event->refresh();
    expect($event->title)->toBe('Updated Event Title');
    expect($event->start_at->toDateTimeString())->toBe(Carbon::parse($newEventData['start'])->toDateTimeString());
    expect($event->end_at->toDateTimeString())->toBe(Carbon::parse($newEventData['end'])->toDateTimeString());
});

it('updates event date successfully', function () {
    $event = Event::factory()->create();
    $newStart = now()->addDays(3)->toDateTimeString();
    $newEnd = now()->addDays(4)->toDateTimeString();
    $allDay = true;

    Livewire::test(UpdateEventModal::class)
        ->call('updateEventDateAction', $event->id, $newStart, $newEnd, $allDay)
        ->assertNoErrors();

    $event->refresh();

    expect($event->start_at->toDateTimeString())->toBe(Carbon::parse($newStart)->toDateTimeString());
    expect($event->end_at->toDateTimeString())->toBe(Carbon::parse($newEnd)->toDateTimeString());
    expect($event->all_day)->toBe($allDay);
});

it('validates input when updating event', function () {
    $event = Event::factory()->create();

    Livewire::test(UpdateEventModal::class)
        ->call('updateEventAction', [
            'id' => $event->id,
            'title' => '',
            'start' => '',
            'end' => '',
        ])
        ->assertHasErrors(['title', 'start']);
});

it('validates start date before end date when updating event', function () {
    $event = Event::factory()->create();

    Livewire::test(UpdateEventModal::class)
        ->call('updateEventAction', [
            'id' => $event->id,
            'title' => 'Invalid Date',
            'start' => now()->addDay()->toDateTimeString(),
            'end' => now()->toDateTimeString(),
        ])
        ->assertHasErrors(['end']);
});

it('validates input when updating event date', function () {
    $event = Event::factory()->create();

    Livewire::test(UpdateEventModal::class)
        ->call('updateEventDateAction', $event->id, '', '', '')
        ->assertHasErrors(['start']);
});

it('should throw an error if event is not found when updating date', function () {
    Livewire::test(UpdateEventModal::class)
        ->call('updateEventDateAction', 999, now()->toDateTimeString(), now()->addDay()->toDateTimeString(), false)
        ->assertException(Illuminate\Validation\ValidationException::class);
});
