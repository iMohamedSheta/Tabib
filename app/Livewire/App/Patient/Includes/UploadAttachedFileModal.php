<?php

declare(strict_types=1);

namespace App\Livewire\App\Patient\Includes;

use App\Enums\User\MediaLibrary\MediaCollectionEnum;
use App\Generators\FilenameGenerator;
use App\Models\Patient;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadAttachedFileModal extends Component
{
    use WithFileUploads;

    private string $show = 'showUploadAttachedFileModal';

    public Patient $patient;
    public $uploadedAttachedFile;

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
            // Determine the collection using the enum
            $mimeType = $this->uploadedAttachedFile->getMimeType();
            $collection = MediaCollectionEnum::determineCollection($mimeType)->value;

            // Get the original file extension
            $originalExtension = $this->uploadedAttachedFile->getClientOriginalExtension();

            $filename = FilenameGenerator::generate($originalExtension, $this->uploadedAttachedFile->getClientOriginalName());

            // Add the file to the specified media collection
            $this->patient->user->addMedia($this->uploadedAttachedFile->getRealPath())
                ->usingFileName($filename)
                ->toMediaCollection($collection);

            flash()->success('تم رفع الملف للمريض بنجاح!');

            $this->dispatch('uploaded-file');
        } catch (\Exception $e) {
            log_error($e);
            flash()->error(__('alerts.error'));
        }
    }
}
