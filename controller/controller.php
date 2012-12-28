<?
if(!defined('PAGE_STARTED'))
    die();

/**
 * Base controller object
 */
class Controller
{
    /**
     * @var Loader
     */
    protected $load;
    /**
     * @var array
     */
    protected $model;
    /**
     * @var string
     */
    public $template;

    /**
     * Creates base controller, array of models and starts session
     */
    function __construct()
    {

        $this->load = new Loader($this);
        $model = array();
        session_start();
    }

    /**
     * Returns correct template
     * @param $action
     * @return string
     */
    public static final function getTemplate($action)
    {
        if (stripos(strtolower($action), 'ajax') === false)
        {
            return 'index.php';
        }
        else
        {
            return 'ajax.php';
        }
    }

    /**
     * Binds a model object based on object name
     * @param $model
     * @param $model_name
     */
    public final function addModel($model, $model_name)
    {
        $modelvar = "$model_name";
        $$modelvar = $model;
        $this->{"$model_name"} = $model;
    }
    
    public final function showError($error)
    {
        $errors[] = $error;
        $this->load->view('error_show', $errors);
    }
    
    public final function showMessage($message)
    {
        $this->load->view('message', array($message));
    }
    
    public final function addView($name, $data)
    {
        $this->load->view($name, $data);
    }

    /**
     * @param $result
     */
    public function booleanToHeader($result)
    {
        if ($result) {
            header("HTTP/1.1 201");
        } else {
            new Error(new Exception());
        }
    }

    
    function __destruct()
    {   
        $this->load->template($this->template);
        //Session::close();
    }
}
