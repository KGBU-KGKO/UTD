<?php
include 'config.php';
include 'getLastNum.php';

$dType = $_GET['decType'];
$dName = $_GET['dFLName'] ?? $_GET['dULName'] ?? $_GET['dOGVName'];
$dDatName = null;//$_GET['dDatFLName'] ?? $_GET['dDatULName'] ?? null;
$dAddress = $_GET['dFLAddress'] ?? $_GET['dULAddress'] ?? null;
$dBD = $_GET['dFLBD'] ?? null;
$dEmail = $_GET['dFLEmail'] ?? $_GET['dULEmail'] ?? null;
$dPhone = $_GET['dFLPhone'] ?? $_GET['dULPhone'] ?? null;
$dINN = $_GET['dULINN'] ?? null;
$dOGRN = $_GET['dULOGRN'] ?? null;
$dDulNum = $_GET['dFLNumDUL'] ?? null;
$dDulDate = $_GET['dFLDateDUL'] ?? null;
$dDulOrg = $_GET['dFLWhoDUL'] ?? null;
$aSwitch = $_GET['agentFLSwitch'] ?? ($dType == 'UL') ? 'on' : 'off';
$aDulNum = $_GET['dFLAgentNumDUL'] ?? $_GET['dULNumDUL'] ?? null;
$aDulDate = $_GET['dFLAgentDateDUL'] ?? $_GET['dULDateDUL'] ?? null;
$aDulOrg = $_GET['dFLAgentWhoDUL'] ?? $_GET['dULWhoDUL'] ?? null;
$aName = $_GET['dFLAgentName'] ?? $_GET['dULAgentName'] ?? null;
$aDatName = null; //$_GET['dDatFLName'] ?? $_GET['dDatULName'] ?? null;
$aAddress = $_GET['dFLAgentAddress'] ?? $_GET['dULAgentAddress'] ?? null;
$aPhone = $_GET['dFLAgentPhone'] ?? $_GET['dULPhone'] ?? null;
$aEmail = $_GET['dFLAgentEmail'] ?? $_GET['dULEmail'] ?? null;
$agentDoc = $_GET['dFLAgentDoc'] ?? $_GET['dULAgentDoc'] ?? null;
$reqNum = getNum('request');
$reqDate = date( "Y-m-d", strtotime($_GET["reqDate"]));
$reqComment = $_GET['reqComment'] ?? null;
$delivery = deliveryConcat();
$attachList = $_GET["attachList"] ?? null;
$path = ($dType != 'OGV') ? 'files/'.explode('/', $reqNum)[1] : null;
$smevNum = $_GET['numSMEV'] ?? null;
$senderNum = $_GET["dOGVSenderNum"] ?? null;
$senderDate = $_GET["dOGVSenderDate"] ?? null;

        try {
            $query = "{call AddRequest(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $dType, PDO::PARAM_STR);
            $stmt->bindParam(2, $dName, PDO::PARAM_STR);
            $stmt->bindParam(3, $dDatName, PDO::PARAM_STR);
            $stmt->bindParam(4, $dAddress, PDO::PARAM_STR);
            $stmt->bindParam(5, $dBD, PDO::PARAM_STR);
            $stmt->bindParam(6, $dEmail, PDO::PARAM_STR);
            $stmt->bindParam(7, $dPhone, PDO::PARAM_STR);
            $stmt->bindParam(8, $dINN, PDO::PARAM_STR);
            $stmt->bindParam(9, $dOGRN, PDO::PARAM_STR);
            $stmt->bindParam(10, $dDulNum, PDO::PARAM_STR);
            $stmt->bindParam(11, $dDulDate, PDO::PARAM_STR);
            $stmt->bindParam(12, $dDulOrg, PDO::PARAM_STR);
            $stmt->bindParam(13, $aSwitch, PDO::PARAM_STR);
            $stmt->bindParam(14, $aDulNum, PDO::PARAM_STR);
            $stmt->bindParam(15, $aDulDate, PDO::PARAM_STR);
            $stmt->bindParam(16, $aDulOrg, PDO::PARAM_STR);
            $stmt->bindParam(17, $aName, PDO::PARAM_STR);
            $stmt->bindParam(18, $aDatName, PDO::PARAM_STR);
            $stmt->bindParam(19, $aAddress, PDO::PARAM_STR);
            $stmt->bindParam(20, $aPhone, PDO::PARAM_STR);
            $stmt->bindParam(21, $aEmail, PDO::PARAM_STR);
            $stmt->bindParam(22, $agentDoc, PDO::PARAM_STR);
            $stmt->bindParam(23, $reqNum, PDO::PARAM_STR);
            $stmt->bindParam(24, $reqDate, PDO::PARAM_STR);
            $stmt->bindParam(25, $reqComment, PDO::PARAM_STR);
            $stmt->bindParam(26, $delivery, PDO::PARAM_STR);
            $stmt->bindParam(27, $attachList, PDO::PARAM_STR);
            $stmt->bindParam(28, $path, PDO::PARAM_STR);
            $stmt->bindParam(29, $smevNum, PDO::PARAM_STR);
            $stmt->bindParam(30, $senderNum, PDO::PARAM_STR);
            $stmt->bindParam(31, $senderDate, PDO::PARAM_STR);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 9) == 'svcSelect') {
                    addService(explode('-', $key)[1], $rows['ID'], substr($value, 3));
                }
            }
            echo json_encode($rows);
        } catch(PDOException $e) {
            die("Error executing stored procedure (add request): ".$e->getMessage());
        }

