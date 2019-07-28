<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use File;
class JsonFile implements Rule
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
    public function passes($attribute, $value)
    {
        $content = File::get($value->getRealPath());
        return ! empty(json_decode($content, true));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be in JSON format.';
    }
}
