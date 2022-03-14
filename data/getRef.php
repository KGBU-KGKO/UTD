<?php
include 'config.php';
//declarant, agent, global

if (isset($_GET['ref'])) {
    $ref = $_GET["ref"];
    if ($ref == "declarant") {
        if (isset($_GET['decType'])) {
            $decType = $_GET["decType"];
            $query = "select * from declarant where type = '$decType'";
        }        
    } 


    if ($ref == "agent") $query = "select * from agent";
    if ($ref == "global") $query = "select request.numLog, request.dateReq, declarant.name, request.realEstate, request.status, request.performer, declarant.type
                                    from request  
                                    inner join declarant on request.IDd = declarant.ID
                                    where request.status <> 'Удалён' and request.status <> 'Удалён-Свободен'";

    $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($result);
} 


$stmt = null;
$conn = null;
?>




