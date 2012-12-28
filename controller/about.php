<?
if(!defined('PAGE_STARTED')) die();

class About extends Controller
{

    /**
     * example of usage
     * $data['href_new_account'] = $this->Page->getNewAccountLink();
     * $data['lang_new_account'] = $this->Page->getNewAccountText();
     * $this->load->view('login_form', $data);
     * @var Page
     */

    function index()
    {
        $data['content'] = 'about';
        $data['title'] = 'About';
        $this->load->template('index.php', $data);

    }

}