<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginUserRequest
 *
 * @package App\Http\Requests\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class LoginUserRequest extends FormRequest
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
            'email'    => 'required|exists:users,email|regex:/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/',
            'password' => 'required|min:6|max:20',
        ];
    }

    public function messages()
    {
        return [
            'email.regex'  => 'Incorrect email format.',
            'email.exists' => 'Email does not exist.'
        ];
    }
}