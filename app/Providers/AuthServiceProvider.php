<?php

namespace App\Providers;

use App\Http\Services\Concrete\User\RoleService;
use App\Http\Traits\DateTimeTrait;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Laravel\Passport\Passport;

/**
 * Class AuthServiceProviders
 *
 * @package App\Providers
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AuthServiceProvider extends ServiceProvider
{
    use DateTimeTrait;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
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

        Passport::tokensExpireIn($this->dateTimeNow()->addDays(10));
        Passport::refreshTokensExpireIn($this->dateTimeNow()->addDays(30));

        Passport::tokensCan(RoleService::getInstance()->all()->toArray());
    }
}
