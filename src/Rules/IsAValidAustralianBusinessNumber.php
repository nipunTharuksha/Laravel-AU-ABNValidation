<?php

namespace Nipun\Abnvalidation\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsAValidAustralianBusinessNumber implements Rule
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
        /*
         * find validation logic here https://abr.business.gov.au/Help/AbnFormat
         * */

        if (!(filter_var($value, FILTER_VALIDATE_INT))) {
            return false;
        }

        $abnFactors = [
            ['position' => '1', 'weight' => '10'],
            ['position' => '2', 'weight' => '1'],
            ['position' => '3', 'weight' => '3'],
            ['position' => '4', 'weight' => '5'],
            ['position' => '5', 'weight' => '7'],
            ['position' => '6', 'weight' => '9'],
            ['position' => '7', 'weight' => '11'],
            ['position' => '8', 'weight' => '13'],
            ['position' => '9', 'weight' => '15'],
            ['position' => '10', 'weight' => '17'],
            ['position' => '11', 'weight' => '19']
        ];

        $Abn = $value;
        $numberArray = str_split($Abn);

        $newFirstDigit = $numberArray[0] - $numberArray[1];

        $newNumberAfterExtract = $numberArray;
        $newNumberAfterExtract[0] = $newFirstDigit;

        $sumOfWeights = collect($newNumberAfterExtract)->map(function ($digit, $index) use ($abnFactors) {
            return $digit * $abnFactors[$index]['weight'];
        })->sum();

        $isAValidAbn = ($sumOfWeights % 89) === 0;
        dd($isAValidAbn);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Australian Business Number provided.';
    }
}
