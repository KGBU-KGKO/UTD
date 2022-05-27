<?php 
include 'config.php';

$status = $_GET['status'];
$num = $_GET['num'];


$paid = '';
$issue = '';
$performer = '';
$statusRow = "status = '$status'";

if ($status == 'В работе') { 
	$check = checkInWork($num);
	if ($check == 'Новый') {
		$performer = ", performer = '".$_GET['performer']."' ";		
	} else {
		echo "Запрос уже в работе у $check";
		die();
	}
}

if ($status == 'Оплачен') {
	if (!empty(isPaid($num))) {
		echo "Запрос уже оплачен";
		die();
	} else {
		$paid = "datePayment = GETDATE()";
		$statusRow = "";
	}
}

if ($status == 'Выполнен') {
	if (empty(isPaid($num)) || empty(forDelivery($num))) {
		echo 'Запрос не оплачен или не на выдаче или уже выдан. <br>Сначала нужно оплатить запрос и сформировать ответ/отказ ';
		die();
	} else {
	$issue = ", dateIssue = GETDATE()";
	}
}

try {
    $query = "update request set $statusRow$paid$issue$performer where numLog = '$num'";
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
	if ($rows['type'] == 'OGV' || $rows['status'] == 'На выдачу (Отказ)') {
		return 'Оплачен';
	} else {
		return $rows['datePayment'];
	}
}

function forDelivery($num) {
	global $conn;
	$query = "select request.status, declarant.type from request INNER JOIN declarant ON request.IDd = declarant.ID  where numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	if (substr($rows["status"], 0, 17) == "На выдачу") {
		return "На выдачу";
	} else {
		return null;
	}
}

function checkInWork($num) {
	global $conn;
	$query = "select request.status, request.performer from request INNER JOIN declarant ON request.IDd = declarant.ID  where numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($rows['status'] == 'Новый') {
		return 'Новый';
	} else {
		return $rows['performer'];
	}
}

?>