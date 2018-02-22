<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create-users');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:4|max:191',
            'email' => 'required|unique:mysql_users.users,email|email',
            'password' => 'required|confirmed|min:6|max:191',
            'roles.*' => 'exists:mysql_users.roles,id'
        ];
    }
}
