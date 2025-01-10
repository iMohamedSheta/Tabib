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
use App\Models\Patient;
use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\Rules\StartDateBeforeEndDate;
use App\Traits\LivewireTraits\withProfilePhotoTrait;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
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
    public $title;

    public $start;

    public $end;

    public $allDay = false;

    public $search = '';

    public $clinics = [];

    #[Locked]
    public $searchResults = [];

    // Step 2 Add new patient
    public $first_name;

    public $last_name;

    public $phone;

    public $other_phone;

    public $age;

    public $gender;

    public $clinic_id;

    // Step 3 select existing patient
    public $patient_id;

    // Both (Step 2, Step 3)
    public $service_id;

    public function render()
    {
        $this->searchResults = blank($this->search) ? [] : $this->getSearchResults();

        return view('livewire.app.calendar.includes.add-event-modal', [
            'clinicServices' => $this->getClinicServices(),
        ]);
    }

    #[Computed]
    protected function getClinicServices()
    {
        return ClinicService::list();
    }

    public function getSearchResults(): \Illuminate\Support\Collection
    {
        return PatientQueryBuilderProxy::searchPatients($this->search);
    }

    protected function rules(): array
    {
        return array_merge(
            $this->addedRules(),
            array_only(
                (new CreatePatientRequest(array_keys($this->clinics)))->rules(),
                [
                    'first_name',
                    'last_name',
                    'phone',
                    'age',
                    'gender',
                    'clinic_id',
                    'other_phone',
                ],
            ),
        );
    }

    protected function addedRules(): array
    {
        return [
            'start' => ['required', new StartDateBeforeEndDate($this->end)],
            'end' => ['nullable', 'after_or_equal:start'],
            'service_id' => ['required', 'in:' . implode(',', array_keys($this->getClinicServices()))],
        ];
    }

    protected function rulesForAddEventWithExistingPatient(): array
    {
        return array_merge(
            $this->addedRules(),
            [
                'patient_id' => ['required', 'exists:patients,id,organization_id,' . auth()->user()->organization_id],
            ],
        );
    }

    public function addPatientWithEventAction(): void
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
                new CreatePatientDTO(...$createPatientDTO),
            );

            $clinicService = ClinicService::find($this->service_id);

            $title = sprintf('[%s] %s %s', $clinicService->name, $this->first_name, $this->last_name);

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
        } catch (\Exception $exception) {
            log_error($exception);
            flash()->error($this->matchStatus('server_error'));
        }
    }

    public function addEventWithExistingPatientAction(): void
    {
        $this->validate($this->rulesForAddEventWithExistingPatient());

        try {
            $this->start = CalendarDatepickerAdapter::handle($this->start);
            $this->end = CalendarDatepickerAdapter::handle($this->end);

            $clinicService = ClinicService::findOrFail($this->service_id);

            $patient = Patient::with('user')->findOrFail($this->patient_id);

            $title = sprintf('[%s] %s %s', $clinicService->name, $patient->user->first_name, $patient->user->last_name);

            $event = Calendar::create([
                'organization_id' => auth()->user()->organization_id,
                'clinic_service_id' => $clinicService->id,
                'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
                'data' => json_encode([
                    'title' => $title,
                    'start' => $this->start,
                    'end' => $this->end,
                    'allDay' => $this->allDay,
                    'backgroundColor' => $clinicService->color,
                ]),
            ]);

            flash()->success($this->matchStatus(ActionResponseStatusEnum::SUCCESS));
            // flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            // if (! $actionResponse->success) {
            //     return;
            // }

            $this->dispatchEventToCalendar('added', $event);
            $this->resetForm();
        } catch (\Exception) {
        }
    }

    protected function matchStatus($actionResponseStatus): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بتسجيل الحجز للمريض!!',
            ActionResponseStatusEnum::SUCCESS => 'تم تسجيل الحجز للمريض بنجاح',
            default => 'حدث خطاء في عملية تسجيل الحجز  للمريض، الرجاء المحاولة لاحقاً',
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

    protected function resetForm()
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
        $this->service_id = null;
        $this->patient_id = null;
        $this->search = null;
    }
}
