<?php 
include 'config.php';

$status = $_GET['status'];
$num = $_GET['num'];

$paid = '';
$issue = '';
$performer = '';

if ($status == 'В работе') {
	$performer = ", performer = '".$_GET['performer']."' ";	
	$status = "status = '".$_GET['status']."'";
}

if ($status == 'Оплачен') {
	$paid = "datePayment = GETDATE()";
	$status = "";
}

if ($status == 'Выполнен') {
	$issue = ", dateIssue = GETDATE()";
	$status = "status = '".$_GET['status']."'";
}

try {
    $query = "update request set $status$paid$issue$performer where numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	echo 'done';
} catch(PDOException $e) {
    die("Error executing stored procedure: ".$e->getMessage());
}

$stmt = null;
$conn = null;
?>