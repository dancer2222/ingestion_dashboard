<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManageBlackList
 * @package App\Http\Requests
 */
class ManageBlackList extends FormRequest
{
    /**
     * @return mixed
     */
    public function authorize()
    {
        return $this->user()->can('manage-blackList');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
        ];
    }
}
