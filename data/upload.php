<?php 
error_reporting(E_ALL);
include 'config.php';

try {
    //check filesize here.
    foreach ( $_FILES['file']['size'] as $key => $value ) {
        if ($value > 52428800) {
            throw new RuntimeException('Ошибка загрузки. Файл слишком большой. Обратитесь к администратору.');
        }
    }
$folderName = "../files/".explode('/', $_POST["num"])[1];
    if (is_dir($folderName)) {
        throw new RuntimeException('Ошибка загрузки. Папка уже существует. Обратитесь к администратору.');
    } else {
        mkdir($folderName, 0700);
    }
foreach ($_FILES["file"]["error"] as $key => $error) {
    if ($error == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["file"]["tmp_name"][$key];
        // basename() может спасти от атак на файловую систему;
        // может понадобиться дополнительная проверка/очистка имени файла
        $name = basename($_FILES["file"]["name"][$key]);
        move_uploaded_file($tmp_name, $folderName.'/'."$name");
    }
}

$query = "update request set status = 'Новый' where numLog = '".$_POST["num"]."'";

$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();

    echo 'Файлы запроса №'.$_POST["num"].' успешно загружены';

} catch (RuntimeException $e) {

    echo $e->getMessage();

}

$stmt = null;
$conn = null;
?>