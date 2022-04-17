<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 14.4.2022.
 * Time: 18:09
 */

namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

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