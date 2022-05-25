<?php 
include 'config.php';

$svcID = $_GET['svcID']; 
$query = "select numLog from request inner join service on request.ID = service.IDr where service.ID = $svcID";
$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ);
echo json_encode($result);

$stmt = null;
$conn = null;
?>