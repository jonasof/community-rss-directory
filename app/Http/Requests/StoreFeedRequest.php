<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidFeed;

class StoreFeedRequest extends FormRequest
{
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
            'url' => [
                'required',
                'url',
                new ValidFeed,
                Rule::unique('feeds')->ignore($this->id)
            ],
            'title' => 'required'
        ];
    }
}
