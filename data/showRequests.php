<?php
include 'config.php';
include 'classRequest.php';

$requests = [];
$status = (isset($_GET["status"])) ? $_GET["status"] : die('Не указан статус запроса'); 

try {
    $query = "{call showRequests(?)}";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $status, PDO::PARAM_STR);
    $stmt->execute();

    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $req = new Request();
      $type = ($rows['dType'] == 'OGV') ? $rows['dType']." <br>".$rows['smevNum'] : $rows['dType'];
      $req->num = $rows['reqNum'];
      $req->declarant->type = $type;
      $req->declarant->name = $rows['dName'];
      $req->realEstate = $rows['reqObjHum'];
      $req->svc = $rows['svc'];
      if ($status == 'В работе') {
        $req->status = $rows['status'];
        $req->performer->name = $rows['performer'];
        $req->datePay = $rows['datePayment'];
        $req->dateDue = $rows['dateDue'];
        $req->date = $rows['reqDate'];
      }
      array_push($requests, $req);
    }
} catch(PDOException $e) {
    die("Error executing stored procedure: ".$e->getMessage());
}

echo json_encode($requests);

$stmt = null;
$conn = null;
?>




