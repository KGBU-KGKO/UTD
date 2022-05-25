<?php 
echo json_encode(getAvatarlist());

function getAvatarlist()
{
  $filesList = [];
  $files = glob("../img/avatar/*.*");
  if(!empty($files)) {
    foreach ($files as $file) {
    	array_push($filesList, (object) [
    'img' => substr($file, 3),
    'name' => substr($file, 14, -4),
  ]);
    }    
  }
  return $filesList;
}
?>