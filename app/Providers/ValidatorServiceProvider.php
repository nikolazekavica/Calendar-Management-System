<?php

namespace App\Providers;

use App\Http\Validators\AvailabilityValidator;
use Carbon\Laravel\ServiceProvider;

/**
 * Class ValidatorServiceProvider
 *
 * @package App\Providers
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
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
        AvailabilityValidator::afterDate();
        AvailabilityValidator::availabilityDuration();
        AvailabilityValidator::multipleRecurring();
        AvailabilityValidator::allowedAttributes();
    }
}