<?php
	include '../data/config.php';

	if (isset($_GET["logDateStart"])) {
		$logDateStart = $_GET["logDateStart"];
		$logNumStart = $_GET["logNumStart"];
		$logType = $_GET["logType"];

		try {
		    $query = "{call ShowLog(?, ?, ?)}";
		    $stmt = $conn->prepare($query);
		    $stmt->bindParam(1, $logDateStart, PDO::PARAM_STR);
		    $stmt->bindParam(2, $logNumStart, PDO::PARAM_STR);
		    $stmt->bindParam(3, $logType, PDO::PARAM_STR);
		    $stmt->execute();
		   
		    switch ($logType) {
    				case "in":
    						$title = '02-22 Журнал входящих';
    						$tpl = "
    							<tr class=\"text-center align-middle\">
	    							<th>Регистрационный номер</th>
								    <th>Дата регистрации</th>
								    <th>Исходящий номер отправителя</th>
								    <th>Дата исходящего отправителя</th>
								    <th>Номер СМЭВ</th>
								    <th>Заявитель</th>
								    <th>Содержание запроса</th>
								    <th>Услуга</th>
								    <th>Исполнитель</th>
								    <th>Количество листов</th>
							    </tr>
							    <tr style=\"page-break-after: auto; page-break-before: auto; page-break-inside: avoid;\">
    						";
    					break;
    				case "out":
    						$title = '02-23 Журнал исходящих';
    						$tpl = "
    							<tr class=\"text-center align-middle\">
							      <th>Регистрационный номер</th> 
							      <th>Дата регистрации</th>
							      <th>Номер входящего запроса</th>
								  <th>Заявитель</th>
							      <th>Номер СМЭВ</th> 
							      <th>Услуга</th>
							      <th>Исполнитель</th>
							    </tr>
							    <tr style=\"page-break-after: auto; page-break-before: auto; page-break-inside: avoid;\">
    						";
    					break;
    			}	

		    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
		    	switch ($logType) {
    				case "in":
    						$tpl = $tpl . "
    							<td>" . $rows['numLogReq'] . "</td>
    							<td>" .$rows['dateReq'] . "</td>
    							<td>" .$rows['senderNum'] . "</td>
    							<td>" .$rows['senderDate'] . "</td>
    							<td>" .$rows['smevNum'] . "</td>
    							<td>" .$rows['name'] . "</td>
    							<td>" .$rows['reqObjHum'] . "</td>
    							<td>" .$rows['svc'] . "</td>
    							<td nowrap>" .$rows['performer'] . "</td>
    							<td></td>
    						";
    					break;
    				case "out":
    						$tpl = $tpl . "
    							<td>" .$rows['numLogRep'] . "</td>
    							<td>" .$rows['dateReply'] . "</td>
    							<td>" .$rows['numLogReq'] . "</td>
    							<td>" .$rows['name'] . "</td>
    							<td>" .$rows['smevNum'] . "</td>    							
    							<td>" .$rows['svc'] . "</td>
    							<td nowrap>" .$rows['performer'] . "</td>
    						";
    					break;
    			}
    			$tpl = $tpl . "</tr>";
		    }
		} catch(PDOException $e) {
		    die("Error executing stored procedure: ".$e->getMessage());
		}

		$stmt = null;
		$conn = null;
	}
?>