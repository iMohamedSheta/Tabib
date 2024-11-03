<?php

namespace App\Traits\ActionTraits;

use App\Collections\ActionResponseCollection;
use App\Enums\ActionResponseEnum;
use Illuminate\Notifications\Action;

trait ActionResponse
{

    private function createResponse(string $message, array $data, ActionResponseEnum $status, bool $success)
    {
        return new ActionResponseCollection([
            'message' => $message,
            'data' => ActionResponseCollection::make($data),
            'status' => $status,
            'success' => $success,
        ]);
    }

    public function success(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseEnum::SUCCESS,
            success: true
        );
    }

    public function error(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseEnum::ERROR,
            success: false
        );
    }

    public function authorizeError(string $message = '', array $data = [])
    {
        return $this->createResponse(
            message: $message,
            data: $data,
            status: ActionResponseEnum::AUTHORIZE_ERROR,
            success: false
        );
    }
}
