<?php 
include 'config.php';

$newUser = isset($_GET['user']) ? $_GET['user'] : '';
echo $res = isset($_GET['uid']) ? json_encode(getProfilelist($_GET['uid'], $newUser)) : false;

function getProfilelist($uid, $user)
{
  global $conn;
  $icon = $_GET['img'];
  if ($user) {
    $query = "update users set IDu = '' where IDu = '$uid'\nupdate users set IDu = '$uid', iconPath = '$icon' where shortFIO = '$user'\nselect ID, shortFIO as 'name', iconPath as 'img' from users where IDu = '$uid'";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $query = "select ID, shortFIO as 'name', iconPath as 'img' from users where IDu = '$uid'";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();    
    $result = $stmt->fetch(PDO::FETCH_OBJ);
  } else {
    $query = "select ID, shortFIO as 'name', iconPath as 'img' from users where IDu = '$uid'";
    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      $id = $result->ID;
      $query = "update users set iconPath = '$icon' where ID = $id";
      $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
      $stmt->execute();    
    }
  }
  return $result;
}

$stmt = null;
$conn = null;
?>