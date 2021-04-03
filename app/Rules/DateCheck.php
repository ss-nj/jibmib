<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DateCheck implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$value ||!strlen ($value)>0)
            return  true;


        try {
            $date = explode('-', $value);
            $time = explode(':', $date[3]);
        }catch (\Exception $exception){
            dd($date,strlen($value));
        }


        if ($date[0] > 1401 || $date[0] < 1399)
            return false;
        if ($date[1] < 1 || $date[1] > 12)
            return false;
        if ($date[2] < 1 || $date[2] > 30)
            return false;

        if ($time[0] < 0 || $time[0] > 24)
            return false;
        if ($time[0] < 0 || $time[0] > 60)
            return false;

        return  true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'تاریخ را به طور صحیح وارد کنید .';
    }
}
