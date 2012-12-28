<?
if(!defined('PAGE_STARTED')) die();

class Calculator extends Controller
{
    /**
     * @var Loan
     */
    protected $Loan;

    /**
     *
     */
    function __construct()
    {
        parent::__construct();
        $this->template = "ajax.php";
    }

    /**
     * @param $parameters
     */
    function Calculate($parameters)
    {
        $this->load->model('Loan');
        $this->Loan->Price = $parameters['price'];
        $this->Loan->Rate = $parameters['rate'];
        $this->Loan->Term = $parameters['term'];
        $this->Loan->Deposit = $parameters['deposit'];
        echo json_encode($this->Loan->GetRepayments());
    }


}
