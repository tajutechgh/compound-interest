<?php 

use SilverStripe\ORM\DB;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\HTTPRequest;

class CalculatorPageController extends PageController 
{
    private static $allowed_actions = [
        'calculate',
    ];
    
    public function calculate(HTTPRequest $request)
    {
        // variables declared to get the values when post action is triggered
        $initialDeposit = $request->postVar('InitialDeposit');

        $depositAmount = $request->postVar('DepositAmount');

        $depositCompound = $request->postVar('DepositCompound');

        if (!empty($depositAmount) && !empty($depositCompound)) {

            $depoAmount = $depositAmount * $depositCompound;
        }
        
        $depositAnnualInflationRate = $request->postVar('DepositAnnualInflationRate');

        $depositMadeAt = $request->postVar('DepositMadeAt');

        $withdrawalAmount = $request->postVar('WithdrawalAmount');

        $withdrawalCompound = $request->postVar('WithdrawalCompound');

        $withdrawalAnnualInflationRate = $request->postVar('WithdrawalAnnualInflationRate');

        $withdrawalMadeAt = $request->postVar('WithdrawalMadeAt');

        $rate = $request->postVar('Rate');

        $compoundRate = $request->postVar('CompoundRate');

        $rateDecimals = ($rate/100) * $compoundRate;

        $compoundFrequency = $request->postVar('CompoundFrequency');

        $timeYear = $request->postVar('TimeYear');

        $timeMonth = $request->postVar('TimeMonth');

        $compInt = 0;

        $compoundInterest = 0;

        $deposit = "";

        $totalDeposit = 0;

        // the url source for the compound interest formula "https://www.thecalculatorsite.com/articles/finance/compound-interest-formula.php"
        // the url source for the future value formula "https://www.thecalculatorsite.com/articles/finance/future-value-formula.php"
        if (!empty($timeMonth) && empty($depositAmount)) {
            
            $tm = $timeMonth/12;

            $timeMonthValue = $timeYear + $tm;

            // compound interest when both years and months are entered for the time
            $compInt = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeMonthValue * $compoundFrequency );
        }elseif (empty($timeMonth) && empty($depositAmount)) {

            // compound interest when only years are entered for the time
            $compoundInterest = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeYear * $compoundFrequency );

        }elseif (!empty($depositAmount) && !empty($timeMonth)) {

            if ($depositMadeAt == 'EndOfMonth') {

                $tm = $timeMonth/12;

                $timeMonthValue = $timeYear + $tm;

                $compInt = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeMonthValue * $compoundFrequency );

                // compound interest when both years and months are entered for the time and deposit amount made at the end of month
                $endOfMonthCompIntOne = $compInt + ( $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $timeMonthValue * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency)) );
    
            }elseif ($depositMadeAt == 'BeginningOfMonth') {

                $tm = $timeMonth/12;

                $timeMonthValue = $timeYear + $tm;

                $compInt = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeMonthValue * $compoundFrequency );
   
                // compound interest when both years and months are entered for the time and deposit amount made at the beginning of month
                $beginningOfMonthCompIntOne = $compInt + ( $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $timeMonthValue * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency))*(1 + $rateDecimals/$compoundFrequency));
            }
        }elseif (!empty($depositAmount) && empty($timeMonth)) {

            if ($depositMadeAt == 'EndOfMonth') {

                $compoundInterest = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeYear * $compoundFrequency );

                // compound interest when only years are entered for the time and deposit amount made at the end of month
                $endOfMonthCompIntTwo = $compoundInterest + ( $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $timeYear * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency)) );
                
            }elseif ($depositMadeAt == 'BeginningOfMonth') {

                $compoundInterest = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeYear * $compoundFrequency );

                // compound interest when only years are entered for the time and deposit amount made at the beginning of month
                $beginningOfMonthCompIntTwo = $compoundInterest + ( $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $timeYear * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency))*(1 + $rateDecimals/$compoundFrequency));
            }
        }

        $futureValue = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeYear * $compoundFrequency );

        // conditions to save to database 
        if (empty($timeMonth) && empty($depositAmount)) {

            if (!empty($compoundInterest)) {

                $ci = new CompoundInterest;

                $ci->InitialDeposit = $initialDeposit;
                $ci->Rate = $rateDecimals;
                $ci->CompoundFrequency = $compoundFrequency;
                $ci->TimeYear = $timeYear;
                $ci->CompoundInterest = round($compoundInterest, 2);
                $ci->DepositAmount = $depositAmount;
                $ci->DepositCompound = $depositCompound;
                $ci->DepositAnnualInflationRate = $depositAnnualInflationRate;
                $ci->DepositMadeAt = $depositMadeAt;
                $ci->WithdrawalMadeAt = $withdrawalMadeAt;
                $ci->WithdrawalAmount = $withdrawalAmount;
                $ci->WithdrawalCompound = $withdrawalCompound;
                $ci->WithdrawalAnnualInflationRate = $withdrawalAnnualInflationRate;

                $ci->write();
            }
        }elseif (!empty($timeMonth) && empty($depositAmount)) {

            if (!empty($compInt)) {

                $ci = new CompoundInterest;

                $ci->InitialDeposit = $initialDeposit;
                $ci->Rate = $rateDecimals;
                $ci->CompoundFrequency = $compoundFrequency;
                $ci->TimeYear = $timeYear;
                $ci->TimeMonth = $timeMonth;
                $ci->CompoundInterest = round($compInt, 2);
                $ci->DepositAmount = $depositAmount;
                $ci->DepositCompound = $depositCompound;
                $ci->DepositAnnualInflationRate = $depositAnnualInflationRate;
                $ci->DepositMadeAt = $depositMadeAt;
                $ci->WithdrawalMadeAt = $withdrawalMadeAt;
                $ci->WithdrawalAmount = $withdrawalAmount;
                $ci->WithdrawalCompound = $withdrawalCompound;
                $ci->WithdrawalAnnualInflationRate = $withdrawalAnnualInflationRate;

                $ci->write();
            }
        }elseif (!empty($depositAmount) && empty($timeMonth)) {

            if ($depositMadeAt == 'EndOfMonth' && !empty($endOfMonthCompIntTwo)) {

                $ci = new CompoundInterest;

                $ci->InitialDeposit = $initialDeposit;
                $ci->Rate = $rateDecimals;
                $ci->CompoundFrequency = $compoundFrequency;
                $ci->TimeYear = $timeYear;
                $ci->TimeMonth = $timeMonth;
                $ci->CompoundInterest = round($endOfMonthCompIntTwo, 2);
                $ci->DepositAmount = $depositAmount;
                $ci->DepositCompound = $depositCompound;
                $ci->DepositAnnualInflationRate = $depositAnnualInflationRate;
                $ci->DepositMadeAt = $depositMadeAt;
                $ci->WithdrawalMadeAt = $withdrawalMadeAt;
                $ci->WithdrawalAmount = $withdrawalAmount;
                $ci->WithdrawalCompound = $withdrawalCompound;
                $ci->WithdrawalAnnualInflationRate = $withdrawalAnnualInflationRate;

                $ci->write();

            }elseif ($depositMadeAt == 'BeginningOfMonth' && !empty($beginningOfMonthCompIntTwo)) {

                $ci = new CompoundInterest;

                $ci->InitialDeposit = $initialDeposit;
                $ci->Rate = $rateDecimals;
                $ci->CompoundFrequency = $compoundFrequency;
                $ci->TimeYear = $timeYear;
                $ci->TimeMonth = $timeMonth;
                $ci->CompoundInterest = round($beginningOfMonthCompIntTwo, 2);
                $ci->DepositAmount = $depositAmount;
                $ci->DepositCompound = $depositCompound;
                $ci->DepositAnnualInflationRate = $depositAnnualInflationRate;
                $ci->DepositMadeAt = $depositMadeAt;
                $ci->WithdrawalMadeAt = $withdrawalMadeAt;
                $ci->WithdrawalAmount = $withdrawalAmount;
                $ci->WithdrawalCompound = $withdrawalCompound;
                $ci->WithdrawalAnnualInflationRate = $withdrawalAnnualInflationRate;

                $ci->write();
            }
        }elseif (!empty($depositAmount) && !empty($timeMonth)) {

            if ($depositMadeAt == 'EndOfMonth' && !empty($endOfMonthCompIntOne)) {

                $ci = new CompoundInterest;

                $ci->InitialDeposit = $initialDeposit;
                $ci->Rate = $rateDecimals;
                $ci->CompoundFrequency = $compoundFrequency;
                $ci->TimeYear = $timeYear;
                $ci->TimeMonth = $timeMonth;
                $ci->CompoundInterest = round($endOfMonthCompIntOne, 2);
                $ci->DepositAmount = $depositAmount;
                $ci->DepositCompound = $depositCompound;
                $ci->DepositAnnualInflationRate = $depositAnnualInflationRate;
                $ci->DepositMadeAt = $depositMadeAt;
                $ci->WithdrawalMadeAt = $withdrawalMadeAt;
                $ci->WithdrawalAmount = $withdrawalAmount;
                $ci->WithdrawalCompound = $withdrawalCompound;
                $ci->WithdrawalAnnualInflationRate = $withdrawalAnnualInflationRate;

                $ci->write();

            }elseif ($depositMadeAt == 'BeginningOfMonth' && !empty($beginningOfMonthCompIntOne)) {

                $ci = new CompoundInterest;

                $ci->InitialDeposit = $initialDeposit;
                $ci->Rate = $rateDecimals;
                $ci->CompoundFrequency = $compoundFrequency;
                $ci->TimeYear = $timeYear;
                $ci->TimeMonth = $timeMonth;
                $ci->CompoundInterest = round($beginningOfMonthCompIntOne, 2);
                $ci->DepositAmount = $depositAmount;
                $ci->DepositCompound = $depositCompound;
                $ci->DepositAnnualInflationRate = $depositAnnualInflationRate;
                $ci->DepositMadeAt = $depositMadeAt;
                $ci->WithdrawalMadeAt = $withdrawalMadeAt;
                $ci->WithdrawalAmount = $withdrawalAmount;
                $ci->WithdrawalCompound = $withdrawalCompound;
                $ci->WithdrawalAnnualInflationRate = $withdrawalAnnualInflationRate;

                $ci->write();
            }
        }

        // condition to display the table base on either only the years or years and months been entered for the time
        $outPutArray = [];

        $principal = 0;

        if (empty($timeMonth) && empty($depositAmount)) {

            $interest = [];

            $interestResult = 0;

            for ($x = 0; $x <= $timeYear; $x++) { 

                $amount = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency );
    
                if ($x >= 1) {
                    $principal = $amount / ( 1 + $rateDecimals/$compoundFrequency )**$compoundFrequency;
                }
    
                $interest[] = $amount - $initialDeposit;

                foreach($interest as $k => $v){

                    if(isset($interest[$k+1])){

                        $interestResult = $interest[$k+1] - $v;
                    }
                }
    
                $totalInterest = $amount - $initialDeposit;
    
                $outPutArray[] = ArrayData::create([
                    'Year' => $x,
                    'Principal' => number_format($principal, 2),
                    'Interest' => number_format($interestResult, 2),
                    'TotalInterest' => number_format($totalInterest, 2),
                    'Balance' => number_format($amount, 2),
                ]);
            }

            $getTableProjection = new ArrayList($outPutArray);

        }elseif (!empty($timeMonth) && empty($depositAmount)){

            $interest = [];

            $interestResult = 0;

            for ($x = 0; $x <= $timeYear + 1; $x++) { 

                $amount = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency );
    
                if ($x >= 1) {
                    $principal = $amount / ( 1 + $rateDecimals/$compoundFrequency )**$compoundFrequency;
                }
    
                $interest[] = $amount - $initialDeposit;

                foreach($interest as $k => $v){

                    if(isset($interest[$k+1])){

                        $interestResult = $interest[$k+1] - $v;
                    }
                }
    
                $totalInterest = $amount - $initialDeposit;

                if ($x > $timeYear) {
                    
                    $amount = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $timeMonthValue * $compoundFrequency );
    
                    $interestResult = $amount - $futureValue;

                    $principal = $interestResult / $rateDecimals;
        
                    $totalInterest = $amount - $initialDeposit;
                }
    
                $outPutArray[] = ArrayData::create([
                    'Year' => $x,
                    'Principal' => number_format($principal, 2),
                    'Interest' => number_format($interestResult, 2),
                    'TotalInterest' => number_format($totalInterest, 2),
                    'Balance' => number_format($amount, 2),
                ]);
            }

            $getTableProjection = new ArrayList($outPutArray);

        }elseif (!empty($depositAmount) && empty($timeMonth)) {

            if ($depositMadeAt == 'EndOfMonth') {

                $sum = 0;

                $interest = [];

                $interestResult = 0;

                for ($x = 0; $x <= $timeYear; $x++) { 

                    // compound interest formula
                    $compoundInterest = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency );

                    // future value series formula
                    $fValue = $depositAmount * ( (( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency )-1 ) / ($rateDecimals/$compoundFrequency) );

                    // Compound interest formula with regular contributions made at the end of the period  
                    $amount = $compoundInterest + $fValue;
        
                    if ($x >= 1) {
                        $principal = $amount;
                    }

                    if ($x == 0) {
                        $deposit = $initialDeposit;
                    }else {
                        $deposit = $depoAmount;
                    }

                    $totalDeposit = $sum += $deposit;

                    $interest[] = $amount - $totalDeposit;

                    foreach($interest as $k => $v){

                        if(isset($interest[$k+1])){

                            $interestResult = $interest[$k+1] - $v;
                        }
                    }

                    $totalInterest = $amount - $totalDeposit;
        
                    $outPutArray[] = ArrayData::create([
                        'Year' => $x,
                        'Principal' => number_format($principal, 2),
                        'Deposit' => number_format($deposit, 2),
                        'Interest' => number_format($interestResult, 2),
                        'TotalDeposit' => number_format($totalDeposit, 2),
                        'TotalInterest' => number_format($totalInterest, 2),
                        'Balance' => number_format($amount, 2),
                    ]);
                }
    
                $getTableProjection = new ArrayList($outPutArray);

            }elseif ($depositMadeAt == 'BeginningOfMonth') {

                $sum = 0;

                $interest = [];

                $interestResult = 0;

                for ($x = 0; $x <= $timeYear; $x++) { 

                    // compound interest formula
                    $compoundInterest = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency );

                    // future value series formula
                    $fValue = $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $x * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency))*(1 + $rateDecimals/$compoundFrequency);

                    // Compound interest formula with regular contributions made at the beginning of the period  
                    $amount = $compoundInterest + $fValue;
        
                    if ($x >= 1) {
                        $principal = $amount;
                    }

                    if ($x == 0) {
                        $deposit = $initialDeposit;
                    }else {
                        $deposit = $depoAmount;
                    }

                    $totalDeposit = $sum += $deposit;

                    $interest[] = $amount - $totalDeposit;

                    foreach($interest as $k => $v){

                        if(isset($interest[$k+1])){

                            $interestResult = $interest[$k+1] - $v;
                        }
                    }

                    $totalInterest = $amount - $totalDeposit;
        
                    $outPutArray[] = ArrayData::create([
                        'Year' => $x,
                        'Principal' => number_format($principal, 2),
                        'Deposit' => number_format($deposit, 2),
                        'Interest' => number_format($interestResult, 2),
                        'TotalDeposit' => number_format($totalDeposit, 2),
                        'TotalInterest' => number_format($totalInterest, 2),
                        'Balance' => number_format($amount, 2),
                    ]);
                }
    
                $getTableProjection = new ArrayList($outPutArray);
            }
        }elseif (!empty($depositAmount) && !empty($timeMonth)) {

            if ($depositMadeAt == 'EndOfMonth') {

                $sum = 0;

                $interest = [];

                $interestResult = 0;

                for ($x = 0; $x <= $timeYear + 1; $x++) { 

                    // compound interest formula
                    $compInt = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency );

                    if ($x <= $timeYear) {

                        // future value series formula
                        $fValue = $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $x * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency));

                        // Compound interest formula with regular contributions made at the end of the period  
                        $amount = $compInt + $fValue;
                    }elseif ($x > $timeYear) {

                        // future value series formula
                        $fValue = $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $timeMonthValue * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency));

                        // Compound interest formula with regular contributions made at the end of the period  
                        $amount = $compInt + $fValue;
                    }
        
                    if ($x >= 1) {
                        $principal = $amount;
                    }

                    if ($x == 0) {
                        $deposit = $initialDeposit;
                    }elseif($x < $timeYear) {
                        $deposit = $depoAmount;
                    }elseif ($x > $timeYear) {
                        $deposit = $depositAmount * $timeMonth;
                    }

                    $totalDeposit = $sum += $deposit;

                    $interest[] = $amount - $totalDeposit;

                    foreach($interest as $k => $v){

                        if(isset($interest[$k+1])){

                            $interestResult = $interest[$k+1] - $v;
                        }
                    }

                    $totalInterest = $amount - $totalDeposit;
        
                    $outPutArray[] = ArrayData::create([
                        'Year' => $x,
                        'Principal' => number_format($principal, 2),
                        'Deposit' => number_format($deposit, 2),
                        'Interest' => number_format($interestResult, 2),
                        'TotalDeposit' => number_format($totalDeposit, 2),
                        'TotalInterest' => number_format($totalInterest, 2),
                        'Balance' => number_format($amount, 2),
                    ]);
                }
    
                $getTableProjection = new ArrayList($outPutArray);

            }elseif ($depositMadeAt == 'BeginningOfMonth') {

                $sum = 0;

                $interest = [];

                $interestResult = 0;

                for ($x = 0; $x <= $timeYear + 1; $x++) { 

                    // compound interest formula
                    $compInt = $initialDeposit * ( 1 + $rateDecimals/$compoundFrequency )**( $x * $compoundFrequency );

                    if ($x <= $timeYear) {

                        // future value series formula
                        $fValue = $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $x * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency))*(1 + $rateDecimals/$compoundFrequency);

                        // Compound interest formula with regular contributions made at the beginning of the period  
                        $amount = $compInt + $fValue;
                    }elseif ($x > $timeYear) {

                        // future value series formula
                        $fValue = $depositAmount*(((1 + $rateDecimals/$compoundFrequency)**( $timeMonthValue * $compoundFrequency )-1)/($rateDecimals/$compoundFrequency))*(1 + $rateDecimals/$compoundFrequency);

                        // Compound interest formula with regular contributions made at the beginning of the period  
                        $amount = $compInt + $fValue;
                    }
        
                    if ($x >= 1) {
                        $principal = $amount;
                    }

                    if ($x == 0) {
                        $deposit = $initialDeposit;
                    }elseif($x < $timeYear) {
                        $deposit = $depoAmount;
                    }elseif ($x > $timeYear) {
                        $deposit = $depositAmount * $timeMonth;
                    }

                    $totalDeposit = $sum += $deposit;

                    $interest[] = $amount - $totalDeposit;

                    foreach($interest as $k => $v){

                        if(isset($interest[$k+1])){

                            $interestResult = $interest[$k+1] - $v;
                        }
                    }

                    $totalInterest = $amount - $totalDeposit;
        
                    $outPutArray[] = ArrayData::create([
                        'Year' => $x,
                        'Principal' => number_format($principal, 2),
                        'Deposit' => number_format($deposit, 2),
                        'Interest' => number_format($interestResult, 2),
                        'TotalDeposit' => number_format($totalDeposit, 2),
                        'TotalInterest' => number_format($totalInterest, 2),
                        'Balance' => number_format($amount, 2),
                    ]);
                }
    
                $getTableProjection = new ArrayList($outPutArray);
            }
        }

        return $this->customise([
            'Title' => "Calculation Projection",
            'Deposit' => $deposit,
            'TotalDeposit' => number_format($totalDeposit, 2),
            'InitialBalance' => number_format($initialDeposit, 2),
            'EffectiveAnnualRate' => $rate * $compoundRate,
            'CompoundInterest' => number_format($amount, 2),
            'TotalInterestEarned' => number_format($totalInterest, 2),
            'TableProject' => $getTableProjection,
        ])->renderWith(['CalculatorPage', 'Page']);
    } 
}