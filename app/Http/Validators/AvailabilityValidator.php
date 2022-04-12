<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 7.4.2022.
 * Time: 12:21
 */
namespace App\Http\Validators;

use App\Helpers\Constants;
use App\Models\Availability;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AvailabilityValidator extends Validator
{
    public static function availabilityDuration()
    {
        self::extend('availability_duration', function($attribute, $value, $params, $validator) {

            $data = $validator->getData();

            $startTime     = Carbon::parse($data[$params[0]]);
            $finishTime    = Carbon::parse($data[$params[1]]);
            $totalDuration = $finishTime->diffInDays($startTime);

            return $totalDuration <= $params[2];
        });
    }

    public static function multipleRecurring()
    {
        self::extend('multiple_recurrences', function($attribute, $value, $params, $validator) {

            $data    = $validator->getData();
            $dateNow = Carbon::now()
                ->timezone(config('app.timezone'))
                ->format(Constants::DATE_FORMAT_MYSQL);

            if($data['is_recurrences'] == true) {
                $availability = Availability::where('is_recurrences','=',1)
                    ->where('user_id', $data['user_id'])
                    ->where(
                        'end_date_recurrences',
                        '>',
                        $dateNow
                    )
                    ->first();

                return !$availability;
            }
            return true;
        });
    }

    public static function afterDate()
    {
        self::extend('after_date', function($attribute, $value, $params, $validator) {

            $data        = $validator->getData();
            $dateAndTime = $data['start_date'].' '.$data['start_time'];
            $date        = Carbon::parse($dateAndTime)->getTimestamp();

            return $date >= $params[0];
        });
    }
}