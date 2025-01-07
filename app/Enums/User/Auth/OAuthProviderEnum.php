<?php

namespace App\Enums\User\Auth;

enum OAuthProviderEnum: int
{
    case GOOGLE = 1;
    case META = 2;

    public const DEFAULT = self::GOOGLE->value;
}
