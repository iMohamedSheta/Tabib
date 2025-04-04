<?php

namespace App\Traits\ActionTraits;

use App\Enums\Actions\ActionResponseStatusEnum;
use App\Responses\ActionResponse;

trait ActionResponseTrait
{
    public function success(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseStatusEnum::SUCCESS,
            success: true,
        );
    }

    public function error(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseStatusEnum::ERROR,
            success: false,
        );
    }

    public function authorizeError(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseStatusEnum::AUTHORIZE_ERROR,
            success: false,
        );
    }

    private function createResponse(ActionResponseStatusEnum $status, bool $success, string $message, $data = null): ActionResponse
    {
        return new ActionResponse(
            $success,
            $status,
            $message,
            $data,
        );
    }
}
