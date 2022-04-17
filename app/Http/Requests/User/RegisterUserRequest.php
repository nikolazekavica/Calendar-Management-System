<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 14:25
 */
namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
        //TODO:MESSAGE FOR ERRORS
        return [
            'first_name' => 'required|max:20',
            'last_name'  => 'required|max:20',
            'username'   => 'required|max:20|unique:users,username',
            'email'      => 'required|email|unique:users,email|regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
            'password'   => 'required|regex:/^(?=.*[a-z])(?=\S*?[A-Z])(?=.*\d)(?=.*[!@#$%^&*_+])[A-Za-z\d!@#$%^&*_+]{6,20}$/',
            'role_id'    => 'required|exists:roles,id'
        ];
    }
}