<?
if(!defined('PAGE_STARTED')) die();

/**
 * Implements router helper for model-view-controller pattern
 */
class Router {


    /**
     * @return string returns controller based on parameter: c or: Page
     */
    public final static function getController()
    {
        $c = $_GET['c'];
        if(empty($c))
        {
            return PAGE_DEFAULT_CONTROLLER;
        }
        $c = strtolower($c);
        $c = ucfirst($c);
        
        if(ctype_alnum($c))
        {
            return $c;
        }
        else
        {
            return "errors";
        }
    }

    /**
     * @return string returns controller file name based on parameter: c or: pages.php
     */
    public final static function getControllerFile()
    {
        $c = $_GET['c'];
        if(empty($c))
        {
            $c = PAGE_DEFAULT_CONTROLLER;
        }
        
        $c = strtolower($c);
        
        if(file_exists("controller/$c.php") AND ctype_alnum($c))
        {
            return $c.".php";
        }
        else
        {
            return "errors.php";
        }
    }

    /**
     * @param $controller
     * @return string controller action name based on parameter: a or: index
     * @throws Exception
     */
    public final static function getAction($controller)
    {
        $a = $_GET['a'];
        if(!empty($a))
        {
            if(method_exists($controller, $a) AND ctype_alnum($a))
            {
                return $a;
            }
            else
            {
                throw new Exception('Invalid action passed: '.$a);
            }
        }
        return "index";
    }

    /**
     * TODO: Rewrite .htaccess functionality to remove dependency on php://input
     * @return array of parameters
     */
    public final static function getParameters()
    {
        $parameters =  $_REQUEST;
        $json = json_decode(file_get_contents('php://input'));

        if(!empty($json))
        {
           return array_merge($parameters,(array)$json);
        }else
        {
           return $parameters;
        }
    }

}
