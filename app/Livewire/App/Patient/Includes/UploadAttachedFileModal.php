<?php

declare(strict_types=1);

namespace App\Livewire\App\Patient\Includes;

use App\Enums\Media\MediaCollectionEnum;
use App\Enums\Media\MediaTypeEnum;
use App\Generators\FilenameGenerator;
use App\Models\Media;
use App\Models\Patient;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadAttachedFileModal extends Component
{
    use WithFileUploads;

    public Patient $patient;
    public $uploadedAttachedFile;
    public $mediaType = MediaTypeEnum::FILE;

    private string $show = 'showUploadAttachedFileModal';

    public function render()
    {
        return view('livewire.app.patient.includes.upload-attached-file-modal', [
            'show' => $this->show,
        ]);
    }

    public function uploadAttachedFileAction(): void
    {
        $this->validate([
            'uploadedAttachedFile' => config('livewire.temporary_file_upload.rules'),
        ], [], [
            'uploadedAttachedFile' => 'الملف الملحق',
        ]);

        try {
            if ($this->isNotAuthorized()) {
                // return $this->authorizeError('غير مسموح لك باضافة الملف!');
                flash()->error('غير مسموح لك باضافة الملف!');

                return;
            }

            // Determine the collection using the enum
            $mimeType = $this->uploadedAttachedFile->getMimeType();
            $collection = MediaCollectionEnum::determineCollection($mimeType)->value;

            // Get the original file extension
            $originalExtension = $this->uploadedAttachedFile->getClientOriginalExtension();

            $filename = FilenameGenerator::generate($originalExtension, $this->uploadedAttachedFile->getClientOriginalName());

            // Add the file to the specified media collection
            $media = $this->patient->user->addMedia($this->uploadedAttachedFile->getRealPath())
                ->usingFileName($filename)
                ->toMediaCollection($collection);

            if (in_array($this->mediaType, MediaTypeEnum::cases()) && MediaTypeEnum::FILE !== $this->mediaType) {
                $media->update(['media_type' => $this->mediaType]);
            }

            flash()->success('تم رفع الملف للمريض بنجاح!');

            $this->dispatch('uploaded-file', $this->mediaType);
        } catch (\Exception $e) {
            log_error($e);
            flash()->error(__('alerts.error'));
        }
    }

    private function isNotAuthorized(): bool
    {
        return !\Gate::allows('create', Media::class);
    }
}
