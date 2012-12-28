<?

class Error
{

    public function __construct(Exception $error)
    {
        header('HTTP/1.1 500 Internal Server Error');
        if (isset($error))
        {
            $message = $error->getMessage();
            if (!empty($message))
            {
                echo(json_encode($error->getMessage()));
            }
        }
    }

}
