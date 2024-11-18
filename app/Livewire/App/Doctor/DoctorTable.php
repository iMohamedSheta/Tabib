<?php

namespace App\Livewire\App\Doctor;

use App\Actions\Doctor\DeleteDoctorAction;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Proxy\Query\DoctorsQueryProxy;
use App\Services\User\GetProfilePhotoUrlService;
use App\Traits\LivewireTraits\withProfilePhotoTrait;
use App\Traits\Pagination\WithCustomPagination;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

use function Laravel\Prompts\select;

#[On(['added', 'updated', 'deleted'])]
class DoctorTable extends Component
{
    use WithCustomPagination;
    use withProfilePhotoTrait;

    public function getDoctors()
    {
        $dataCollection = (new DoctorsQueryProxy)
                ->getOrganizationDoctors()
                ->paginate(perPage: $this->perPage, page: $this->page);


        UserTransformer::transformCollection($dataCollection, ['fullname', 'profile_photo_url']);

        return $dataCollection;
    }

    public function getClinics(): array
    {
        return Clinic::getClinicsList();
    }

    public function deleteDoctorAction($id)
    {
        try
        {
            $actionResponse = (new DeleteDoctorAction())->handle(
                Doctor::find($id)
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) return;

            $this->dispatch('deleted');
        }
        catch (\Exception $e) {
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
