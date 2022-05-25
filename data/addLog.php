<?php 
include 'config.php';

$uid = $_GET['uid'];
$event = $_GET['event'];
$request = $_GET['request'];

$query = "insert into log ([time],[IDu],[event],[IDr]) values (GETDATE(), '$uid', '$event', (select top 1 id from request where numLog = '$request'))";
$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();

$stmt = null;
$conn = null;
?>