<?php
error_reporting(E_ALL);
include 'config.php';

if (isset($_GET['getNumLog'])) {
    $numLog = htmlspecialchars($_GET["getNumLog"]);
    $query = "SELECT numLog FROM request WHERE ID = (SELECT max(ID) FROM request)";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $rows['numLog'];
} else {

    if ($_GET['decType'] == 'FL') {
        if (isset($_GET["agentFLSwitch"])) {
            $agentFLSwitch = $_GET["agentFLSwitch"];
        } else {
            $agentFLSwitch = 'off';
        }

        $svc = '';
        $i = 1;
        do {
            if (isset($_GET["svc-$i"])) {
                $svc = $svc.';'.$i;
            }
            $i++;
        } while ($i <= 11);
        $svc = substr($svc, 1);

        $path = 'files/'.explode('/', htmlspecialchars($_GET["reqNum"]))[1];
        $Name = htmlspecialchars($_GET["dFLName"]);
        $BDay = htmlspecialchars($_GET["dFLBD"]);
        $Phone = htmlspecialchars($_GET["dFLPhone"]);
        $Email = htmlspecialchars($_GET["dFLEmail"]);
        $Address = htmlspecialchars($_GET["dFLAddress"]);
        $NumDUL = htmlspecialchars($_GET["dFLNumDUL"]);
        $DateDUL = htmlspecialchars($_GET["dFLDateDUL"]);
        $WhoDUL = htmlspecialchars($_GET["dFLWhoDUL"]);
        $AgentName = htmlspecialchars($_GET["dFLAgentName"]);
        $AgentDoc = htmlspecialchars($_GET["dFLAgentDoc"]);
        $reqNum = htmlspecialchars($_GET["reqNum"]);
        $reqDate = date( "Y-m-d", strtotime(htmlspecialchars($_GET["reqDate"])));
        $reqObjAddress = htmlspecialchars($_GET["reqObjAddress"]);
        $reqComment = htmlspecialchars($_GET["reqComment"]);
        $delivery = htmlspecialchars($_GET["delivery"]);
        $attachList = htmlspecialchars($_GET["attachList"]);

        //отправляем запрос, получаем номер запроса и ID
        try {
            $query = "{call AddRequestFL(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $Name, PDO::PARAM_STR);
            $stmt->bindParam(2, $BDay, PDO::PARAM_STR);
            $stmt->bindParam(3, $Phone, PDO::PARAM_STR);
            $stmt->bindParam(4, $Email, PDO::PARAM_STR);
            $stmt->bindParam(5, $Address, PDO::PARAM_STR);
            $stmt->bindParam(6, $NumDUL, PDO::PARAM_STR);
            $stmt->bindParam(7, $DateDUL, PDO::PARAM_STR);
            $stmt->bindParam(8, $WhoDUL, PDO::PARAM_STR);
            $stmt->bindParam(9, $agentFLSwitch, PDO::PARAM_STR);
            $stmt->bindParam(10, $AgentName, PDO::PARAM_STR);
            $stmt->bindParam(11, $AgentDoc, PDO::PARAM_STR);
            $stmt->bindParam(12, $reqNum, PDO::PARAM_STR);
            $stmt->bindParam(13, $reqDate, PDO::PARAM_STR);
            $stmt->bindParam(14, $reqObjAddress, PDO::PARAM_STR);
            $stmt->bindParam(15, $reqComment, PDO::PARAM_STR);
            $stmt->bindParam(16, $svc, PDO::PARAM_STR);
            $stmt->bindParam(17, $delivery, PDO::PARAM_STR);
            $stmt->bindParam(18, $attachList, PDO::PARAM_STR);
            $stmt->bindParam(19, $path, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($rows);
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        //отправляем файлы в папку ID запроса

    }


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

$stmt = null;
$conn = null;
?>




