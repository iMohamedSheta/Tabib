<?php

namespace App\Livewire\App\Patient;

use App\Actions\Patient\DeletePatientAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Models\Clinic;
use App\Models\Patient;
use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated', 'deleted'])]
class PatientTable extends Component
{
    use WithCustomPagination;

    public $search;

    public function getPatients(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return PatientQueryBuilderProxy::getPatientsForTable($this->perPage, $this->page, $this->search);
    }

    public function getClinics(): array
    {
        return Clinic::list();
    }

    public function render()
    {
        return view('livewire.app.patient.patient-table', [
            'patients' => $this->getPatients(),
            'clinics' => $this->getClinics(),
        ]);
    }

    public function deletePatientAction(int $id): void
    {
        try {
            $actionResponse = (new DeletePatientAction())->handle(
                Patient::find($id),
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
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بحذف المريض!!',
            ActionResponseStatusEnum::SUCCESS => 'تم حذف المريض بنجاح',
            default => 'حدث خطاء في عملية حذف المريض, الرجاء المحاولة لاحقاً',
        };
    }
}
