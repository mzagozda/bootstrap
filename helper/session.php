<?

/**
 * Session wrapper
 */
class Session {

    /**
     * starts session
     */
    function start()
    {
        session_start();
    }

    /**
     * Sets session value
     * @param $key
     * @param $val
     */
    function set($key, $val)
    {
        $_SESSION[$key] = $val;
    }

    /**
     * Gets value from session
     * @param $key
     * @return mixed
     */
    function get($key)
    {
        return $_SESSION[$key];
    }

    /**
     * Deletes value from session
     * @param $key
     */
    function del($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Checks if value exists in session
     * @param $key
     * @return bool
     */
    function check($key)
    {
        if(isset($_SESSION[$key]))
            return true;
        else
            return false;
    }

    /**
     * Clears session object
     */
    function clear()
    {
        session_destroy();
    }

    /**
     * Closes session with flush
     */
    function close()
    {
        session_write_close();
    }
}
