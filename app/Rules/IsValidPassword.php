<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class IsValidPassword implements Rule
{
    /** Determine if the Length Validation Rule passes. */
    public bool $lengthPasses = true;

    /** Determine if the Uppercase Validation Rule passes. */
    public bool $uppercasePasses = true;

    /** Determine if the Numeric Validation Rule passes. */
    public bool $numericPasses = true;

    /** Determine if the Special Character Validation Rule passes. */
    public bool $specialCharacterPasses = true;

    /** Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->uppercasePasses = (Str::lower($value) !== $value);
        $this->numericPasses = ((bool) preg_match('/[0-9]/', $value));
        $this->specialCharacterPasses = true;//((bool) preg_match('/[^A-Za-z0-9]/', $value));

        return ($this->lengthPasses && $this->uppercasePasses && $this->numericPasses && $this->specialCharacterPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch (true) {
            case !$this->uppercasePasses
                && $this->numericPasses
                && $this->specialCharacterPasses:
                return __('common.no_uppercase_error');//'The :attribute must be at least 8 characters and contain at least one uppercase character.';

            case !$this->numericPasses
                && $this->uppercasePasses
                && $this->specialCharacterPasses:
                return __('common.no_numeric_error'); //'The :attribute must be at least 8 characters and contain at least one number.';

            case !$this->specialCharacterPasses
                && $this->uppercasePasses
                && $this->numericPasses:
                return __('common.no_special_error'); //'The :attribute must be at least 8 characters and contain at least one special character (@$!%*#?&).';

            case !$this->uppercasePasses
                && !$this->numericPasses
                && $this->specialCharacterPasses:
                return __('common.no_upper_number_error');//'The :attribute must be at least 8 characters and contain at least one uppercase character and one number.';

            case !$this->uppercasePasses
                && !$this->specialCharacterPasses
                && $this->numericPasses:
                return __('common.no_special_upper_error'); //'The :attribute must be at least 8 characters and contain at least one uppercase character and one special character (@$!%*#?&).';

            case !$this->uppercasePasses
                && !$this->numericPasses
                && !$this->specialCharacterPasses:
                return __('common.no_special_upper_number_error');//'The :attribute must be at least 8 characters and contain at least one uppercase character, one number, and one special character (@$!%*#?&).';

            default:
                return __('common.no_min_characters_errorrs_error');//'The :attribute must be at least 8 characters.';
        }
    }
}
