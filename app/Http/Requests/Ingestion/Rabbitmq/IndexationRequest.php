<?php

namespace App\Http\Requests\Ingestion\Rabbitmq;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin', 'ingester');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action' => [
                'required',
                Rule::in(['updateSingle', 'updateBatch']),
            ],
            'type' => [
                'required',
                Rule::in(['movies', 'audiobooks', 'books', 'albums']),
            ],
            'id' => 'required|regex:/[0-9,\s]/',
        ];
    }
}
