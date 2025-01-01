<?php

namespace App\Livewire\App\Doctor;

use App\Actions\Doctor\DeleteDoctorAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Proxy\QueryBuilders\DoctorQueryBuilderProxy;
use App\Traits\LivewireTraits\withProfilePhotoTrait;
use App\Traits\Pagination\WithCustomPagination;
use App\Transformers\UserTransformer;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated', 'deleted'])]
class DoctorTable extends Component
{
    use WithCustomPagination;
    use withProfilePhotoTrait;

    public function getDoctors()
    {
        $dataCollection = DoctorQueryBuilderProxy::getDoctorsForTable($this->perPage, $this->page);

        UserTransformer::transformCollection($dataCollection, ['fullname', 'profile_photo_url']);

        return $dataCollection;
    }

    public function getClinics(): array
    {
        return Clinic::list();
    }

    public function deleteDoctorAction($id)
    {
        try {
            $actionResponse = (new DeleteDoctorAction())->handle(
                Doctor::find($id)
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) return;

            $this->dispatch('deleted');
        } catch (\Exception $e) {
            log_error($e);
            flash()->error($this->matchStatus());
        }
    }

    public function matchStatus($actionResponseStatus = null): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بحذف الطبيب!!',
            ActionResponseStatusEnum::SUCCESS => 'تم حذف الطبيب بنجاح',
            default => 'حدث خطاء في عملية حذف الطبيب، الرجاء المحاولة لاحقاً'
        };
    }
    public function render()
    {
        return view('livewire.app.doctor.doctor-table', [
            'doctors' => $this->getDoctors(),
            'clinics' => $this->getClinics()
        ]);
    }
}
