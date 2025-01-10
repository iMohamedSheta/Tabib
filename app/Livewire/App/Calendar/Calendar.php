<?php

namespace App\Livewire\App\Calendar;

use App\Models\Calendar as CalendarModel;
use App\Models\Clinic;
use Livewire\Component;

class Calendar extends Component
{
    public $events;

    public $config;

    public $clinics;

    public function render()
    {
        $this->config = obj([
            'slot_duration' => 5,
            'initial_view' => 'dayGridMonth', // dayGridWeek, dayGridDay, timeGridWeek, timeGridDay
        ]);

        $this->clinics = $this->getClinics();
        $this->events = CalendarModel::all()->map(function ($event): array {
            $data = $event->decoded_data; // Use the accessor

            if (! $data) {
                return []; // Skip invalid data (optional)
            }

            return [
                'id' => $event->id,
                'title' => $data->title ?? '',
                'start' => $data->start ?? null,
                'end' => $data->end ?? null,
                'allDay' => $data->allDay ?? false,
                'editable' => true,
                'backgroundColor' => $data->backgroundColor ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'textColor' => '#FFFFFF',
                'className' => 'event',
                'overlap' => $data->overlap ?? true,
                // 'borderColor' => $event->data?->borderColor ?? 'inherit',
                // 'display' => $event->data?->display ?? 'block',
                // 'allow' => $event->data?->allow ?? null,
                // 'color' => $event->data?->color ?? 'inherit',
            ];
            // $date = $event->created_at->format('Y-m-d H:i');
        })->filter();

        return view('livewire.app.calendar.calendar');
    }

    public function getClinics(): array
    {
        return Clinic::list();
    }

    public function deleteEventAction($eventId): void
    {
        CalendarModel::find($eventId)->delete();

        flash()->success('تم حذف الحجز بنجاح');

        $this->dispatch('deleted:event');
    }
}
