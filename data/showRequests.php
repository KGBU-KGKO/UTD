<?php
error_reporting(E_ALL);
include 'config.php';

if (isset($_GET["status"])) {
  $status = htmlspecialchars($_GET["status"]);
}

try {
    $query = "{call showRequests(?)}";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $status, PDO::PARAM_STR);
    $stmt->execute();

    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td class=\"col-md-1\"><a href=\"#\">" . $rows['reqNum'] . "</a></td>";
      echo "<td class=\"col-md-2\">" . $rows['name'] . "</td>";
      echo "<td class=\"col-md-2\">" . $rows['reqObjAddress'] . "</td>";
      echo "<td>" . $rows['svc'] . "</td>";
      if ($status == 'В работе') {
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




