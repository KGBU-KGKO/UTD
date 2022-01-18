<?php 
include 'config.php';

$status = $_GET['status'];
$num = $_GET['num'];

$paid = '';
$issue = '';
$performer = '';
$status = "status = '$status'";

if ($status == 'В работе') {
	$performer = ", performer = '".$_GET['performer']."' ";	
}

if ($status == 'Оплачен') {
	if (!empty(isPaid($num))) {
		echo 'Запрос уже оплачен';
		die();
	} else {
		$paid = "datePayment = GETDATE()";
		$status = "";
	}
}

if ($status == 'Выполнен') {
	if (empty(isPaid($num))) {
		echo 'Запрос не оплачен. Сначала нужно оплатить запрос. ';
		die();
	} else {
	$issue = ", dateIssue = GETDATE()";
	}
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

function isPaid($num) {
	global $conn;
	$query = "select request.status, request.datePayment, declarant.type from request INNER JOIN declarant ON request.IDd = declarant.ID  where numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($rows['type'] == 'OGV') {
		return 'Оплачен';
	} else {
		return $rows['datePayment'];
	}
}

?>