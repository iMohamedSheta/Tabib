<?php

declare(strict_types=1);

namespace App\Livewire\App\Patient;

use App\Actions\User\DeleteUserAttachedFileAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Enums\Calendar\CalendarTypeEnum;
use App\Enums\Helpers\Dates\DaysEnum;
use App\Enums\Media\MediaTypeEnum;
use App\Models\Clinic;
use App\Models\Media;
use App\Models\Patient;
use App\Traits\Pagination\WithCustomPagination;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated', 'deleted', 'uploaded-file'])]
class ShowPatient extends Component
{
    use WithCustomPagination;

    public Patient $patient;
    public $uploaded_attached_file;
    public $events;

    public function mount()
    {
        $this->events = $this->patient->events()->with(['doctor:id,specialization,user_id', 'doctor.user:id,phone', 'clinic:id,name', 'clinicService:id,name', 'patient:id,user_id', 'patient.user:id,first_name,last_name'])->where('type', CalendarTypeEnum::PATIENT_APPOINTMENT->value)->orderByDesc('start_at')->get();
        $this->perPage = 12;
    }

    public function render(): View
    {
        $clinics = Clinic::list();
        $days = DaysEnum::getDaysLabels();

        $mediaFileItems = $this->patient->user->media()->where('type', MediaTypeEnum::FILE)->paginate(perPage: $this->perPage, page: $this->page);
        $mediaRadioItems = $this->patient->user->media()->where('type', MediaTypeEnum::RADIOLOGY)->paginate(perPage: $this->perPage, page: $this->page);

        return view('livewire.app.patient.show-patient', [
            'clinics' => $clinics,
            'days' => $days,
            'mediaFileItems' => $mediaFileItems,
            'mediaFileItemsTotal' => $mediaFileItems->total(),
            'mediaRadioItems' => $mediaRadioItems,
            'mediaRadioItemsTotal' => $mediaRadioItems->total(),
        ]);
    }

    public function deleteMediaAction(int $mediaId): void
    {
        try {
            $actionResponse = (new DeleteUserAttachedFileAction())->handle(
                Media::find($mediaId)
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) {
                return;
            }

            $this->dispatch('deleted');
        } catch (\Exception $exception) {
            log_error($exception);
            flash()->error($this->matchStatus());
        }
    }

    public function matchStatus($actionResponseStatus = null): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بحذف الملف!!',
            ActionResponseStatusEnum::SUCCESS => 'تم حذف الملف بنجاح',
            default => 'حدث خطاء في عملية حذف الملف, الرجاء المحاولة لاحقاً',
        };
    }
}
