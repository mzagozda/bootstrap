<?
if(!defined('PAGE_STARTED'))
    die();

require_once DOC_ROOT.'/model/model.php';
require_once DOC_ROOT.'/model/error.php';
require_once DOC_ROOT.'/model/repayment.php';

class Loan extends Model
{

    function load()
    {
    }

    public $Price;
    public $Rate;
    public $Term;
    public $Deposit;

    function __construct()
    {
        $this->Price = 0;
        $this->Rate = 0;
        $this->Term = 0;
        $this->Deposit = 0;
    }

    /**
     * Returns calculated total payment amount for fixed rate loan
     * @param $loanAmount
     * @param $durationMonths
     * @param $interestMonthly
     * @internal param $userId - this can be either operator or user
     * @return mixed
     */
    private final function ReturnPaymentAmount($loanAmount, $durationMonths, $interestMonthly)
    {
        return ($loanAmount * $interestMonthly) / (1 - pow((1+$interestMonthly), -$durationMonths));
    }

    /**
     * @return array of Repayments
     */
    public final function GetRepayments()
    {
        $currentBalanceAmount = $this->Price - $this->Deposit;
        $monthlyInterestRate = ($this->Rate/100) / 12;

        $monthlyPaymentAmount = $this->ReturnPaymentAmount($currentBalanceAmount, $this->Term, $monthlyInterestRate);

        $result = null;

        for ($currentRepayment = 1; $currentRepayment <= $this->Term; $currentRepayment++)
        {
            $interestAmount = $currentBalanceAmount * $monthlyInterestRate;
            $deductedBalance = $monthlyPaymentAmount - $interestAmount;
            $currentBalanceAmount = $currentBalanceAmount - $deductedBalance;

            $monthlyDetail = new Repayment();
            $monthlyDetail->Month = $currentRepayment;
            $monthlyDetail->Balance = $currentBalanceAmount;
            $monthlyDetail->PrincipalPaid = $deductedBalance;
            $monthlyDetail->InterestPaid = $interestAmount;
            $monthlyDetail->Payment = $monthlyPaymentAmount;

            $result[] = $monthlyDetail->ToArray();
        }

        return array('repayments' => $result);


    }

}