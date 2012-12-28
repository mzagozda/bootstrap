<?
if(!defined('PAGE_STARTED'))
    die();

class Errors extends Controller {
    
    function index()
    {
        $this->load->view('message', array('no_class_found'));

    }
}
