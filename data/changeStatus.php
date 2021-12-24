<?php 
error_reporting(E_ALL);
include 'config.php';

$status = $_GET['status'];
$num = $_GET['num'];

if ($status == 'В работе') {
	$performer = ", performer = '".$_GET['performer']."' ";	
}

if ($status == 'Выполнен') {
	$outinfo = ", logOutNum = '".$_GET['reqOutNum']."', logOutDate = '".$_GET['reqOutDate']."'";
}

$query = "update request set status = '$status'$performer$outinfo where numLog = '$num'";

$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
$stmt->execute();

$stmt = null;
$conn = null;
?>