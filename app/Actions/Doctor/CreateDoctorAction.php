<?php

namespace App\Actions\Doctor;

use App\Collections\ActionResponseCollection;
use App\DTOs\Doctor\CreateDoctorDTO;
use App\Helpers\Helper;
use App\Models\Doctor;
use App\Models\User;
use App\Traits\ActionTraits\ActionResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreateDoctorAction
{
    use ActionResponse;

    public function handle(CreateDoctorDTO $dto): ActionResponseCollection
    {
        try
        {
            if ($this->isNotAuthorized()) {
                return $this->authorizeError('غير مسموح لك باضافة الطبيب!!');
            }

            DB::beginTransaction();

            $user = User::create($dto->userData());

            if ($dto->photo) {
                $user->updateProfilePhoto($dto->photo);
            }

            $user->doctor()->create($dto->doctorData());

            DB::commit();

            return $this->success(
                message: 'تم انشاء الطبيب بنجاح',
                data: ['user' => $user]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            Helper::log($e);
            return $this->error("حدث خطأ في عملية أنشاء الطبيب، الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized(): bool
    {
        return !Gate::allows('create', Doctor::class);
    }

}
