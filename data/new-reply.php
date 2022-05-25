<?php
include 'config.php';
include 'getLastNum.php';

$reqID = $_GET["id"];
if (checkRequest($reqID))
    die('Ответ на это запрос был сформирован ранее');

$repNum = getNum('reply');

try {
    $query = "INSERT INTO reply (numLog, dateReply, IDr) VALUES ('$repNum', GETDATE(), $reqID)";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $query = "UPDATE request SET status = 'На выдачу' WHERE ID = $reqID";
    $stmt = $conn->prepare($query);
    $stmt->execute();    
    echo "done";
} catch(PDOException $e) {
    die("Error executing stored procedure: ".$e->getMessage());
}

$stmt = null;
$conn = null;       

function checkRequest($reqID) {
    global $conn;
    $query = "select numLog from reply where IDr = $reqID";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    return $stmt->fetch();
 } 
?>