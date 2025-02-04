<?php

namespace App\Actions\User;

use App\Models\Media;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DeleteUserAttachedFileAction
{
    use ActionResponseTrait;

    public function handle(Media $media): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($media)) {
                return $this->authorizeError('غير مسموح لك بحذف الملف!!');
            }

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

    private function isNotAuthorized(Media $media): bool
    {
        return !Gate::allows('delete', $media);
    }
}
