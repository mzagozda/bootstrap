<?
if(!defined('PAGE_STARTED'))
    die();

class Page extends Model
{

    function __construct()
    {

    }

    /**
     * Returns about
     * @return mixed
     */
    public final function GetTitle()
    {
        return 'Loan Calculator';
    }


}
