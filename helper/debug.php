<?

require_once DOC_ROOT . '/config/config.php';

abstract class Debug
{
    abstract function ShowDebug($procedure, $variable, $value);
}