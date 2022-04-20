<?php

namespace App\Http\Requests\Availability;

use App\Helpers\Constants;
use Carbon\Carbon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class StoreRequest
 *
 * @package App\Http\Requests\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $dateNow = Carbon::now()->setTimezone(config('app.timezone'))->getTimestamp();

        return [
            'title'                  => 'required|max:20',
            'start_date'             => 'required|date_format:d-m-Y|after_date:' . $dateNow,
            'end_date'               => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'start_time'             => 'required|date_format:H:i',
            'end_time'               => 'required|date_format:H:i|after:start_time',
            'availability_status'    => Rule::in(Constants::ENUM_AVAILABILITY_STATUS),
            'description'            => 'required|max:100',
            'is_recurrences'         => 'required|bool|availability_duration:start_date,end_date,7|multiple_recurrences',
            'start_date_recurrences' => 'required_if:is_recurrences,true|date_format:d-m-Y|after:end_date',
            'end_date_recurrences'   => 'required_if:is_recurrences,true|date_format:d-m-Y|after:start_date_recurrences'
        ];
    }

    public function messages()
    {
        return [
            'is_recurrences.availability_duration' => 'Availability duration must be shorter than the frequency of recurrence.',
            'is_recurrences.multiple_recurring'    => 'Multiple recurrences are forbidden.',
            'start_date.after_date'                => 'The start date must be a date after or equal to today.',
            'start_time.date_format'               => 'Time format must be H:i. Ex: 12:12',
            'end_time.date_format'                 => 'Time format must be H:i. Ex: 12:12',
            'is_recurrences.multiple_recurrences'  => 'Multiple recurrences are forbidden for the same user.',
            'start_date_recurrences.date_format'   => 'Date format must be d-m-Y. Ex: 12:12:2022',
            'end_date_recurrences.date_format'     => 'Date format must be d-m-Y. Ex: 12:12:2022',
            'start_date.date_format'               => 'Date format must be d-m-Y. Ex: 12:12:2022',
            'end_date.date_format'                 => 'Date format must be d-m-Y. Ex: 12:12:2022',
        ];
    }
}
