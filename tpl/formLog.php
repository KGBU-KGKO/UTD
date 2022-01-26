<?php
	include '../data/getDataLog.php';
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 12px;">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap/bootstrap.min.css">

	<title><?=$title?></title>
</head>
<body>
	
		<h3 class="text-center"><?=$title?></h3>

		<table class="table table-bordered border-dark">
	  		<tbody class="text-center align-middle">
			   <?=$tpl?>
			</tbody>
		</table>

</body>
</html>