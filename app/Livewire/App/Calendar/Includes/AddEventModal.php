<?php

namespace App\Livewire\App\Calendar\Includes;

use App\Actions\Patient\CreatePatientAction;
use App\Adapters\Dates\CalendarDatepickerAdapter;
use App\DTOs\Patient\CreatePatientDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Enums\Calendar\CalendarTypeEnum;
use App\Http\Requests\Patient\CreatePatientRequest;
use App\Models\Calendar;
use App\Models\ClinicService;
use App\Models\User;
use App\Rules\StartDateBeforeEndDate;
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

    // Step 2 Add new patient
    public $first_name = null;

    public $last_name = null;

    public $phone = null;

    public $other_phone = null;

    public $age = null;

    public $gender = null;

    public $clinic_id = null;

    // Step 3 select existing patient
    public $patient_id = null;

    // Both (Step 2, Step 3)
    public $service_id = null;

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $this->users = User::all();
        if (! blank($this->search)) {
            $this->searchResults = $this->getSearchResults();
        } else {
            $this->searchResults = [];
        }

        return view('livewire.app.calendar.includes.add-event-modal', [
            'clinicServices' => $this->getClinicServices(),
        ]);
    }

    #[Computed]
    protected function getClinicServices()
    {
        return ClinicService::list();
    }

    public function getSearchResults()
    {
        return DB::table('users')
            ->sameOrganization()
            ->isPatient()
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.username',
                'users.phone',
                'users.other_phone',
                'users.profile_photo_path',
                'patients.clinic_id',
                'patients.age',
                'patients.address',
                'patients.gender',
                'clinics.name as clinic_name',
                'clinics.id as clinic_id'
            )
            ->join('patients', 'users.id', '=', 'patients.user_id')
            ->join('clinics', 'patients.clinic_id', '=', 'clinics.id')
            ->where(function ($query) {
                $query->likeIn(['users.first_name', 'users.last_name', 'users.phone', 'users.other_phone'], $this->search);
            })
            ->take(5)
            ->get();
    }

    protected function rules()
    {
        return array_merge(
            array_only((new CreatePatientRequest(array_keys($this->clinics)))->rules(),
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'age',
                    'gender',
                    'clinic_id',
                    'other_phone',
                ]
            ),
            [
                'start' => ['required', new StartDateBeforeEndDate($this->end)],
                'end' => ['nullable', 'after_or_equal:start'],
                'service_id' => ['required', 'in:' . implode(',', array_keys($this->getClinicServices()))],
            ]
        );
    }

    public function addPatientWithEventAction()
    {
        $validatedData = $this->validate();
        try {
            $this->start = CalendarDatepickerAdapter::handle($this->start);
            $this->end = CalendarDatepickerAdapter::handle($this->end);

            $createPatientDTO = array_only($validatedData, [
                'first_name',
                'last_name',
                'phone',
                'other_phone',
                'age',
                'gender',
                'clinic_id',
            ]);
            $actionResponse = (new CreatePatientAction)->handle(
                new CreatePatientDTO(...$createPatientDTO)
            );

            $clinicService = ClinicService::find($this->service_id);

            $title = "[{$clinicService->name}] {$this->first_name} {$this->last_name}";

            $event = Calendar::create([
                'organization_id' => auth()->user()->organization_id,
                'clinic_service_id' => $this->service_id,
                'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
                'data' => json_encode([
                    'title' => $title,
                    'start' => $this->start,
                    'end' => $this->end,
                    'allDay' => $this->allDay,
                    'backgroundColor' => $clinicService->color,
                ]),
            ]);

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (! $actionResponse->success) {
                return;
            }

            $this->dispatchEventToCalendar('added', $event);
            $this->resetForm();
        } catch (\Exception $e) {
            log_error($e);
            flash()->error($this->matchStatus('server_error'));
        }
    }

    public function matchStatus($actionResponseStatus): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك باضافة مريض!!',
            ActionResponseStatusEnum::SUCCESS => 'تم انشاء المريض بنجاح',
            default => 'حدث خطاء في عملية انشاء المريض، الرجاء المحاولة لاحقاً'
        };
    }

    protected function dispatchEventToCalendar($dispatchedEvent, $event)
    {
        $data = json_decode($event->data);
        $this->dispatch($dispatchedEvent, [
            'id' => $event->id,
            'title' => $data->title,
            'start' => Carbon::parse($this->start)->toIso8601String(),
            'end' => $data->end,
            'allDay' => $data->allDay,
            'editable' => true,
            'backgroundColor' => $data->backgroundColor ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'textColor' => '#FFFFFF',
            'className' => 'event',
            // 'color' => 'red',
            // 'borderColor' => 'red',
            // 'overlap' => false,
        ]);
    }

    public function resetForm()
    {
        $this->title = null;
        $this->start = Carbon::now()->format('Y/m/d');
        $this->end = null;
        $this->allDay = true;

        $this->first_name = null;
        $this->last_name = null;
        $this->phone = null;
        $this->other_phone = null;
        $this->age = null;
        $this->gender = null;
        $this->clinic_id = null;
    }
}
