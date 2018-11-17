<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use App\Utils\FeedValidator;

class ValidFeed implements Rule
{
    public function passes($attribute, $value)
    {
        return FeedValidator::isValidFeedSource($value);
    }

    public function message()
    {
        return 'Invalid feed source: :attribute.';
    }
}
