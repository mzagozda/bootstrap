<?
if(!defined('PAGE_STARTED')) die();

/*
 * Defines the base object for all data models
 */

require_once DOC_ROOT.'/config/config.php';
require_once DOC_ROOT.'/config/database.php';
require_once DOC_ROOT.'/helper/database.php';
require_once DOC_ROOT.'/helper/session.php';
require_once DOC_ROOT.'/model/logger.php';

class Model
{

    private $initialised = false;

    /**
     * @var Database
     */
    protected $storage;
    /**
     * @var FileLogger
     */
    public $logger;
    /**
     * @var Session
     */
    protected $session;

    /**
     * Public constructor
     */
    public function __construct()
    {
        if ($this->initialised == false)
        {
            $this->Model();
        }
    }

    /**
     * Constructs model base
     */
    public final function Model()
    {
        $this->session = new Session();
        $this->storage = new Database('mysql:host='.DBC_HOSTNAME.';dbname='.DBC_DATABASE, DBC_USERNAME, DBC_PASSWORD);
        $this->logger = new FileLogger(DOC_ROOT.PAGE_LOG_FILE, FileLogger::DEBUG);
        $this->initialised = true;
    }
}
