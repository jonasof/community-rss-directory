<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Feed\Validator;

class ValidFeed implements Rule
{
    public function passes($attribute, $value)
    {
        return Validator::isValidFeedSource($value);
    }

    public function message()
    {
        return 'Invalid feed source: :attribute.';
    }
}