function addService($num, $IDr, $IDds) {
    global $conn;
    $forHum = (isset($_GET["isHuman-$num"])) ? 1 : 0; 
    $postcode = checkParam("svcInfoObj-address-postcode-$num", 'text');
    $region = checkParam("svcInfoObj-address-region-$num", 'text');
    $regCode = checkParam("svcInfoObj-address-region-code-$num", 'code', 2);
    $district = checkParam("svcInfoObj-address-area-$num", 'text');
    $disCode = checkParam("svcInfoObj-address-area-code-$num", 'code', 5);
    $city = checkParam("svcInfoObj-address-local-$num", 'post');
    $cPrefix = checkParam("svcInfoObj-address-local-$num", 'pre');
    $street = checkParam("svcInfoObj-address-street-$num", 'post');
    $sPrefix = checkParam("svcInfoObj-address-street-$num", 'pre');
    $house = checkParam("svcInfoObj-address-house-$num", 'post');
    $flat = checkParam("svcInfoObj-address-flat-$num", 'post');
    $location = checkParam("svcInfoObj-address-location-$num", 'text');
    $numInventory = checkParam("svcInfoObj-inum-$num", 'text');
    $kn = checkParam("svcInfoObj-knum-$num", 'text');
    $area = checkParam("svcInfoObj-area-$num", 'text');
    $objInfo = checkParam("svcInfoObj-addInfo-$num", 'text');
    $firstName = checkParam("svcInfoObj-firstName-$num", 'text');
    $middleName = checkParam("svcInfoObj-middleName-$num", 'text');
    $lastName = checkParam("svcInfoObj-lastName-$num", 'text');
    $humInfo = checkParam("svcInfoObj-humInfo-$num", 'text');
    $bDate = checkParam("svcInfoObj-bday-$num", 'date');
    $dulNum = checkParam("svcInfoObj-dulNum-$num", 'text');
    $dulDate = checkParam("svcInfoObj-dulDate-$num", 'date');
    $dulOrg = checkParam("svcInfoObj-dulOrg-$num", 'text');

    try {
        $query = "{call AddService(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)}";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $IDr, PDO::PARAM_STR);
        $stmt->bindParam(2, $IDds, PDO::PARAM_STR);
        $stmt->bindParam(3, $forHum, PDO::PARAM_STR);
        $stmt->bindParam(4, $postcode, PDO::PARAM_STR);
        $stmt->bindParam(5, $region, PDO::PARAM_STR);
        $stmt->bindParam(6, $regCode, PDO::PARAM_STR);
        $stmt->bindParam(7, $district, PDO::PARAM_STR);
        $stmt->bindParam(8, $disCode, PDO::PARAM_STR);
        $stmt->bindParam(9, $city, PDO::PARAM_STR);
        $stmt->bindParam(10, $cPrefix, PDO::PARAM_STR);
        $stmt->bindParam(11, $street, PDO::PARAM_STR);
        $stmt->bindParam(12, $sPrefix, PDO::PARAM_STR);
        $stmt->bindParam(13, $house, PDO::PARAM_STR);
        $stmt->bindParam(14, $flat, PDO::PARAM_STR);
        $stmt->bindParam(15, $location, PDO::PARAM_STR);
        $stmt->bindParam(16, $numInventory, PDO::PARAM_STR);
        $stmt->bindParam(17, $kn, PDO::PARAM_STR);
        $stmt->bindParam(18, $area, PDO::PARAM_STR);
        $stmt->bindParam(19, $objInfo, PDO::PARAM_STR);
        $stmt->bindParam(20, $firstName, PDO::PARAM_STR);
        $stmt->bindParam(21, $middleName, PDO::PARAM_STR);
        $stmt->bindParam(22, $lastName, PDO::PARAM_STR);
        $stmt->bindParam(23, $bDate, PDO::PARAM_STR);
        $stmt->bindParam(24, $dulNum, PDO::PARAM_STR);
        $stmt->bindParam(25, $dulDate, PDO::PARAM_STR);
        $stmt->bindParam(26, $dulOrg, PDO::PARAM_STR);
        $stmt->bindParam(27, $humInfo, PDO::PARAM_STR);
        $stmt->execute();
    } catch(PDOException $e) {
        die("Error executing stored procedure (add service): ".$e->getMessage());
    }
}

$stmt = null;
$conn = null;

function deliveryConcat() {
    $deliveryTypes = array('smev', 'post', 'email', 'foot');
    $deliveryText = [];
    foreach ($deliveryTypes as $type) {
        if (isset($_GET[$type])) array_push($deliveryText, $_GET[$type]);
    }
    return implode(', ', $deliveryText);
}

function checkParam($param, $type, $num = 0)
{
    switch ($type) {
        case 'text':
            return isset($_GET["$param"]) ? (($_GET["$param"]) != '') ? $_GET["$param"] : null : null;
            break;
        case 'date':
            return isset($_GET["$param"]) ? (($_GET["$param"]) != '') ? date( "Y-m-d", strtotime($_GET["$param"])) : null : null;
            break;
        case 'pre':
            return isset($_GET["$param"]) ? explode(' ', $_GET["$param"])[0] : null;
            break;                    
        case 'post':
            return isset($_GET["$param"]) ? (($_GET["$param"]) != '') ? explode(' ', $_GET["$param"])[1] : null : null;
            break;       
        case 'code':
            return isset($_GET["$param"]) ? (($_GET["$param"]) != '') ? substr($_GET["$param"], 0, $num) : null : null;
            break;                        
    }
}
?>