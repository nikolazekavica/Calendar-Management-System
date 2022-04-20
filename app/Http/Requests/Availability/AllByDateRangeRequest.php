<?php

namespace App\Http\Requests\Availability;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class DateTimeTrait
 *
 * @package App\Http\Requests\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AllByDateRangeRequest extends FormRequest
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
        return [
            'start_date' => 'required|date_format:d-m-Y',
            'end_date'   => 'required|date_format:d-m-Y|after_or_equal:start_date|availability_duration:start_date,end_date,30'
        ];
    }

    public function messages()
    {
        return [
            'end_date.availability_duration' => 'Range time must be less than 30 days',
            'start_date.date_format'         => 'Date format must be d-m-Y. Ex: 01-01-2023',
            'end_date.date_format'           => 'Date format must be d-m-Y. Ex: 01-01-2023'
        ];
    }
}