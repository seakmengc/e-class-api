<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ValidPoints implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($args, $question)
    {
        $this->args = $args;
        $this->question = $question;
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
        $qId = Arr::get($this->args, 'answer.' . explode('.', $attribute)[1] . '.id');
        // dd($attribute, $value, $this->question, $this->args, $id, 'answer' . explode('.', $attribute)[1] . '.id');
        $possiblePoints = $this->question->firstWhere('id', $qId)['points'];

        return $value <= $possiblePoints;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute exceeds the maximum possible points.';
    }
}
