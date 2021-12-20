<?php
error_reporting(E_ALL);
include 'config.php';
//список svc отправлять в виде 1;2;3

if (isset($_GET['getNumLog'])) {
    $numLog = htmlspecialchars($_GET["getNumLog"]);
    $query = "SELECT numLog FROM request WHERE ID = (SELECT max(ID) FROM request)";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $rows['numLog'];
} else {
    // foreach ($_GET as $param_name => $param_val) {
    //     echo "Param: $param_name; Value: $param_val<br />\n";
    // }


/*
//складываем файлы
$reqID = '1';
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
*/
}




// $start = date( "Y-m-d", strtotime(htmlspecialchars($_GET["start"])));
// $end = date( "Y-m-d", strtotime(htmlspecialchars($_GET["end"])));

// $query = "insert ...";

// $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
// $stmt->execute();
// $rowCount = $stmt->rowCount();

// $rows = [];
// $a = [];
// foreach ($stmt as $row) {
//     for ($i = 0; $i < $stmt->columnCount(); $i++) {
//         $col = $stmt->getColumnMeta($i);
//         $colName = $col['name'];
//         array_push($a, $row[$colName]);
//     }
//     array_push($rows, $a);
//     $a = [];
// }

//$d = array('draw' => '1', 'recordsTotal' => $rowCount, 'recordsFiltered' => $rowCount, 'data' => $rows);
//echo json_encode($d);
$stmt = null;
$conn = null;
?>




