<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        // Access token expires after 8 hours error msg: 401 Unauthenticated.
       /* Passport::tokensExpireIn(
            Carbon::now()->addHours(8)
        );*/

   Passport::tokensExpireIn(Carbon::now()->addMinutes(1));
    Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));

    }
}
