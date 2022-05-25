<?php 
include 'config.php';

$svcID = $_GET['id']; 
$status = $_GET['status']; 
$reason = isset($_GET['reason']) ? (($_GET['reason']) != '') ? "'".$_GET['reason']."'" : 'null' : 'null';
$answerText = isset($_GET["answerText"]) ? (($_GET["answerText"]) != '') ? "'".$_GET["answerText"]."'" : 'null' : 'null';
$pages = isset($_GET["pages"]) ? (($_GET["pages"]) != '') ? $_GET["pages"] : 'null' : 'null'; 
$before2000 = isset($_GET["before2000"]) ? (($_GET["before2000"]) != '') ? $_GET["before2000"] : 'null' : 'null'; 
$limits = isset($_GET["limits"]) ? (($_GET["limits"]) != '') ? $_GET["limits"] : 'null' : 'null'; 

try {
	$query = "update service set status = '$status', reason = $reason, answerText = $answerText, pages = $pages, before2000 = $before2000, limits = $limits where ID = $svcID";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();
	echo "done";
} catch(PDOException $e) {
    die("Error executing query (edit service): ".$e->getMessage());
}

$stmt = null;
$conn = null;
?>