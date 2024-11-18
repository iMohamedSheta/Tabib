<?php

namespace App\Livewire\App\Calendar\Includes;

use App\Adapters\Dates\CalendarDatepickerAdapter;
use App\Framework\QueryBuilder\DB as QueryBuilderDB;
use App\Models\Calendar;
use App\Models\Patient;
use App\Models\User;
use App\Services\User\GetProfilePhotoUrlService;
use App\Traits\LivewireTraits\withProfilePhotoTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AddEventModal extends Component
{

    use withProfilePhotoTrait;
    /*
    |------------------------------------------
    |  EventObject:
    |------------------------------------------
    |   'id' => $event->id,
    |   'title' => $event->data->title,
    |   'start' => $event->data->start_at,
    |   'end' => $event->data->end_at,
    |   'allDay' => $event->data->all_day,
    |   'editable' => true,
    |   'borderColor' => 'red',
    |   'backgroundColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
    |   'color' => 'red',
    |   'textColor' => '#FFFFFF',
    |   'className' => 'event',
    |   'overlap' => true,
    |--------------------------------------------
    */
    public $title = null;
    public $start = null;
    public $end = null;
    public $allDay = false;

    public $clinics = [];
    public $users;

    public $search = '';
    public $searchResults = [];

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {

        $this->users = User::all();
        if (!blank($this->search)) {
            $this->searchResults = $this->getSearchResults();
        } else {
            $this->searchResults = [];
        }

        return view('livewire.app.calendar.includes.add-event-modal');
    }


    public function getSearchResults()
    {
        return DB::table('users')
            ->sameOrganization()
            ->isPatient()
            ->join('patients', 'users.id', '=', 'patients.user_id')
            ->where(function ($query) {
                $query->likeIn(['users.first_name', 'users.last_name', 'users.phone', 'users.other_phone'], $this->search);
            })
            ->take(5)
            ->get();
    }

    protected function rules()
    {
        return [
            'title' => 'required',
            'start' => 'required',
            'end' => 'nullable',
            'allDay' => 'required',
        ];

    }
    public function addEventAction()
    {
        $this->validate();

        $this->start = CalendarDatepickerAdapter::handle($this->start);
        $this->end = CalendarDatepickerAdapter::handle($this->end);

        $event = Calendar::create([
            'data' => json_encode([
                'title' => $this->title,
                'start' => $this->start,
                'end' => $this->end,
                'allDay' => $this->allDay
            ]),
        ]);

        flash()->success('تمت العملية بنجاح');

        $data = json_decode($event->data);
        $this->dispatch('eventAdded', [
            'id' => $event->id,
            'title' => $data->title,
            'start' => Carbon::parse($this->start)->toIso8601String(),
            'end' => $data->end,
            'allDay' => $data->allDay,
            'editable' => true,
            'borderColor' => 'red',
            'backgroundColor' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'color' => 'red',
            'textColor' =>  '#FFFFFF',
            'className' => 'event',
            // 'overlap' => false,
        ]);

        $this->resetForm();
    }

    public function resetForm()
    {
        $this->title = null;
        $this->start = Carbon::now()->format('Y/m/d');
        $this->end = null;
        $this->allDay = true;
    }
}
