<?php
include 'config.php';

class Request
{
    public $reqNum;
    public $type;
    public $name;
    public $objAddress;
    public $svc;
    public $status;
    public $performer;
    public $dateDue;
}

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
      $req = new Request();
      if ($rows['type'] == 'OGV') {
        $type = $rows['type']." <br>".$rows['smevNum'];
      } else {
        $type = $rows['type'];
      }
      $req->reqNum = $rows['reqNum'];
      $req->type = $type;
      $req->name = $rows['name'];
      $req->objAddress = $rows['reqObjAddress'];
      $req->svc = $rows['svc'];
      if ($status == 'В работе') {
        $req->status = $rows['status'];
        $req->performer = $rows['performer'];
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




