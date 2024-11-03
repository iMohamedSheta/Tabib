<?php

namespace App\Livewire\App\Doctor;

use App\Actions\Doctor\DeleteDoctorAction;
use App\Enums\ActionResponseEnum;
use App\Helpers\Helper;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Attributes\On;
use Livewire\Component;
#[On(['added', 'updated', 'deleted'])]
class DoctorTable extends Component
{
    use WithCustomPagination;

    public bool $displayingToken = false;

    public function getDoctors()
    {
        return Doctor::with('user', 'clinic:id,name')
                ->latest()
                ->paginate(perPage: $this->perPage, page: $this->page);
    }

    public function getClinics()
    {
        return Clinic::pluck('name', 'id')->toArray();
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
            Helper::log($e);
            flash()->error($this->matchStatus());
        }
    }

    public function matchStatus($actionResponseStatus = null): string
    {
        return match ($actionResponseStatus) {
            ActionResponseEnum::AUTHORIZE_ERROR => 'غير مسموح لك بحذف الطبيب!!',
            ActionResponseEnum::SUCCESS => 'تم حذف الطبيب بنجاح',
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
