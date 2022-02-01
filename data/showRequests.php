<?php
include 'config.php';
include 'classRequest.php';

$requests = [];

if (isset($_GET["status"])) {
  $status = $_GET["status"];
}

try {
    $query = "{call showRequests(?)}";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $status, PDO::PARAM_STR);
    $stmt->execute();

    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $req = new Request(new Declarant(), new Performer());
      if ($rows['type'] == 'OGV') {
        $type = $rows['type']." <br>".$rows['smevNum'];
      } else {
        $type = $rows['type'];
      }
      $req->logInNum = $rows['reqNum'];
      $req->declarant->type = $type;
      $req->declarant->name = $rows['name'];
      $req->realEstate = $rows['reqObjAddress'];
      $req->svc = $rows['svc'];
      if ($status == 'В работе') {
        $req->status = $rows['status'];
        $req->performer->name = $rows['performer'];
        $req->datePay = $rows['datePayment'];
        $req->dateDue = $rows['dateDue'];
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




