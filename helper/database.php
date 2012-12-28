<?

/**
 * Implements access to relational database storage
 */
final class Database
{
    /**
     * @var PDO
     */
    private static $db;
    /**
     * @var int
     */
    public static $lastId = 0;

    /**
     * @param $dsn
     * @param $username
     * @param $password
     */
    public function __construct($dsn, $username, $password)
    {
        $this->init($dsn, $username, $password);
    }

    /**
     * @param $dsn
     * @param $username
     * @param $password
     * @throws Exception
     */
    public static final function init($dsn, $username, $password)
    {
        if (empty($dsn))
        {
            throw new Exception('Could not initialise database, parameter dsn is empty.');
        }

        if (empty($username))
        {
            throw new Exception('Could not initialise database, database connection parameter username is empty.');
        }

        if (empty($password))
        {
            throw new Exception('Could not initialise database, database connection parameter password is empty.');
        }

        self::$db = new PDO($dsn, $username, $password);
        self::exec('set names utf8');
    }


    /**
     * Executes a statement without any results set
     * @param $query
     * @param null $args
     * @return PDOStatement
     * @throws Exception
     */
    public final function exec($query, $args = null)
    {
        $statement = self::$db->prepare($query);
        if(is_array($args))
        {
            foreach($args as $arg)
            {
                // param name, param value, param type
                $statement->bindParam($arg[0], $arg[1], $arg[2]);
            }
        }
        else
        {
            //var_dump('no params');
        }

        if($statement->execute())
        {
            self::$lastId = self::$db->lastInsertId();
            return $statement;
        }
        else
        {
            $error_message = sprintf('Could not execute database statement: %s because %s', json_encode($query), json_encode($statement->errorInfo()));
            throw new Exception($error_message);
        }
    }

    /**
     * Executes a query with a single results set (query)
     * @param $query
     * @param null $args
     * @return array
     */
    public final function query($query, $args = null)
    {
        $q = self::exec($query,$args);
        $res = $q->fetchAll(PDO::FETCH_ASSOC);
        $q->closeCursor();
        return $res;
    }

    /**
     * Executes a query with a single value result (scalar)
     * @param $query
     * @param null $args
     * @return array of the first row of the results set
     */

    public final function scalar($query, $args = null)
    {
        $result = self::query($query, $args);
        return $result[0];
    }

    /**
     * Escapes characters for use in storage
     * @param $str
     * @return string
     */
    public static final function escape($str)
    {
        return htmlspecialchars($str);
    }
    

}
   