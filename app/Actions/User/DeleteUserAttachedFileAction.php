<?php

namespace App\Actions\User;

use App\Models\User;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use DB;
use Gate;

class DeleteUserAttachedFileAction
{
    use ActionResponseTrait;

    public function handle(User $user, int $mediaId): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($user)) {
                return $this->authorizeError('غير مسموح لك بحذف الملف!!');
            }

            $media = $user->getMedia('*')->where('id', $mediaId)->first();
            $media->delete();

            return $this->success(
                message: 'تم حذف الملف بنجاح',
                data: [],
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            log_error($exception);
            return $this->error('حدث خطأ في عملية حذف الملف الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(User $user): bool
    {
        return !Gate::allows('deleteAttachedFile', $user);
    }
}
