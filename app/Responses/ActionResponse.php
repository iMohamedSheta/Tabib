<?php

namespace App\Responses;

use App\Enums\Actions\ActionResponseStatusEnum;

class ActionResponse
{
    public bool $success;
    public ActionResponseStatusEnum $status;
    public string $message;
    public $data;

    public function __construct(bool $success, ActionResponseStatusEnum $status, string $message, $data = null)
    {
        $this->success = $success;
        $this->status = $status;
        $this->message = $message;

        $this->data = is_array($data) ? json_decode(json_encode($data)) : $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function isSuccess()
    {
        return $this->success;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
