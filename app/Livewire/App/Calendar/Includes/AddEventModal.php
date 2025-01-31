<?php

namespace App\Livewire\App\Calendar\Includes;

use App\Actions\Patient\CreatePatientAction;
use App\Adapters\Dates\CalendarDatepickerAdapter;
use App\DTOs\Patient\CreatePatientDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Enums\Calendar\CalendarTypeEnum;
use App\Enums\Invoice\InvoiceStatusEnum;
use App\Enums\Invoice\InvoiceTypeEnum;
use App\Http\Requests\Patient\CreatePatientRequest;
use App\Models\ClinicService;
use App\Models\Event;
use App\Models\Patient;
use App\Proxy\QueryBuilders\DoctorQueryBuilderProxy;
use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\Rules\StartDateBeforeEndDate;
use App\Traits\LivewireTraits\withProfilePhotoTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public $searchDoctor = '';
    public $searchDoctor2 = '';
    public $clinics = [];
    #[Locked]
    public $searchResults = [];
    #[Locked]
    public $searchDoctorResults = [];

    // Step 2 Add new patient
    public $first_name;
    public $last_name;
    public $phone;
    public $other_phone;
    public $age;
    public $gender;

    // Step 3 select existing patient
    public $patient_id;

    // Both (Step 2, Step 3)
    public $service_id;
    public $clinic_id;
    public $doctor_id;

    // Step 4
    public $invoiceView = [];
    public $paid_price = 0;

    public function render()
    {
        $this->searchResults = blank($this->search) ? [] : $this->getSearchResults();
        $this->searchDoctorResults = blank($this->searchDoctor) && blank($this->searchDoctor2) ? [] : $this->getSearchDoctorResults();

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

    public function getSearchDoctorResults(): \Illuminate\Support\Collection
    {
        return DoctorQueryBuilderProxy::searchDoctors($this->searchDoctor ?? $this->searchDoctor2);
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
            array_only(
                (new CreatePatientRequest(array_keys($this->clinics)))->rules(),
                [
                    'clinic_id',
                ],
            ),
            [
                'patient_id' => ['required', 'exists:patients,id,organization_id,' . Auth::user()->organization_id],
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
            $actionResponse = (new CreatePatientAction())->handle(
                new CreatePatientDTO(...$createPatientDTO),
            );

            $clinicService = ClinicService::find($this->service_id);
            $authUser = Auth::user();
            $doctor = DB::table('doctors')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->select(['users.first_name', 'users.last_name'])
                ->first();

            $patientName = sprintf('%s %s', $this->first_name, $this->last_name);
            $doctorName = $doctor->first_name . ' ' . $doctor->last_name;

            $title = sprintf('[%s] %s', $clinicService->name, $patientName);

            $event = Event::create([
                'organization_id' => $authUser->organization_id,
                'clinic_id' => $this->clinic_id,
                'patient_id' => $this->patient_id,
                'doctor_id' => $this->doctor_id,
                'clinic_service_id' => $this->service_id,
                'created_by' => $authUser->id,
                'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,
                'title' => $title,
                'start_at' => $this->start,
                'end_at' => $this->end,
                'all_day' => $this->allDay,
                'data' => json_encode([
                    'doctor_name' => $doctorName,
                    'backgroundColor' => $clinicService->color,
                ]),
            ]);

            // flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) {
                return;
            }

            $this->setInvoiceViewInfo($event, $clinicService, $patientName, $doctorName);

            $this->dispatchEventToCalendar('added-event', $event);
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

            $authUser = Auth::user();

            $patient = Patient::with('user')->findOrFail($this->patient_id);
            $doctor = DB::table('doctors')
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->select(['users.first_name', 'users.last_name'])
                ->first();

            $patientName = sprintf('%s %s', $patient->user->first_name, $patient->user->last_name);
            $doctorName = $doctor->first_name . ' ' . $doctor->last_name;

            $title = sprintf('[%s] %s', $clinicService->name, $patientName);

            $event = Event::create([
                'organization_id' => $authUser->organization_id,
                'clinic_id' => $this->clinic_id,
                'doctor_id' => $this->doctor_id,
                'patient_id' => $this->patient_id,
                'clinic_service_id' => $this->service_id,
                'created_by' => $authUser->id,
                'type' => CalendarTypeEnum::PATIENT_APPOINTMENT,

                'title' => $title,
                'start_at' => $this->start,
                'end_at' => $this->end,
                'all_day' => $this->allDay,
                'data' => json_encode([
                    'clinic_service_name' => $clinicService->name,
                    'patient_name' => $patientName,
                    'doctor_name' => $doctorName,
                    'backgroundColor' => $clinicService->color,
                ]),
            ]);

            // flash()->success($this->matchStatus(ActionResponseStatusEnum::SUCCESS));

            $this->setInvoiceViewInfo($event, $clinicService, $patientName, $doctorName);
            $this->dispatchEventToCalendar('added-event', $event);
        } catch (\Exception $e) {
            log_error($e);
        }
    }

    public function confirmInvoiceReceiptAction(): void
    {
        $this->validate([
            'invoiceView.event_id' => ['required', 'integer'],
            'paid_price' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $status = InvoiceStatusEnum::PENDING->value;

            $event = Event::with(['clinicService', 'patient'])->findOrFail($this->invoiceView['event_id']);

            if ($this->paid_price > $event->clinicService->price) {
                $this->addError('paid_price', __('المبلغ المدفوع يجب ان يكون اصغر او مساوي للمبلغ المطلوب!'));

                return;
            }

            if ($event->clinicService->price == $this->paid_price) {
                $status = InvoiceStatusEnum::PAID->value;
            }

            $event->patient->invoices()->create([
                'type' => InvoiceTypeEnum::PATIENT_APPOINTMENT->value,
                'price' => $event->clinicService->price,
                'paid_price' => $this->paid_price,
                'organization_id' => $event->organization_id,
                'clinic_id' => $event->clinic_id,
                'status' => $status,
                'created_by' => Auth::user()->id,
            ]);

            flash()->success('تم تأكيد الحجز بنجاح!');
            $this->dispatch('added');
            $this->resetForm();
        } catch (ModelNotFoundException $e) {
            flash()->error('هذا الحجز غير موجود لديك!');
            log_error($e);
        } catch (\Exception $e) {
            flash()->error(__('alerts.error'));
            log_error($e);
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
        $data = json_decode((string) $event->data);
        $this->dispatch($dispatchedEvent, [
            'id' => $event->id,
            'title' => $event->title,
            'start' => Carbon::parse($this->start)->toIso8601String(),
            'end' => $event->end_at,
            'allDay' => $event->all_day,
            'editable' => true,
            'backgroundColor' => $data->backgroundColor ?? sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
            'textColor' => '#FFFFFF',
            'className' => 'event',
            // 'color' => 'red',
            // 'borderColor' => 'red',
            // 'overlap' => false,
        ]);
    }

    protected function setInvoiceViewInfo($event, $clinicService, $patientName, $doctorName)
    {
        $this->invoiceView['event_id'] = $event->id;
        $this->invoiceView['patient_name'] = $patientName;
        $this->invoiceView['doctor_name'] = $doctorName;
        $this->invoiceView['clinic_service_name'] = $clinicService->name;
        $this->invoiceView['price'] = $clinicService->price;
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
        $this->doctor_id = null;
        $this->searchDoctor = null;
        $this->searchDoctor2 = null;
        $this->paid_price = null;
        $this->search = null;
    }
}
