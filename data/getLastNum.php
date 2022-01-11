<?php
function getLastNum($logType) {
    global $conn;
    $query = "SELECT numLog FROM $logType WHERE ID = (SELECT max(ID) FROM $logType)";
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
?>