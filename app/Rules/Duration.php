<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Duration implements Rule
{
    protected $maximum;
    protected $minimum;
    
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($minimum, $maximum)
    {
        $this->maximum = $maximum;
        $this->minimum = $minimum;
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
        return (($value <= $this->maximum) && ($value >= $this->minimum));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be superior to ' . $this->minimum . ' and inferior to ' . $this->maximum . ' minutes';
    }
}
