<?php
error_reporting(E_ALL);
include 'config.php';
include 'getLastNum.php';

if (isset($_GET['decType'])) {

    $svc = '';
    $i = 1;
    do {
        if (isset($_GET["svc-$i"])) {
            $svc = $svc.';'.$i;
        }
        $i++;
    } while ($i <= 11);
    $svc = substr($svc, 1);    

    $reqNum = getNum('request');
    $reqDate = date( "Y-m-d", strtotime($_GET["reqDate"]));
    $reqObjAddress = $_GET["reqObjAddress"];
    $reqComment = $_GET["reqComment"];
    $reqObjInfo = $_GET["reqObjInfo"];
    $delivery = deliveryConcat();
    $attachList = $_GET["attachList"];
    $path = 'files/'.explode('/', $reqNum)[1];

    if ($_GET['decType'] == 'FL') {
        if (isset($_GET["agentFLSwitch"])) {
            $agentFLSwitch = $_GET["agentFLSwitch"];
            $NumDUL = $_GET["dFLAgentNumDUL"];
            $DateDUL = $_GET["dFLAgentDateDUL"];
            $WhoDUL = $_GET["dFLAgentWhoDUL"];    
            $Phone = $_GET["dFLAgentPhone"];
            $Email = $_GET["dFLAgentEmail"];       
            $AgentName = $_GET["dFLAgentName"];
            $AgentAddress = $_GET["dFLAgentAddress"];
            $AgentDoc = $_GET["dFLAgentDoc"];
        } else {
            $agentFLSwitch = 'off';
            $NumDUL = $_GET["dFLNumDUL"];
            $DateDUL = $_GET["dFLDateDUL"];
            $WhoDUL = $_GET["dFLWhoDUL"];    
            $Phone = $_GET["dFLPhone"];
            $Email = $_GET["dFLEmail"];   
            $AgentName = '';
            $AgentAddress = '';
            $AgentDoc = '';            
        }
        $Name = $_GET["dFLName"];
        $BDay = $_GET["dFLBD"];
        $Address = $_GET["dFLAddress"];

        //отправляем запрос, получаем 0 или 1
        try {
            $query = "{call AddRequestFL(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
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
            $stmt->bindParam(11, $AgentAddress, PDO::PARAM_STR);
            $stmt->bindParam(12, $AgentDoc, PDO::PARAM_STR);
            $stmt->bindParam(13, $reqNum, PDO::PARAM_STR);
            $stmt->bindParam(14, $reqDate, PDO::PARAM_STR);
            $stmt->bindParam(15, $reqObjAddress, PDO::PARAM_STR);
            $stmt->bindParam(16, $reqComment, PDO::PARAM_STR);
            $stmt->bindParam(17, $svc, PDO::PARAM_STR);
            $stmt->bindParam(18, $delivery, PDO::PARAM_STR);
            $stmt->bindParam(19, $attachList, PDO::PARAM_STR);
            $stmt->bindParam(20, $path, PDO::PARAM_STR);
            $stmt->bindParam(21, $reqObjInfo, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($rows);
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
    }

    if ($_GET['decType'] == 'UL') {

            $dULName = $_GET["dULName"];
            $dINN = $_GET["dULINN"];
            $OGRN = $_GET["dULOGRN"];
            $dULPhone = $_GET["dULPhone"];
            $dULEmail = $_GET["dULEmail"];
            $dULAddress = $_GET["dULAddress"];
            $dULNumDUL = $_GET["dULNumDUL"];
            $dULDateDUL = $_GET["dULDateDUL"];
            $dULWhoDUL = $_GET["dULWhoDUL"];
            $dULAgentName = $_GET["dULAgentName"];
            $dULAgentAddress = $_GET["dULAgentAddress"];
            $dULAgentPhone = $_GET["dULAgentPhone"];
            $dULAgentDoc = $_GET["dULAgentDoc"];

            //отправляем запрос, получаем 0 или 1
            try {
                $query = "{call AddRequestUL(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}"; 
                $stmt = $conn->prepare($query);
                $stmt->bindParam(1, $dULName, PDO::PARAM_STR);
                $stmt->bindParam(2, $dINN, PDO::PARAM_STR);
                $stmt->bindParam(3, $OGRN, PDO::PARAM_STR);
                $stmt->bindParam(4, $dULPhone, PDO::PARAM_STR);
                $stmt->bindParam(5, $dULEmail, PDO::PARAM_STR);
                $stmt->bindParam(6, $dULAddress, PDO::PARAM_STR);
                $stmt->bindParam(7, $dULNumDUL, PDO::PARAM_STR);
                $stmt->bindParam(8, $dULDateDUL, PDO::PARAM_STR);
                $stmt->bindParam(9, $dULWhoDUL, PDO::PARAM_STR);
                $stmt->bindParam(10, $dULAgentName, PDO::PARAM_STR);
                $stmt->bindParam(11, $dULAgentAddress, PDO::PARAM_STR);
                $stmt->bindParam(12, $dULAgentPhone, PDO::PARAM_STR);
                $stmt->bindParam(13, $dULAgentDoc, PDO::PARAM_STR);
                $stmt->bindParam(14, $reqNum, PDO::PARAM_STR);
                $stmt->bindParam(15, $reqDate, PDO::PARAM_STR);
                $stmt->bindParam(16, $reqObjAddress, PDO::PARAM_STR);
                $stmt->bindParam(17, $reqComment, PDO::PARAM_STR);
                $stmt->bindParam(18, $svc, PDO::PARAM_STR);
                $stmt->bindParam(19, $delivery, PDO::PARAM_STR);
                $stmt->bindParam(20, $attachList, PDO::PARAM_STR);
                $stmt->bindParam(21, $path, PDO::PARAM_STR);
                $stmt->bindParam(22, $reqObjInfo, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($rows);
            } catch(PDOException $e) {
                die("Error executing stored procedure: ".$e->getMessage());
            }    

    }

    if ($_GET['decType'] == 'OGV') {
            $dOGVName = $_GET["dOGVName"];
            $dOGVSenderNum = $_GET["dOGVSenderNum"];
            $dOGVSenderDate = $_GET["dOGVSenderDate"];
            $numSMEV = $_GET["numSMEV"];

            //отправляем запрос, получаем 0 или 1
            try {
                $query = "{call AddRequestOGV(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}"; 
                $stmt = $conn->prepare($query);
                $stmt->bindParam(1, $dOGVName, PDO::PARAM_STR);
                $stmt->bindParam(2, $reqNum, PDO::PARAM_STR);
                $stmt->bindParam(3, $reqDate, PDO::PARAM_STR);
                $stmt->bindParam(4, $numSMEV, PDO::PARAM_STR);
                $stmt->bindParam(5, $dOGVSenderNum, PDO::PARAM_STR);
                $stmt->bindParam(6, $dOGVSenderDate, PDO::PARAM_STR);
                $stmt->bindParam(7, $reqObjAddress, PDO::PARAM_STR);
                $stmt->bindParam(8, $reqComment, PDO::PARAM_STR);
                $stmt->bindParam(9, $svc, PDO::PARAM_STR);
                $stmt->bindParam(10, $delivery, PDO::PARAM_STR);
                $stmt->bindParam(11, $attachList, PDO::PARAM_STR);
                $stmt->bindParam(12, $path, PDO::PARAM_STR);
                $stmt->bindParam(13, $reqObjInfo, PDO::PARAM_STR);
                $stmt->execute();
                $rows = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($rows);
            } catch(PDOException $e) {
                die("Error executing stored procedure: ".$e->getMessage());
            }         
    }

}

$stmt = null;
$conn = null;

function deliveryConcat() {
    global $delivery;
    $deliveryTypes = array('smev', 'post', 'email', 'foot');
    $deliveryText = [];
    foreach ($deliveryTypes as $type) {
        if (isset($_GET[$type])) array_push($deliveryText, $_GET[$type]);
    }
    return implode(', ', $deliveryText);
}
?>




