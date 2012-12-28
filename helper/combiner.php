<?

/**
 * Combines files
 */
class Combiner
{
    /**
     * Combines files
     * @param String $headFile file to start with
     * @param Boolean $allowDuplicated if should multiple times include same file
     * @param bool $quiet
     * @internal param bool $quite if shouldn't print statuses
     * @return String
     */
    public static function combine($headFile, $allowDuplicated = false, $quiet = false)
    {
        self::$root = dirname($headFile);
        $headFile = substr($headFile,strlen(self::$root)+1);
        self::$loaded = array();
        self::$quiet = $quiet;
        self::$allowDuplicated = $allowDuplicated;
        return self::load($headFile);        
    }
    
    /**
     * Loads and parses file
     * @param String $file path to file
     * @return String parsed code
     */
    private static function load($file)
    {
        if(!preg_match('/^http(|s):\/\//',$file))
        {
            $file = self::$root . '/' . $file;
        }
        
        if(!self::$allowDuplicated)
        {
            if(in_array($file, self::$loaded))
            {
                return '';
            }
        }
        self::$loaded[] = $file;
        if(!self::$quiet) echo 'LOADING ' . $file . PHP_EOL;
        
        $content = file_get_contents($file);
        if(preg_match_all('|/\*(\s*)IMPORT\((.+)\)(\s*)\*/|',$content, $out))
        {
            $r = self::$root;
            self::$root = dirname($file);            
            $l = count($out[0]);
            for($i = 0; $i < $l; $i++)
            {
                $sub = self::load($out[2][$i]);                
                $content = str_replace($out[0][$i],$sub,$content);
            }
            self::$root = $r;        
        }
        return $content;
    }
    
    /**
     * Obfuscates given JS script
     * @param String $source
     * @return String
     */
    public static final function obfuscateJS($source)
    {
        $jsStr = preg_replace('~[^"\'\(]// ([^\r\n]*)[^"\'\)]~', '/*$1 */', $source);
        $jsStr = str_replace("\t", "", $jsStr);
        $jsStr = str_replace(" = ", "=", $jsStr);
        $jsStr = str_replace(") {", "){", $jsStr);
        $jsStr = str_replace(" ( ", "(", $jsStr);
        $jsStr = str_replace(" ) ", ")", $jsStr);
        $jsStr = str_replace("; ", ";", $jsStr);
        $jsStr = str_replace("if ", "if", $jsStr);
        $jsStr = str_replace("for ", "for", $jsStr);
        $jsStr = str_replace(" >= ", ">=", $jsStr);
        $jsStr = str_replace(" + ", "+", $jsStr);
        $jsStr = str_replace(" - ", "-", $jsStr);
        $jsStr = str_replace(" * ", "*", $jsStr);
        $jsStr = str_replace(" / ", "/", $jsStr);
        $jsStr = str_replace(" || ", "||", $jsStr);
        $jsStr = str_replace(" && ", "&&", $jsStr);
        $jsStr = str_replace("try ", "try", $jsStr);
        $jsStr = str_replace(", ", ",", $jsStr);
        $jsStr = str_replace(" == ", "==", $jsStr);
        $jsStr = str_replace(" != ", "!=", $jsStr);
        $jsStr = str_replace(": ", ":", $jsStr);
        $jsStr = preg_replace('|^(\s+)|m','',$jsStr);
        return $jsStr;
    }

    /**
     * Obfuscates given CSS script
     * @param String $source
     * @return String
     */
    public static final function obfuscateCSS($source)
    {
        $content = preg_replace('/\/\*(.+?)\*\//','',$content);
        $content = preg_replace('/(\n|\r)/','',$content);
        $content = preg_replace('/(\s{1})(\s+)/',' ',$content);
        $content = preg_replace('/^(\s+)/','',$content);
        $content = preg_replace('/(\s*)(,|;|{|}|:)(\s*)/','$2',$content);
        return $content;
    }

    /**
     * @var string
     */
    private static $root = '';
    /**
     * @var bool
     */
    private static $allowDuplicated = false;
    /**
     * @var
     */
    private static $loaded;
    /**
     * @var bool
     */
    private static $quiet = false;
}