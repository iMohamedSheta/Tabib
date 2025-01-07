<?php

namespace App\Livewire\App\ClinicService;

use App\Actions\ClinicService\DeleteClinicServiceAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Models\Clinic;
use App\Models\ClinicService;
use App\Proxy\QueryBuilders\ClinicServiceQueryBuilderProxy;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated', 'deleted'])]
class ClinicServiceTable extends Component
{
    use WithCustomPagination;

    protected function getClinicServices(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ClinicServiceQueryBuilderProxy::getClinicServicesForTable($this->perPage, $this->page);
    }

    public function getClinics(): array
    {
        return Clinic::list();
    }

    public function deleteClinicServiceAction($id): void
    {
        try {
            $actionResponse = (new DeleteClinicServiceAction())->handle(
                ClinicService::find($id),
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

    protected function matchStatus($actionResponseStatus = null): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بحذف الخدمة طبية!!',
            ActionResponseStatusEnum::SUCCESS => 'تم حذف الخدمة الطبية بنجاح',
            default => 'حدث خطاء في عملية حذف الخدمة الطبية الرجاء المحاولة لاحقاً',
        };
    }

    public function render()
    {
        return view('livewire.app.clinic-service.clinic-service-table', [
            'clinicServices' => $this->getClinicServices(),
            'clinics' => $this->getClinics(),
        ]);
    }
}
