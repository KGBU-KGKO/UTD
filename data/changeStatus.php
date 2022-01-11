<?php 
include 'config.php';

$status = $_GET['status'];
$num = $_GET['num'];

$paid = '';
$issue = '';
$performer = '';
$outinfo = '';

if ($status == 'В работе') {
	$performer = ", performer = '".$_GET['performer']."' ";	
}

if ($status == 'Выполнен') {
	$outinfo = ", logOutNum = '".$_GET['reqOutNum']."', logOutDate = '".$_GET['reqOutDate']."'";
}

if ($status == 'Оплачен') {
	$paid = ", datePayment = GETDATE()";
}

if ($status == 'Ожидает выдачи') {
	$issue = ", dateIssue = GETDATE()";
}

try {
    $query = "update request set status = '$status'$paid$issue$performer$outinfo where numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	echo 'done';
} catch(PDOException $e) {
    die("Error executing stored procedure: ".$e->getMessage());
}

$stmt = null;
$conn = null;
?>