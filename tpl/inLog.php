<!DOCTYPE html>
<html lang="en" style="font-size: 12px;">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

	<title>02-22 Журнал входящих</title>
</head>
<body>
	
		<h3 class="text-center">02-22 Журнал входящих</h3>

		<table class="table table-bordered border-dark">
	  		<tbody class="text-center align-middle">
			    <tr class="text-center align-middle">
			      <th>Регистрационный номер</th>
			      <th>Дата регистрации</th>
			      <th>Исходящий номер отправителя</th>
			      <th>Дата исходящего отправителя</th>
			      <th>Номер СМЭВ</th>
			      <th>Заявитель</th>
			      <th>Содержание запроса</th>
			      <th>Исполнитель</th>
			      <th>Количество листов</th>
			    </tr>
			    <?php include '../data/getDataLogIn.php'; ?>
			</tbody>
		</table>

</body>
</html>