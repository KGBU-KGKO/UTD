<?php
include 'config.php';
$info = $_GET["info"];

switch ($info) {
    case "cards":
        try {
            $conn->setAttribute(PDO::SQLSRV_ATTR_FORMAT_DECIMALS, true);
            $conn->setAttribute(PDO::SQLSRV_ATTR_DECIMAL_PLACES, 2);
            $query = "{call InformationBoard1()}";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $info = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        break;
    case "first":
        $from = $_GET["from"];
        $to = $_GET["to"];
        $labels = [];
        $data = [];
        $FL = [];
        $UL = [];
        $OGV = [];     
        try {
            $query = "{call InformationBoardTypes(?, ?)}";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $from, PDO::PARAM_STR);
            $stmt->bindParam(2, $to, PDO::PARAM_STR);
            $stmt->execute();
            while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
              array_push($labels, date("d.m.Y", strtotime($rows['Date'])));
              array_push($FL, intval($rows['FL']));
              array_push($UL, intval($rows['UL']));
              array_push($OGV, intval($rows['OGV']));
            }
            $info = (object) array(
              'labels' => $labels, 
              'data' => (object) array(
                  'FL' => $FL,
                  'UL' => $UL,
                  'OGV' => $OGV
              )
            );
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        break;    
    case "second":
        $from = $_GET["from"];
        $to = $_GET["to"];
        $labels = [];
        $data = [];
        try {
            $query = "{call ReportOfTypes(?, ?)}";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $from, PDO::PARAM_STR);
            $stmt->bindParam(2, $to, PDO::PARAM_STR);
            $stmt->execute();
            while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
              array_push($labels, $rows['sName']);
              array_push($data, intval($rows['sCount']));
            }
            array_push($data, 0);
            $info = (object) array(
              'labels' => $labels, 
              'data' => $data
            );
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        break;
    case "third":
        $from = $_GET["from"];
        $to = $_GET["to"];
        $labels = [];
        $data = [];
        try {
            $query = "SELECT performer, count(performer) as count FROM request
                        WHERE DateClose >= '$from' and DateClose <= '$to' and performer <> ''
                        GROUP BY performer";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
              array_push($labels, $rows['performer']);
              array_push($data, intval($rows['count']));
            }
            array_push($data, 0);
            $info = (object) array(
              'labels' => $labels, 
              'data' => $data
            );
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        break;
}

echo json_encode($info);

$stmt = null;
$conn = null;
?>




