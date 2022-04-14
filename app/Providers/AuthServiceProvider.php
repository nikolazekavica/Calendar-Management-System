<?php

namespace App\Providers;

use App\Http\Traits\DateTimeTrait;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    use DateTimeTrait;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(self::dateTimeNow()->addMinutes(30));
        Passport::refreshTokensExpireIn(self::dateTimeNow()->addDays(30));
        Passport::personalAccessTokensExpireIn(self::dateTimeNow()->addMonths(6));
    }
}
