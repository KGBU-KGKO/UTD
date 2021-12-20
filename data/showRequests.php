<?php
error_reporting(E_ALL);
include 'config.php';

if (isset($_GET["status"])) {
  $typeReq = htmlspecialchars($_GET["status"]);
}

$stmt = $conn->prepare("exec showNewRequests;");
$stmt->execute();

while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo "<tr>";
  echo "<td class=\"col-md-1\"><a href=\"#\">" . $rows['reqNum'] . "</a></td>";
  echo "<td class=\"col-md-2\">" . $rows['name'] . "</td>";
  echo "<td class=\"col-md-2\">" . $rows['reqObjAddress'] . "</td>";
  echo "<td>" . $rows['svc'] . "</td>";
  echo "</tr>";
}

// # Stored procedure
// try {
//     $query = "{call sp_getToken(@userId=?, @pwd=?)}";
//     $userId = "2465";   
//     $pwd = "460";
//     $stmt = $conn->prepare($query);
//     $stmt->bindParam(1, $userId, PDO::PARAM_STR);
//     $stmt->bindParam(2, $pwd, PDO::PARAM_STR);
//     $stmt->execute();
//     while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
//         var_dump($result);
//         echo"</br>";
//     }
// } catch(PDOException $e) {
//     die("Error executing stored procedure: ".$e->getMessage());
// }
// $stmt = null;

// #
// $conn = null;
//________________________________________________

$stmt = null;
$conn = null;
?>




