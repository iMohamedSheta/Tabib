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
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated'])]
class ShowPatient extends Component
{
    use WithCustomPagination;

    public Patient $patient;
    #[Locked]
    public $days;
    #[Locked]
    public $clinics;

    public function mount(): void
    {
        $this->days = DaysEnum::getDaysLabels();
        $this->perPage = 12;
        $this->clinics = Clinic::list();
    }

    public function render(): View
    {
        return view('livewire.app.patient.show-patient');
    }

    #[Computed(persist: true)]
    public function events()
    {
        return $this->patient->events()->with(['doctor:id,specialization,user_id', 'doctor.user:id,phone', 'clinic:id,name', 'clinicService:id,name', 'patient:id,user_id', 'patient.user:id,first_name,last_name'])
            ->where('type', CalendarTypeEnum::PATIENT_APPOINTMENT->value)->orderByDesc('start_at')->get();
    }

    #[Computed(persist: true)]
    public function mediaFileItems(): array
    {
        $items = $this->patient->user->media()->where('media_type', MediaTypeEnum::FILE)->paginate(perPage: $this->perPage, page: $this->page);
        $itemsTotal = $items->total();

        return [
            'items' => $items,
            'total' => $itemsTotal,
        ];
    }

    #[Computed(persist: true)]
    public function mediaRadioItems(): array
    {
        $items = $this->patient->user->media()->where('media_type', MediaTypeEnum::RADIOLOGY)->paginate(perPage: $this->perPage, page: $this->page);
        $itemsTotal = $items->total();

        return [
            'items' => $items,
            'total' => $itemsTotal,
        ];
    }

    public function deleteMediaAction(int $mediaId): void
    {
        try {
            $media = Media::find($mediaId);
            $mediaType = $media->media_type;

            $actionResponse = (new DeleteUserAttachedFileAction())->handle($media);

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) {
                return;
            }

            $this->unsetMediaItems($mediaType);
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

    #[On('uploaded-file')]
    public function unsetMediaItems(int|MediaTypeEnum $mediaType): void
    {
        if (MediaTypeEnum::FILE == $mediaType) {
            unset($this->mediaFileItems);
        } elseif (MediaTypeEnum::RADIOLOGY == $mediaType) {
            unset($this->mediaRadioItems);
        } else {
            unset($this->mediaFileItems, $this->mediaRadioItems);
        }
    }
}
