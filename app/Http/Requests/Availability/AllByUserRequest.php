<?php

namespace App\Http\Requests\Availability;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AllByUserRequest
 *
 * @package App\Http\Requests\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AllByUserRequest extends FormRequest
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
            '*' => 'allowed_attributes:first_name,last_name,username,email'
        ];
    }

    public function messages()
    {
        return [
            '*.allowed_attributes' => 'Forbidden. Allowed params: first_name, last_name, username, email.'
        ];
    }
}