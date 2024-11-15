<?php

namespace App\Traits\ActionTraits;

use App\Enums\Actions\ActionResponseStatusEnum;
use App\Responses\ActionResponse;

trait ActionResponseTrait
{

    private function createResponse(ActionResponseStatusEnum $status, bool $success, string $message, $data = null)
    {
        return new ActionResponse(
            $success,
            $status,
            $message,
            $data,
        );
    }

    public function success(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseStatusEnum::SUCCESS,
            success: true
        );
    }

    public function error(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseStatusEnum::ERROR,
            success: false
        );
    }

    public function authorizeError(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseStatusEnum::AUTHORIZE_ERROR,
            success: false
        );
    }
}
