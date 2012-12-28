<?
if(!defined('PAGE_STARTED')) die();

/**
 * Binds model, view controller by loading related classes and provides generic shared data object
 */
class Loader
{
    /**
     * @var
     */
    private $controller;
    /**
     * @var array
     */
    private $views;
    /**
     * @var array
     */
    private $data;
    /**
     * @var
     */
    private $log;

    /**
     * @param $controller
     */
    function Loader($controller)
    {
        $this->controller = $controller;
        $this->views = array();
        $this->data = array();
    }

    /**
     * @param $name
     * @param bool $parameters
     * @throws Exception
     */
    public function model($name)
    {
        $modelFileName = DOC_ROOT."/model/".strtolower($name).".php";

        $model = strtolower($name);
        $modelName = ucfirst($model);

        if (file_exists($modelFileName))
        {
            /** @noinspection PhpIncludeInspection */
            require_once $modelFileName;

            $model = new $modelName;

            $this->controller->addModel($model, $modelName);
        }
        else
        {
            throw new Exception("Model (".$modelName.") is missing. Could not load (".$modelFileName.")" );
        }
    }

    /**
     * @param string $name
     * @param array $data
     * @throws Exception
     */
    function template($name = "index.php", $data = array())
    {

        $views = $this->views;
        $this->data[$name] = $data;

        if($name != null && $name != '')
        {
            $templateFileName = DOC_ROOT."/template/".$name;

            if (file_exists($templateFileName))
            {

                try
                {
                    /** @noinspection PhpIncludeInspection */
                    include_once $templateFileName;
                }
                catch (Exception $e)
                {
                    throw new Exception("Could not load template:".$templateFileName." because:".$e->getMessage());
                }
            }
        }


    }

    /**
     * @param $view
     * @param array $data
     */
    function view($view, $data = array())
    {
        $view = strtolower($view);
        $this->views[$view] = $view;
        $this->data[$view] = $data;
    }

    /**
     * @param $name
     */
    function show($name)
    {
        $name = strtolower($name);
        $view = $this->views[$name];
        $data = $this->data[$name];
        require_once DOC_ROOT.'/helper/security.php';
        /** @noinspection PhpIncludeInspection */
        require_once sprintf('%s/view/%s.php', DOC_ROOT, $view);
    }
    
}
