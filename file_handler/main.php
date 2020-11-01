<?
/**
 * Main class for file_handler
 */
class file_handler
{
    public $fatal_enable = false;

    private $acp = false;

    private $errors = array();
    private $errors_file_int = array();
    private $accepted = array();

    private $files;
    private $name;
    private $path = 'file_handler/files/';

    public $usr_id;
    public $inp_name = 'file';

    public $black_list = ['application/x-msdownload', 'text/javascript'];
    function __construct()
    {
        self::debug();
        $this->checker();
    }
    private function checker()
    {
        global $_FILES;
        if (!empty($_FILES)) {
            $this->files = $_FILES;
            foreach ( $this->files[$this->inp_name]['type'] as $key => $value) {
                if (in_array($value, $this->black_list)) {
                    $this->errors[] = "Blocked file type: <b>" . $value . "</b>";
                    $this->errors_file_int[] = $key;
                }else{
                    $this->accepted[] = $key;
                }
            }
        }

        if (!empty($this->errors)) {
            if ($this->fatal_enable == true) {
                exit();
            }else{
                $this->display_errors();
                return true;
            }
        }

    }
    public function display_errors()
    {
        $i = 0;
        foreach ($this->errors as $key => $value) {
            echo "<b>ERROR:</b> " . $value . " <b>" . $this->files[$this->inp_name]['name'][$this->errors_file_int[$i]] . "</b><br>";
            $i = +1;
        }
    }
    private function prepare_file($name)
    {
        return htmlspecialchars($this->files[$this->inp_name]['name'][$name]);
    }
    private function user_prepare()
    {
        if (file_exists($this->path.$this->usr_id)) {
            return true;
        }else{
            mkdir($this->path.$this->usr_id);
            $q = file_exists($this->path.$this->usr_id);
            if ($q == true) {
                return true;
            }else{
                return false;
            }
        }
    }
    public function save_file()
    {
        $user_prepare = $this->user_prepare();
        if (!$user_prepare) {
            $this->errors[] = "Can't write for this user.";
            return false;
            exit;
        }

        foreach ($this->accepted as $key => $value) {
            $q = move_uploaded_file($this->files[$this->inp_name]['tmp_name'][$value], $this->path.$this->usr_id.'/'.$this->files[$this->inp_name]['name'][$value]);
            if (!$q) {
                unlink($this->path.$this->usr_id.'/'.$this->prepare_file($this->files[$this->inp_name]['name'][$value]));
                move_uploaded_file($this->files[$this->inp_name]['tmp_name'][$value], $this->path.$this->usr_id.'/'.$this->prepare_file($this->files[$this->inp_name]['name'][$value]));
                return true;
            }

        }
        return true;
    }
}
