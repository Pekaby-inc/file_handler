<?
include 'file_handler/main.php';

$file_handler = new file_handler;
$file_handler->save_file();
?>

<form action="/" method="post" enctype="multipart/form-data">
    <input type="file" name="file[]" multiple="">
    <input type="submit">
</form>
