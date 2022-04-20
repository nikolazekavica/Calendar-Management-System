<?php

namespace App\Http\Validators;

use App\Helpers\Constants;
use App\Models\Availability;

use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

/**
 * Class AvailabilityValidator
 *
 * @package App\Http\Validators
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AvailabilityValidator extends Validator
{
    /**
     * Check availability duration
     */
    public static function availabilityDuration()
    {
        self::extend('availability_duration', function ($attribute, $value, $params, $validator) {

            $data = $validator->getData();

            try {
                $startTime     = Carbon::parse($data[$params[0]]);
                $finishTime    = Carbon::parse($data[$params[1]]);
                $totalDuration = $finishTime->diffInDays($startTime);
            } catch (\Exception $exception) {
                return false;
            }

            return $totalDuration <= $params[2];
        });
    }

    /**
     * Check does exist multiple recurring for same user.
     */
    public static function multipleRecurring()
    {
        self::extend('multiple_recurrences', function ($attribute, $value, $params, $validator) {

            $data   = $validator->getData();
            $userId = auth('api')->user()->getAuthIdentifier();

            $dateNow = Carbon::now()
                ->timezone(config('app.timezone'))
                ->format(Constants::DATE_FORMAT_MYSQL);

            if ($data['is_recurrences'] == true) {
                $availability = Availability::where('is_recurrences', 1)
                    ->where('user_id', $userId)
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

    /**
     * Compare two dates.
     */
    public static function afterDate()
    {
        self::extend('after_date', function ($attribute, $value, $params, $validator) {

            $data = $validator->getData();

            try {
                $dateAndTime = $data['start_date'] . ' ' . $data['start_time'];
                $date        = Carbon::parse($dateAndTime)->getTimestamp();
            } catch (\Exception $exception) {
                return false;
            }

            return $date >= $params[0];
        });
    }

    /**
     * Check allowed input attributes.
     */
    public static function allowedAttributes()
    {
        self::extend('allowed_attributes', function ($attribute, $value, $params, $validator) {
            if (!in_array($attribute, $params)) {
                return false;
            }

            return true;
        });
    }
}