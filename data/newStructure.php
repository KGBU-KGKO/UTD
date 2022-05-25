<?php
	include '../data/config.php';
	
	$query = "select request.ID, request.IDs, request.realEstate, request.objInfo, reply.ID as 'IDrep', reply.status, reply.reason, reply.text
				FROM request LEFT JOIN reply ON request.ID = reply.IDr";
				//WHERE request.ID >= 1000 and request.ID <= 1042";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();					

	while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$aSVC = explode(';', $rows['IDs']);
		$aStatus = explode(';', $rows['status']);
		$aReason = explode(';', $rows['reason']);
		$IDr = $rows['ID'];
		$answerText = $rows['text'];
		$objInfo = $rows['objInfo'];
		$location = $rows['realEstate'];

		if ($rows['realEstate'] == '-' or $rows['realEstate'] == '' or $rows['realEstate'] == ' '){
			$IDoh = 0;
		} else {
			$query = "insert into object (location, objInfo) values ('$location' , '$objInfo')";
			$stmt1 = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt1->execute();
			$query = "select max(ID) as 'ID' from object";
			$stmt1 = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt1->execute();
			$rows2 = $stmt1->fetch(PDO::FETCH_ASSOC);
			$IDoh = $rows2['ID'];			
		}

		$num = 0; 
		$reasonNum = 0;
		foreach ($aStatus as $status) {	
			$svc = $aSVC[$num];
			if ($status == 'Ответ') {
				$query = "insert into service (IDr, IDs, IDoh, forHum, status, answerText) values ('$IDr', '$svc', '$IDoh', '0', '$status', '$answerText')";
			} else {
				$reason = $aReason[$reasonNum];	
				$query = "insert into service (IDr, IDs, IDoh, forHum, status, reason) values ('$IDr', '$svc', '$IDoh', '0', '$status', '$reason')";
				$reasonNum++;
			}
			$stmt1 = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
			$stmt1->execute();
			$num++;
		}
	}		
	
$stmt = null;
$conn = null;
?>