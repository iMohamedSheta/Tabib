<?php

namespace App\Actions\Doctor;

use App\DTOs\Doctor\CreateDoctorDTO;
use App\Helpers\Helper;
use App\Models\Doctor;
use App\Models\User;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreateDoctorAction
{
    use ActionResponseTrait;

    public function handle(CreateDoctorDTO $dto): ActionResponse
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
            log_error($e);
            return $this->error("حدث خطأ في عملية أنشاء الطبيب، الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized(): bool
    {
        return !Gate::allows('create', Doctor::class);
    }

}
