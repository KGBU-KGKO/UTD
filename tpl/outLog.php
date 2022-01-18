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
	
		<h3 class="text-center">02-23 Журнал исходящих</h3>

		<table class="table table-bordered border-dark">
	  		<tbody class="text-center align-middle">
			    <tr class="text-center align-middle">
			      <th>Регистрационный номер</th> 
			      <th>Дата регистрации</th>
			      <th>Номер входящего запроса</th>
				  <th>Заявитель</th>
			      <th>Номер СМЭВ</th> 
			      <th>Услуга</th>
			      <th>Исполнитель</th>
			    </tr>
			    <?php include '../data/getDataLogIn.php'; ?>
			</tbody>
		</table>

</body>
</html>