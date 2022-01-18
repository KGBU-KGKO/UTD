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
		    
		    if ($logType = 'in') {
		    	$title = '02-22 Журнал входящих'
		    } else {
		    	$title = '02-23 Журнал исходящих'
		    }
		    switch ($logType) {
    				case "in":
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
    						"
    					break;
    				case "out":
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
    						"
    					break;
    			}	


		    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
		    	switch ($logType) {
    				case "in":
    						$tpl = $tpl + "

    						"
    					break;
    				case "out":
    					break;
    			}
		    	$tpl = "<tr style=\"page-break-after: auto; page-break-before: auto; page-break-inside: avoid;\">" .
		    	echo "<td>" . $rows['numLog'] . "</td>";
		    	echo "<td>" . $rows['dateReq'] . "</td>";
		    	echo "<td>" . $rows['senderNum'] . "</td>";
		    	echo "<td>" . $rows['senderDate'] . "</td>";
		    	echo "<td>" . $rows['smevNum'] . "</td>";
		    	echo "<td>" . $rows['name'] . "</td>";
		    	echo "<td>" . $rows['realEstate'] . "</td>";
		    	echo "<td>" . $rows['svc'] . "</td>";
		    	echo "<td nowrap>" . $rows['performer'] . "</td>";
		    	echo "<td></td>";

		    }
		} catch(PDOException $e) {
		    die("Error executing stored procedure: ".$e->getMessage());
		}

		$stmt = null;
		$conn = null;
	}
?>