<?php 
error_reporting(E_ALL);
include '../data/config.php';
$status = 'В работе';
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 12px;">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Реестр новых запросов</title>
	<link rel="stylesheet" type="text/css" href="../lib/bootstrap/bootstrap.min.css">
</head>
<body>
  <table class="table table-bordered">
      <thead>
    <tr>
      <th scope="col">№ запроса</th>
      <th scope="col">Заявитель</th>
      <th scope="col">Объект недвижимости</th>
      <th scope="col">Вид услуги</th>
      <th scope="col">Комментарий</th>
      <th scope="col">Для заметок</th>
    </tr>
  </thead>
  <tbody>
<?php 
try {
    $query = "{call showRequests(?)}";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $status, PDO::PARAM_STR);
    $stmt->execute();

    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
      echo "<td class=\"col-md-1\"><b>" . $rows['reqNum'] . "</b></td>";
      echo "<td class=\"col-md-2\">" . $rows['name'] . "</td>";
      echo "<td class=\"col-md-2\">" . $rows['reqObjAddress'] . "</td>";
      echo "<td>" . $rows['svc'] . "</td>";
      echo "<td>" . $rows['Comment'] . "</td>";
      echo "<td class=\"col-md-3\"></td>";
      echo "</tr>";
    }
} catch(PDOException $e) {
    die("Error executing stored procedure: ".$e->getMessage());
}
?>
  </tbody>
  </table>
</body>
</html>
<?php 
$stmt = null;
$conn = null;
?>