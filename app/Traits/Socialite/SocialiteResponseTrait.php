<?php

namespace App\Traits\Socialite;

trait SocialiteResponseTrait
{
    public function socialiteLoginSuccess() {
        $app_url = config('app.url');

        $script = <<<SCRIPT
                        <script>
                            window.opener.postMessage("socialite-login-success", "{$app_url}"); window.close();
                        </script>
                    SCRIPT;

        return response($script);
    }
}
