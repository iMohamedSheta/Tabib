<?php

namespace App\Livewire\App\Calendar\Includes;

use App\Models\Calendar;
use App\Rules\StartDateBeforeEndDate;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateEventModal extends Component
{

    public $model = null;

    public $update_event_id = null;
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
    public function updateEventAction($event)
    {
        $validator = Validator::make($event, [
            'id' => ['required', 'exists:calendars,id'],
            'title' => ['required', 'string', 'max:255'],
            'start' => ['required', 'date', new StartDateBeforeEndDate($event['end'])],
            'end' => ['nullable', 'date', 'after_or_equal:start']
        ]);

        if (isset($event['end'])) {
            $validator->after(function ($validator) use ($event) {
                if (strtotime($event['start']) > strtotime($event['end'])) {
                    $validator->errors()->add('end', 'تاريخ النهاية يجب ان يكون اكبر من تاريخ البدء');
                }
            });
        }


        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $eventId = $event['id'];
        $calendarEvent = Calendar::find($eventId);
        $existingData = json_decode($calendarEvent->data, true) ?? [];

        foreach ($event as $key => $value) {
            if (!blank($value)) {
                if ((array_key_exists($key, $existingData) && $value != $existingData[$key] || !array_key_exists($key, $existingData) && $key != 'id')) {

                    if (in_array($key, ['start', 'end'])) {
                        $existingData[$key] = Carbon::parse($value)->toIso8601String();
                    } else {
                        $existingData[$key] = $value;
                    }
                }
            }
        }

        $calendarEvent->data = $existingData;
        $calendarEvent->save();

        $this->dispatch('updated-event');
    }

    #[On('updateEventDateAction')]
    public function updateEventDateAction($id, $start, $end, $allDay)
    {
        $event = Calendar::find($id);
        $event->data = json_decode($event->data);
        $event->data->start = $start;
        $event->data->end = $end;
        $event->data->allDay = $allDay;
        $event->data = json_encode($event->data);
        $event->save();
    }
}
