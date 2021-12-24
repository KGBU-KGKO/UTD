<?php 
error_reporting(E_ALL);
include 'config.php';

//складываем файлы
$reqID = explode('/', $_POST["num"])[1];
mkdir("../files/".$reqID, 0700);

foreach ($_FILES["file"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["file"]["tmp_name"][$key];
        // basename() может спасти от атак на файловую систему;
        // может понадобиться дополнительная проверка/очистка имени файла
        $name = basename($_FILES["file"]["name"][$key]);
        move_uploaded_file($tmp_name, '../files/'.$reqID.'/'."$name");
    }
}

$query = "update request set status = 'Новый' where numLog = '".$_POST["num"]."'";

$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();

$stmt = null;
$conn = null;
?>