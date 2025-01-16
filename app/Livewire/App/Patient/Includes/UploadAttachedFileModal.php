<?php

declare(strict_types=1);

namespace App\Livewire\App\Patient\Includes;

use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UploadAttachedFileModal extends Component
{
    use WithFileUploads;

    private string $show = 'showUploadAttachedFileModal';

    public $uploadedAttachedFile;
    public $originalFileName;

    public function updatedUploadedAttachedFile($uploadedFile): void
    {
        $this->originalFileName = $uploadedFile->getClientOriginalName();
        $this->render();
    }

    public function render()
    {
        return view('livewire.app.patient.includes.upload-attached-file-modal', [
            'show' => $this->show,
        ]);
    }
}
