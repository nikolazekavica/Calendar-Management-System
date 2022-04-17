<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 9.4.2022.
 * Time: 13:22
 */

namespace App\Providers;

use App\Http\Validators\AvailabilityValidator;
use Carbon\Laravel\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        AvailabilityValidator::availabilityDuration();
        AvailabilityValidator::multipleRecurring();
        AvailabilityValidator::afterDate();
        AvailabilityValidator::allowedAttributes();
    }
}