<?
if(!defined('PAGE_STARTED'))
    die();

/**
 * @param $var
 * @return string
 */
function html($var)
{
    return htmlentities($var, ENT_QUOTES, "UTF-8");
}

/**
 * @param $id
 * @return bool
 */
function is_id($id)
{
    if(ctype_digit($id))
        return true;
    else
        return false;
}
