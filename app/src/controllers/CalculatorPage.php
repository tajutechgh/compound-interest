<?php 

use SilverStripe\Control\HTTPRequest;

class CalculatorPageController extends PageController 
{
    private static $allowed_actions = [
        'calculate',
    ];

    public function calculate(HTTPRequest $request)
    {
        $initialDeposit = $request->postVar('InitialDeposit');

        $rate = $request->postVar('Rate');

        $rateDecimals = $rate/100;

        $compoundFrequency = $request->postVar('CompoundFrequency');

        $time = $request->postVar('Time');

        $compoundInterest = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $time * $compoundFrequency );

        if (!empty($compoundInterest)) {

            $ci = new CompoundInterest;

            $ci->InitialDeposit = $initialDeposit;
            $ci->Rate = $rateDecimals;
            $ci->CompoundFrequency = $compoundFrequency;
            $ci->Time = $time;
            $ci->CompoundInterest = round($compoundInterest, 2);

            $ci->write();
        }

        return $this->customise([
            'Title' => "Compound Interest =",
            'CompoundInterest' => round($compoundInterest, 2),
        ])->renderWith(['CalculatorPage', 'Page']);
    } 
}