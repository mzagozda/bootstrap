<?
/**
 * Fixed loan class
 */

class Repayment
{
    public $Month;
    public $Balance;
    public $PrincipalPaid;
    public $InterestPaid;
    public $Payment;

    public final function ToArray()
    {
        return array(
            'Month' => sprintf('%s', $this->Month),
            'Balance' => sprintf('%.2f', abs($this->Balance)),
            'PrincipalPaid' => sprintf('%.2f', $this->PrincipalPaid),
            'InterestPaid' => sprintf('%.2f', $this->InterestPaid),
            'Payment' => sprintf('%.2f', $this->Payment)
        );
    }
}