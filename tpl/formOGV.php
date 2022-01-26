<?php
	include '../data/getDataOGV.php';
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 12px;">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap/bootstrap.min.css">

	<title>Запрос №<?=$rowsRequest['numLog'];?></title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-8"></div>
			<div class="text-end text-wrap col-4" style="font-size: 8px;">
				В Краевое государственное бюджетное учреждение<br>«Камчатская государственная кадастровая оценка»<br>Пограничная ул., д. 19, каб.208,<br>г. Петропавловск-Камчатский, Камчатский край, 683032
			</div>
		</div>
	<br>
	<p class="text-center my-0 py-0">ЗАПРОС №<?=$rowsRequest['numLog'];?></p>
	<p class="text-center">о предоставлении копий учетно-технической документации и (или)<br>содержащихся в ней сведений</p>
	<table class="table table-bordered border-dark">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Сведения о заявителе - органе государственной власти</th>
    	 	</tr>
		    <tr>
		      <td scope="row">Наименование учреждения</td>
		      <td><?=$rowsRequest['name'];?></td>
		    </tr>
		    <tr>
		      <th scope="row" class="align-middle">Адрес запрашиваемого объекта</th>
		      <td><?=$rowsRequest['realEstate'];?></td>
		    </tr>
		</tbody>
	</table>
	<br style="page-break-after: always;">
	<p> Прошу предоставить копию(и) учетно-технической документации:</p>
	<table class="table table-bordered border-dark">	
  		<tbody>
  			<tr>
  				<th scope="row" class="text-center">№</th>
      			<th scope="row" class="text-center">Вид документа, копия которого предоставляется либо содержащего сведения</th>
      			<th scope="row" class="text-center">Размер платы</th>
    	 	</tr>
    	 	<?=$rowsSvc['svcConcat'];?>
		</tbody>
	</table>
	<br>
	<table class="table table-bordered border-dark">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Способ получения копий учетно-технической документации и (или) содержащихся в ней сведений, уведомлений</th>
    	 	</tr>
		    <tr>
		      <td scope="row" colspan="2"><?=$rowsRequest['delivery'];?></td>
		    </tr>
		</tbody>
	</table>
	<br>
	<table class="table table-bordered border-dark" style="page-break-after: always;">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Комментарий</th>
    	 	</tr>
		    <tr>
		      <td scope="row" colspan="2">
		      	<?php 
			      	if (!$rowsRequest['Comment']) {
			      		echo "Комментарий отсутствует";
			      	} else {
			      		echo $rowsRequest['Comment'];
			      	}
		      	?>
		      	
		      </td>
		    </tr>
		</tbody>
	</table>
</div>
</body>
</html>