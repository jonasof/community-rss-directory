<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckStatusRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->key != config('cron.webcron_key')) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [];
    }
}
