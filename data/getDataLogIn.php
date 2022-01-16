<?php
	include '../data/config.php';

	if (isset($_GET["logDateStart"])) {
		$logDateStart = $_GET["logDateStart"];	
		try {
		    $query = "{call ShowLogIn(?)}";
		    $stmt = $conn->prepare($query);
		    $stmt->bindParam(1, $logDateStart, PDO::PARAM_STR);
		    $stmt->execute();

		    while($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
		    	echo "<tr style=\"page-break-after: auto; page-break-before: auto; page-break-inside: avoid;\">";
		    	echo "<td>" . $rows['numLog'] . "</td>";
		    	echo "<td>" . $rows['dateReq'] . "</td>";
		    	echo "<td>" . $rows['senderNum'] . "</td>";
		    	echo "<td>" . $rows['senderDate'] . "</td>";
		    	echo "<td>" . $rows['smevNum'] . "</td>";
		    	echo "<td>" . $rows['name'] . "</td>";
		    	echo "<td>" . $rows['realEstate'] . "</td>";
		    	echo "<td>" . $rows['svc'] . "</td>";
		    	echo "<td nowrap>" . $rows['performer'] . "</td>";

		    }
		} catch(PDOException $e) {
		    die("Error executing stored procedure: ".$e->getMessage());
		}

		$stmt = null;
		$conn = null;
	}
?>