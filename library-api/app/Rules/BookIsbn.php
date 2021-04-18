<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BookIsbn implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $isbn_arr = str_split($value);
        if (sizeof($isbn_arr)!=10) return 0;
        $agg = 0;
        for ($i=0; $i<10; $i++)
            $agg += $isbn_arr[$i] * ($i+1);
        return $agg%11==0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Book ISBN invalid.';
    }
}
