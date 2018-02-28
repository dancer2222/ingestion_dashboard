<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('edit-users');
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
            'email' => Rule::unique('mysql_local_ingestion.users')->ignore(request()->id, 'id') . '|email',
            'password' => 'confirmed|min:6|max:191',
            'roles.*' => 'exists:mysql_local_ingestion.roles,id'
        ];
    }
}
