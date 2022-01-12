<?php
function getNum($logType) {
    if (checkFreeNum($logType)[0] == '') {
        return getLastNum($logType);
    } else {
        return getFreeNum($logType, checkFreeNum($logType));
    }
}

function getLastNum($logType) {
    global $conn;
    $query = "SELECT max(numLog) as 'numLog' FROM $logType";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    $num = intval(explode('/', $rows['numLog'])[1]+1);
    $zeros = '';
    for ($i = 0; $i < (4 - strlen(strval($num))); $i++) { 
      $zeros = $zeros.'0';
    }
    switch ($logType) {
        case "request":
            $pre = '02-22/';
            break;
        case "reply":
            $pre = '02-23/';
            break;
    }
    return $pre.$zeros.strval($num);
}

function checkFreeNum($logType) {
    global $conn;  
    if ($logType == 'request') {
        $query = "SELECT ID, numLog, Comment FROM $logType WHERE ID = (SELECT min(ID) FROM $logType where status = 'Удалён-Свободен')";
        $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        return array($rows['ID'],$rows['numLog'],$rows['Comment']);          
    } else {
        return array(null);
    }
}

function getFreeNum($logType, $rowInfo) {
    global $conn;    
    if ($logType == 'request') {    
    $comment = "(Удалён: ".$rowInfo[1].") ".$rowInfo[2];
    $query = "UPDATE $logType SET numLog = '', path='', status = 'Удалён', Comment = '$comment' WHERE ID = ".$rowInfo[0];
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();        
    return $rowInfo[1];    
    } else {
        return 'для ответов не работает';
    }
}
?>