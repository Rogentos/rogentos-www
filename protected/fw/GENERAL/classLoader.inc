<?php

class ClassLoader {

    private static $saveFile = '../protected/fw/GENERAL/ClassLoader.save.php';

    /* singleton */
    private static $instance;

    /* stores a className -> filePath map */
    private $classList;
    /* tells whether working from saved file */
    private $refreshed;


    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new ClassLoader();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->initClassList();
    }

    public function loadClass($className) {
        if ( !array_key_exists($className, $this->classList) && !$this->refreshed ) {
            $this->refreshClassList();
        }
        include_once($this->classList[$className]);
    }

    private function initClassList() {


        if (file_exists(self::$saveFile)) {
            require_once(self::$saveFile);
            $this->refreshed = FALSE;
        } else {
            $this->refreshClassList();
        } 
    }

    private function refreshClassList() {
        $this->classList = $this->scanDirectory(fw_incPath);
        $this->refreshed = TRUE;

        $this->saveClassList();
    }

    private function saveClassList() {
        $handle = fopen(self::$saveFile, 'w');
        fwrite($handle, "<?php\r\n");

        foreach($this->classList as $class => $path) {
            $line = '$this->classList' . "['" . $class . "'] = '" . $path . "';\r\n";
            fwrite($handle, $line);
        }

        fwrite($handle, '?>');
        fclose($handle);
    }

    private function scanDirectory ($directory) {
        // strip closing '/'
        if (substr($directory, -1) == '/') {
                $directory = substr($directory, 0, -1);
        }

        if (!file_exists($directory) || !is_dir($directory) || !is_readable($directory)) {
            return array();
            throw new Exception ('Cannot enter dir!');
        }

        $dirH = opendir($directory);
        $scanRes = array();

        while(($file = readdir($dirH)) !== FALSE) {

            // skip pointers
            if ( strcmp($file , '.') == 0 || strcmp($file , '..') == 0 || strcmp($file , '.svn') == 0) {
                continue;
            }

            $path = $directory . '/' . $file;

            if (!is_readable($path)) {
                continue;
            }

            // recursion
            if (is_dir($path)) {
                $scanRes = array_merge($scanRes, $this->scanDirectory($path));

            } elseif (is_file($path)) {
                $className = explode('.', $file);
                if ( strcmp($className[2], 'php') != 0 ) {
                    $scanRes[$className[0]] = $path; 
                }
            }
        }

        return $scanRes;
    }

}
?>