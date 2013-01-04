<?
require_once DOC_ROOT . '/config/config.php';

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
{
    header('Content-type: application/json');
}
else
{
    die('This page cannot be accessed directly');
}
