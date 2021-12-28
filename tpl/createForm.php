<?php
	include '../data/config.php';
	if (isset($_GET['numLog'])) {
		//$numLog =$_GET['numLog']; 
		$query = "select request.numLog, request.dateReq, request.Comment, declarant.name, request.dFLAgentDoc, request.realEstate, request.IDs,  request.delivery, request.attachList, ".
		"declarant.dulNum, declarant.dulDate, declarant.dulOrg, declarant.email, declarant.tel, declarant.address, declarant.dateBirth, ".
		"agent.FIO as aFIO, agent.tel as aTel, agent.dulNum as aDulNum, agent.dulDate as aDulDate, agent.dulOrg as aDulOrg, agent.address as aAddress ".
		"from request INNER JOIN declarant ON request.IDd = declarant.ID ".
		"LEFT JOIN agent ON request.IDa = agent.ID ".
		"WHERE numLog = '".$_GET['numLog']."'";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    	$stmt->execute();
    	$rowsRequest = $stmt->fetch(PDO::FETCH_ASSOC);
    	$svc = $rowsRequest['IDs'];

    	if (!is_null($rowsRequest['aFIO'])) {
    		$FIO = $rowsRequest['aFIO'];
    		$address = $rowsRequest['aAddress'];
	    	$dulNum = $rowsRequest['aDulNum'];
	    	$dulDate = date( "d.m.Y", strtotime($rowsRequest['aDulDate']));
	    	$dulOrg = $rowsRequest['aDulOrg'];
    	}
    	else {
    		$FIO = $rowsRequest['name'];
    		$address = $rowsRequest['address'];
    		$dulNum = $rowsRequest['dulNum'];
    		$dulDate = date( "d.m.Y", strtotime($rowsRequest['dulDate']));
	    	$dulOrg = $rowsRequest['dulOrg'];
    	}

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

    	$sFIO = explode(' ', $FIO);
    	$sFIO = substr($sFIO[1],0,2) . '. ' . substr($sFIO[2],0,2) . '.' . ' ' . $sFIO[0];

	}
?>