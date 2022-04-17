<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 16.4.2022.
 * Time: 23:45
 */

namespace App\Http\Requests\Availability;

use Illuminate\Foundation\Http\FormRequest;

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
            '*.allowed_attributes' => 'Not allowed. Allowed params: first_name, last_name, username, email.'
        ];
    }
}