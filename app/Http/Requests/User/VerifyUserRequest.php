<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VerifyUserRequest
 *
 * @package App\Http\Requests\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class VerifyUserRequest extends FormRequest
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
            'code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Link is invalid.'
        ];
    }
}