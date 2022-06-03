<?php

namespace App\Rules;

use Alcohol\ISO4217;
use Illuminate\Contracts\Validation\Rule;

class Currency implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        $iso4217 = new ISO4217();
        try {
            $iso4217->getByAlpha3($value);
            return true;
         } catch (\DomainException $e) {
             return false;
         }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message() {
        return 'It\'s not a valid currency code';
    }
}
