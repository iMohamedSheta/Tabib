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
        $this->events = CalendarModel::all()->map(function ($event) {
            $event->data = json_decode($event->data);
            // $date = $event->created_at->format('Y-m-d H:i');
            return [
                'id' => $event->id,
                'title' =>  $event->data->title,
                'start' => $event->data->start,
                'end' => $event->data->end ?? null,
                'allDay' => $event->data->allDay ?? false,
                'editable' => true,
                // 'borderColor' => $event->data?->borderColor ?? 'inherit',
                'backgroundColor' => $event->data->backgroundColor ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                // 'color' => $event->data?->color ?? 'inherit',
                'textColor' => '#FFFFFF',
                'className' => 'event',
                'overlap' => $event->data->overlap ?? true,
                // 'display' => $event->data?->display ?? 'block',
                // 'allow' => $event->data?->allow ?? null,
            ];
        });

        return view('livewire.app.calendar.calendar');
    }

    public function getClinics()
    {
        return Clinic::list();
    }

    public function deleteEventAction($eventId)
    {
        CalendarModel::find($eventId)->delete();

        flash()->success('تم حذف الحجز بنجاح');

        $this->dispatch('deleted:event');
    }
}
