<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterUserRequest
 *
 * @package App\Http\Requests\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class RegisterUserRequest extends FormRequest
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
            'first_name' => 'required|max:20',
            'last_name'  => 'required|max:20',
            'username'   => 'required|max:20|unique:users,username',
            'email'      => 'required|email|unique:users,email|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'password'   => 'required|regex:/^(?=.*[a-z])(?=\S*?[A-Z])(?=.*\d)(?=.*[!@#$%^&*_+])[A-Za-z\d!@#$%^&*_+]{6,20}$/',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Incorrect password format. Password length (min. 6 characters and max. 20).' .
                'Must contain letters,numbers,capital letter and special characters(!@#%&*).' .
                'Spaces are not permitted.',
        ];
    }
}