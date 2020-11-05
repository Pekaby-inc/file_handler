<?
/**
 * 
 */
abstract class debug_module
{
    public static final function debug()
    {
        global $_FILES;
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";
    }
    public final function get_file_type()
    {
        return $this->files[$this->inp_name]['type'];
    }
    public final function get_file_name()
    {
        return $this->files[$this->inp_name]['name'];
    }
    public final function get_errors()
    {
        return $this->errors;
    }
    public final function get_last_error()
    {
        return end($this->errors);
    }
    // im too stupid for making algorithms
    public final function get_usr_id()
    {
        return $this->un_id;
    }
}