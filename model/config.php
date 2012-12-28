<?
if(!defined('PAGE_STARTED')) die();

/**
 * Configuration repository
 */
class Config extends Model
{
    private static $config = array();

    /**
     * Loads configuration
     */
    function load()
    {
        // TODO: not implemented
    }

    /**
     * Returns configuration value by key
     * @param $key
     * @return string
     */
    function get($key)
    {
        return stripslashes($this->config[$key]);
    }

    /**
     * Sets configuration value using key/value
     * @param $key
     * @param $val
     */
    function set($key, $val)
    {
        $config[$key] = $val;
        
    }

}
