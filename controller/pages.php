<?
if(!defined('PAGE_STARTED')) die();

class Pages extends Controller
{

    /**
     * example of usage
     * $data['href_new_account'] = $this->Page->getNewAccountLink();
     * $data['lang_new_account'] = $this->Page->getNewAccountText();
     * $this->load->view('login_form', $data);
     * @var Page
     */
    protected $Page;
    
    function index() 
    {

        $this->load->model('Page');
        $data['content'] = 'calc';
        $data['title'] = $this->Page->GetTitle();
        $this->load->template('index.php', $data);

    }

    function about()
    {
        $data['content'] = 'about';
        $data['title'] = 'About';

    }

}