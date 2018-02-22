<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditRole extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
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
            'display_name' => 'required|unique:mysql_users.roles,name',
            'description' => 'required|max:191',
            'permissions.*' => 'exists:mysql_users.permissions,id'
        ];
    }
}
