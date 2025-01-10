<?php

namespace App\Actions\Doctor;

use App\DTOs\Doctor\CreateDoctorDTO;
use App\Models\Doctor;
use App\Models\User;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreateDoctorAction
{
    use ActionResponseTrait;

    public function handle(CreateDoctorDTO $createDoctorDTO): ActionResponse
    {
        try {
            if ($this->isNotAuthorized()) {
                return $this->authorizeError('غير مسموح لك باضافة الطبيب!!');
            }

            DB::beginTransaction();

            $user = User::create($createDoctorDTO->userData());

            if ($createDoctorDTO->photo) {
                $user->updateProfilePhoto($createDoctorDTO->photo);
            }

            $user->doctor()->create($createDoctorDTO->doctorData());

            DB::commit();

            return $this->success(
                message: 'تم انشاء الطبيب بنجاح',
                data: ['user' => $user],
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            log_error($exception);

            return $this->error('حدث خطأ في عملية أنشاء الطبيب، الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(): bool
    {
        return !Gate::allows('create', Doctor::class);
    }
}
