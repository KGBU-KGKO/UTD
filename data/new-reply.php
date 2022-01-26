<?php
include 'config.php';
include 'getLastNum.php';

if (isset($_GET["checkRequest"])) {
    $reqNum = $_GET["reqNum"];
    $check = checkRequest($reqNum);
    echo json_encode($check);
    die();
}

if (isset($_GET['status'])) {

    $reqNum = $_GET["reqNum"];
    $repNum = getNum('reply');
    $repDate = $_GET["repDate"];
    $repPerformer = $_GET["repPerformer"];
    if (substr($_GET["status"], 0, 10) == "Отказ") {
        $reason = $_GET["reason"];
    } else {
        $reason = "";
    }
    $statusReq = "На выдачу (".$_GET["status"].")";
    if ($_GET["statusRep"]) {
        $statusRep = $_GET["statusRep"];
    } else {
        $statusRep = $_GET["status"];
    }

    $check = checkRequest($reqNum);
    if ($check["status"] == "yes") {
        echo json_encode($check);
        die();
    }

    try {
        $query = "{call AddReply(?, ?, ?, ?, ?, ?, ?)}";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $reqNum, PDO::PARAM_STR);
        $stmt->bindParam(2, $repNum, PDO::PARAM_STR);
        $stmt->bindParam(3, $repDate, PDO::PARAM_STR);
        $stmt->bindParam(4, $repPerformer, PDO::PARAM_STR);
        $stmt->bindParam(5, $statusReq, PDO::PARAM_STR);            
        $stmt->bindParam(6, $statusRep, PDO::PARAM_STR); 
        $stmt->bindParam(7, $reason, PDO::PARAM_STR); 
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($rows);
    } catch(PDOException $e) {
        die("Error executing stored procedure: ".$e->getMessage());
    }
}
$stmt = null;
$conn = null;       

function checkRequest($reqNum) {
    global $conn;
    $query = "select request.status, reply.numLog from request inner join reply on request.ID = reply.IDr where request.numLog = '$reqNum'";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);    

    if (substr($rows["status"], 0, 17) == "На выдачу") {
        return array("status" => "yes", "text" => "Ответ на запрос $reqNum уже есть. <br>Номер ответа: ".$rows["numLog"]);
    } else {
        return array("status" => "no", "text" => "");
    }
 } 
?>