<?php

declare(strict_types=1);

namespace App\Livewire\App\Patient;

use App\Actions\User\DeleteUserAttachedFileAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Enums\Helpers\Dates\DaysEnum;
use App\Models\Clinic;
use App\Models\Patient;
use App\Traits\Pagination\WithCustomPagination;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[On(['added', 'updated', 'deleted', 'uploaded-file'])]
class ShowPatient extends Component
{
    use WithCustomPagination;

    public Patient $patient;
    public $uploaded_attached_file;

    public function mount()
    {
    }

    public function render(): View
    {
        $clinics = Clinic::list();
        $days = DaysEnum::getDaysLabels();

        $mediaItems = $this->patient->user->media()->paginate(perPage: $this->perPage, page: $this->page);

        $mediaItems->each(function ($media) {
            return $this->generateTemporaryUrl($media);
        });

        return view('livewire.app.patient.show-patient', [
            'clinics' => $clinics,
            'days' => $days,
            'mediaItems' => $mediaItems,
            'mediaItemsTotal' => $mediaItems->total(),
        ]);
    }

    public function deleteMediaAction(int $mediaId): void
    {
        try {
            $actionResponse = (new DeleteUserAttachedFileAction())->handle(
                $this->patient->user,
                $mediaId
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

    public function generateTemporaryUrl(Media $media): Media
    {
        // Check if the media is stored in a supported cloud storage
        if ('s3' === $media->disk) {
            $media->temporaryUrl = $media->getTemporaryUrl(now()->addMinutes(5));
        } else {
            // Generate a signed route for local storage
            $media->temporaryUrl = \URL::temporarySignedRoute(
                'storage.private.tmp.media',
                now()->addMinutes(10),
                [
                    'targetUser' => $this->patient->user->id,
                    'media' => $media,
                ]
            );
        }

        return $media;
    }
}
