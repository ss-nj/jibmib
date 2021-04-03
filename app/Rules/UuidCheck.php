<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UuidCheck implements Rule
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
        if (!preg_match("/^\d{10}$/", $value)
            || $value=='0000000000'
            || $value=='1111111111'
            || $value=='2222222222'
            || $value=='3333333333'
            || $value=='4444444444'
            || $value=='5555555555'
            || $value=='6666666666'
            || $value=='7777777777'
            || $value=='8888888888'
            || $value=='9999999999') {
            return false;
        }
        $check = (int) $value[9];
        $sum = array_sum(array_map(function ($x) use ($value) {
                return ((int) $value[$x]) * (10 - $x);
            }, range(0, 8))) % 11;
        return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'شماره ملی را به طور صحیح وارد کنید .';
    }
}
