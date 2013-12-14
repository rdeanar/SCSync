<?

/**
 * Class db
 * Handle all data to store in db
 */
class db{

    public $db_file;

    public function __construct($file){
        $this->db_file = dirname(__FILE__).'/'.$file;

    }

    public function addLink($link){
        $filename = $this->db_file;
        $out = fopen($filename, "a");
        fwrite($out, $link.PHP_EOL);
        fclose($out);
    }

    public function getLinksArray(){
        $handle = fopen($this->db_file, "r");
        if($handle && filesize($this->db_file) > 0){
            $contents = fread($handle, filesize($this->db_file));
        }else{
            $contents = '';
        }
        if($handle) fclose($handle);

        $array = explode(PHP_EOL,$contents);

        array_pop($array);
        return $array;
    }

    public function saveAuth($link){
        $filename = $this->db_file;
        $out = fopen($filename, "w");
        fwrite($out, $link);
        fclose($out);
    }


    public function getAuth(){
        $handle = fopen($this->db_file, "r");
        $contents = fread($handle, filesize($this->db_file));
        fclose($handle);
        return $contents;
    }

}