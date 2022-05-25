<?php 
include 'config.php';

echo $res = isset($_GET['uid']) ? json_encode(getProfilelist($_GET['uid'])) : false;

function getProfilelist($uid)
{
  global $conn;
  $query = "select ID, shortFIO as 'name', iconPath as 'img' from users where IDu = $uid";
  $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_OBJ);

  if ($result) {
    $id = $result->ID;
    $icon = $_GET['img'];
    $query = "update users set iconPath = '$icon' where ID = $id";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();    
  }
  $stmt = null;
  $conn = null;
  return $result;
}

?>