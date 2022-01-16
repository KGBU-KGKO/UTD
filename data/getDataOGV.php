<?php
	include '../data/config.php';
	if (isset($_GET['numLog'])) {
		$query = "select request.numLog, request.dateReq, request.Comment, declarant.name, request.realEstate, request.IDs, request.senderNum, request.senderDate, request.smevNum, request.delivery from request INNER JOIN declarant ON request.IDd = declarant.ID WHERE numLog = '".$_GET['numLog']."'";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    	$stmt->execute();
    	$rowsRequest = $stmt->fetch(PDO::FETCH_ASSOC);
    	$svc = $rowsRequest['IDs'];

    	$query = "DECLARE @svcName nvarchar(300), @svcID int, @svcConcat nvarchar(2000) = '', @num int = 0 ".
    	"DECLARE cs CURSOR FOR ".
    	"select value FROM STRING_SPLIT('$svc', ';') WHERE RTRIM(value) <> '' ".
    	"OPEN cs FETCH NEXT FROM cs INTO @svcID ".
    	"WHILE @@FETCH_STATUS = 0 BEGIN ".
    	" select @num = @num + 1".
    	" select @svcName = name FROM service WHERE ID = @svcID".
    	" select @svcConcat = CONCAT(@svcConcat, '<tr><th class=\"align-center text-center\">', @num,'</th><td>', @svcName, '</td><td></td></tr>') ". 
    	"FETCH NEXT FROM cs INTO @svcID END ".
    	"CLOSE cs DEALLOCATE cs SELECT @svcConcat as svcConcat";
    	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    	$stmt->execute();
    	$rowsSvc = $stmt->fetch(PDO::FETCH_ASSOC);
	}
?>