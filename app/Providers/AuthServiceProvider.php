<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addDays(60));
        Passport::refreshTokensExpireIn(now()->addDays(90));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
