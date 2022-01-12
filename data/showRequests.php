<?php
include 'config.php';

if (isset($_GET["status"])) {
  $status = $_GET["status"];
}

try {
    $query = "{call showRequests(?)}";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $status, PDO::PARAM_STR);
    $stmt->execute();

    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td class=\"col-md-1\"><a class=\"reqLink\">" . $rows['reqNum'] . "</a></td>";
      if ($rows['type'] == 'OGV') {
        $type = $rows['type']."<br>".$rows['smevNum'];
      } else {
        $type = $rows['type'];
      }
      echo "<td class=\"col-md-1\" style=\"width: 44px;\">" . $type . "</td>";
      echo "<td class=\"col-md-2\">" . $rows['name'] . "</td>";
      echo "<td class=\"col-md-2\">" . $rows['reqObjAddress'] . "</td>";
      echo "<td>" . $rows['svc'] . "</td>";
      if ($status == 'В работе') {
        echo "<td>" . $rows['status'] . "</td>";
        echo "<td>" . $rows['performer'] . "</td>";
        echo "<td>" . $rows['dateDue'] . "</td>";
      }
      echo "</tr>";
    }
} catch(PDOException $e) {
    die("Error executing stored procedure: ".$e->getMessage());
}

$stmt = null;
$conn = null;
?>




