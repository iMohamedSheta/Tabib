<?php

namespace App\Livewire\App\Calendar\Includes;

use App\Models\Event;
use App\Rules\StartDateBeforeEndDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use Livewire\Component;

class UpdateEventModal extends Component
{
    public $model;

    public $update_event_id;

    public $update_allDay = false;

    public $update_start = '';

    public $update_end = '';

    public $update_title = '';

    public function render()
    {
        $this->dispatch('rendered-update-event-modal');

        return view('livewire.app.calendar.includes.update-event-modal');
    }

    #[On('updateEventAction')]
    public function updateEventAction(array $event): void
    {
        $validator = Validator::make($event, [
            'id' => ['required', 'exists:events,id'],
            'title' => ['required', 'string', 'max:255'],
            'start' => ['required', 'date', new StartDateBeforeEndDate($event['end'])],
            'end' => ['nullable', 'date', 'after_or_equal:start'],
        ]);

        if (isset($event['end'])) {
            $validator->after(function ($validator) use ($event): void {
                if (strtotime((string) $event['start']) > strtotime((string) $event['end'])) {
                    $validator->errors()->add('end', 'تاريخ النهاية يجب ان يكون اكبر من تاريخ البدء');
                }
            });
        }

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $eventId = $event['id'];
        $calendarEvent = Event::find($eventId);
        $existingData = json_decode($calendarEvent->data, true) ?? [];

        foreach ($event as $key => $value) {
            if (!blank($value) && (array_key_exists($key, $existingData) && $value != $existingData[$key] || !array_key_exists($key, $existingData) && 'id' != $key)) {
                $existingData[$key] = $value;
            }
        }
        if (isset($event['start']) && null != $event['start']) {
            $calendarEvent->start_at = Carbon::parse($existingData['start'])->toIso8601String();
        }

        if (isset($event['end']) && null != $event['end']) {
            $calendarEvent->end_at = Carbon::parse($existingData['end'])->toIso8601String();
        }

        if (isset($event['title']) && null != $event['title']) {
            $calendarEvent->title = $event['title'];
        }

        if (isset($event['allDay']) && null != $event['allDay']) {
            $calendarEvent->all_day = $event['allDay'] ? true : false;
        }

        $calendarEvent->data = $existingData;
        $calendarEvent->save();

        $this->dispatch('updated-event');
    }

    #[On('updateEventDateAction')]
    public function updateEventDateAction($id, $start, $end, $allDay): void
    {
        $event = Event::find($id);

        $validator = Validator::make([
            'event' => $event,
            'start' => $start,
            'end' => $end,
            'allDay' => $allDay,
        ], [
            'event' => ['required'],
            'start' => ['required', 'date', new StartDateBeforeEndDate($end)],
            'end' => ['nullable', 'date', 'after_or_equal:start'],
            'allDay' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            flash()->error($validator->errors()->first());
            throw new ValidationException($validator);
        }

        $event->start_at = Carbon::parse($start)->toIso8601String();

        if (!blank($end)) {
            $event->end_at = Carbon::parse($end)->toIso8601String();
        }

        $event->all_day = $allDay ? true : false;

        $event->save();
    }
}
