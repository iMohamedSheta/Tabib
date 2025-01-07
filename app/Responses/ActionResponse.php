<?php

namespace App\Responses;

use App\Enums\Actions\ActionResponseStatusEnum;

class ActionResponse
{
    public function __construct(
        public bool $success,
        public ActionResponseStatusEnum $status,
        public string $message,
        public $data = null,
    ) {
        $this->data = is_array($data) ? json_decode(json_encode($data)) : $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    public function getStatus(): ActionResponseStatusEnum
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
