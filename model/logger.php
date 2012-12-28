<?

/*
 * Text logger helper
 * Usage:
 *		$log = new FileLogger ( "log.txt" , FileLogger::INFO );
 *		$log->LogInfo("Returned a million search results");	// Prints to the log file
 *		$log->LogFATAL("Oh dear.");				            // Prints to the log file
 *		$log->LogDebug("x = 5");					        // Prints nothing due to priority setting
*/

class FileLogger
{

    /**
     * Most Verbose
     */
    const DEBUG = 1;
    const INFO = 2;
    const WARN = 3;
    const ERROR = 4;
    /**
     * Least Verbose
     */
    const FATAL = 5;
    /**
     * Nothing at all
     */
    const OFF = 6;

    const LOG_OPEN = 1;
    const OPEN_FAILED = 2;
    const LOG_CLOSED = 3;

    public $LogStatus = FileLogger::LOG_CLOSED;
    public $DateFormat = 'Y-m-d G:i:s';
    public $MessageQueue;

    private $logFile;
    private $priority = FileLogger::INFO;

    private $file_handle;

    public function __construct($filepath, $priority)
    {
        if ($priority == FileLogger::OFF) return;

        $this->logFile = $filepath;
        $this->MessageQueue = array();
        $this->priority = $priority;

        if (file_exists($this->logFile)) {
            if (!is_writable($this->logFile)) {
                $this->LogStatus = FileLogger::OPEN_FAILED;
                $this->MessageQueue[] = 'The file exists, but could not be opened for writing. Check that appropriate permissions have been set.';
                return;
            }
        }

        if ($this->file_handle = fopen($this->logFile, 'a')) {
            $this->LogStatus = FileLogger::LOG_OPEN;
            $this->MessageQueue[] = 'The log file was opened successfully.';
        } else {
            $this->LogStatus = FileLogger::OPEN_FAILED;
            $this->MessageQueue[] = 'The file could not be opened. Check permissions.';
        }

        return;
    }

    public function __destruct()
    {
        if ($this->file_handle)
            fclose($this->file_handle);
    }

    /**
     * Logs information to a file
     *
     * @param $line string line to log
     */
    public function LogInfo($line)
    {
        $this->Log($line, FileLogger::INFO);
    }

    /**
     * @param $line
     */
    public function LogDebug($line)
    {
        $this->Log($line, FileLogger::DEBUG);
    }


    /**
     * @param $line
     */
    public function LogWarn($line)
    {
        $this->Log($line, FileLogger::WARN);
    }

    /**
     * @param $line
     */
    public function LogError($line)
    {
        $this->Log($line, FileLogger::ERROR);
    }

    /**
     * @param $line
     */
    public function LogFatal($line)
    {
        $this->Log($line, FileLogger::FATAL);
    }

    public function Log($line, $priority)
    {
        if ($this->priority <= $priority) {
            $status = $this->getTimeLine($priority);
            $this->WriteFreeFormLine("$status $line \n");
        }
    }

    /**
     * @param $line
     */
    public function WriteFreeFormLine($line)
    {
        if ($this->LogStatus == FileLogger::LOG_OPEN && $this->priority != FileLogger::OFF) {
            if (fwrite($this->file_handle, $line) === false) {
                $this->MessageQueue[] = 'The file could not be written to. Check that appropriate permissions have been set.';
            }
        }
    }

    /**
     * @param $level
     * @return string
     */
    private function getTimeLine($level)
    {
        $time = date($this->DateFormat);

        switch ($level) {
            case FileLogger::INFO:
                return "$time - INFO  -->";
            case FileLogger::WARN:
                return "$time - WARN  -->";
            case FileLogger::DEBUG:
                return "$time - DEBUG -->";
            case FileLogger::ERROR:
                return "$time - ERROR -->";
            case FileLogger::FATAL:
                return "$time - FATAL -->";
            default:
                return "$time - LOG   -->";
        }
    }

}
