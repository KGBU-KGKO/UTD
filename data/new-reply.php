<?php
include 'config.php';
include 'getLastNum.php';

if (isset($_GET['getNumLog'])) {
    echo getLastNum($_GET['getNumLog']);
} 

if (isset($_GET['status'])) {
$reqNum = $_GET["reqNum"];
$repNum = $_GET["repNum"];
$repDate = $_GET["repDate"];
$repPerformer = $_GET["repPerformer"];
$Status = $_GET["status"];

        try {
            $query = "{call AddReply(?, ?, ?, ?, ?)}";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $reqNum, PDO::PARAM_STR);
            $stmt->bindParam(2, $repNum, PDO::PARAM_STR);
            $stmt->bindParam(3, $repDate, PDO::PARAM_STR);
            $stmt->bindParam(4, $repPerformer, PDO::PARAM_STR);
            $stmt->bindParam(5, $Status, PDO::PARAM_STR);            
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($rows);
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
}
$stmt = null;
$conn = null;        
?>