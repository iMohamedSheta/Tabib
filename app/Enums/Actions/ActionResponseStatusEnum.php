<?php

namespace App\Enums\Actions;

enum ActionResponseStatusEnum: int
{
    case SUCCESS = 1000;
    case ERROR = 1001;
    case AUTHORIZE_ERROR = 1002;
}
