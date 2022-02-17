<?php
include 'config.php';
$info = $_GET["info"];

switch ($info) {
    case "one":
        try {
            $query = "{call InformationBoard1()}";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $info = (object) array(
              'reqAll' => $rows['reqRecieved'], 
              'reqToday' => $rows['reqRecievedToday'], 
              'inWork' => $rows['reqInWork'], 
              'exp' => $rows['percentOfExp'], 
              'time' => $rows['timeAverage']
            );
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        break;
    case "two":
        try {
            $query = "{call InformationBoard1()}";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);

            $info = (object) array(
              'reqAll' => $rows['reqRecieved'], 
              'reqToday' => $rows['reqRecievedToday'], 
              'inWork' => $rows['reqInWork'], 
              'exp' => $rows['percentOfExp'], 
              'time' => $rows['timeAverage']
            );
        } catch(PDOException $e) {
            die("Error executing stored procedure: ".$e->getMessage());
        }
        break;    
    case "three":
        $firstDate = "2022-01-01";
        $secondDate = "2022-02-28";
        $labels = [];
        $data = [];
        try {
            $query = "SELECT performer, count(performer) as count FROM request
WHERE DateClose >= '$firstDate' and DateClose <= '$secondDate' and performer <> ''
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




