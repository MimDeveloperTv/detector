<?php

namespace App\Foundation\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsUlid implements Rule
{
    /**
     * Create a new rule instance.
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
    public function passes($attribute, $value): bool
    {
        return $this->validate($value);
    }

    public function validate($value): bool
    {
        if (! preg_match($this->pattern(), $value)) {
            return false;
        }

        if ($this->ulidTooLarge($value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid ULID';
    }

    protected function pattern(): string
    {
        return '/^[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{10}[0123456789ABCDEFGHJKMNPQRSTVWXYZ]{16}$/i';
    }

    /**
     * Determine if current ulid has exceeded maximum size
     *
     * @param $value
     * @return bool
     */
    protected function ulidTooLarge($value): bool
    {
        return intval($value[0]) > 7;
    }
}
