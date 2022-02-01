<?php
	include '../data/getDataUL.php';
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
	<p class="text-center">о предоставлении копий учетно-технической документации и (или) содержащихся в ней сведений</p>
	<table class="table table-bordered border-dark">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Сведения о заявителе - юридическом лице</th>
    	 	</tr>
		    <tr>
		      <td scope="row">Наименование юридического лица</td>
		      <td><?=$rowsRequest['name'];?></td>
		    </tr>
		    <tr>
		      <td scope="row" class="align-middle">Адрес местонахождения юридического лица</td>
		      <td><?=$rowsRequest['address'];?></td>
		    </tr>
		    <tr>
		      <td scope="row">ИНН/ОГРН</td>
		      <td><?=$rowsRequest['INN']." / ".$rowsRequest['OGRN'];?></td>
		    </tr>
		    <tr>
		      <td scope="row">Эл. почта</td>
		      <td><?=$rowsRequest['email'];?></td>
		    </tr>
		    <tr>
		      <td scope="row">Контактный телефон</td>
		      <td><?=$rowsRequest['tel'];?></td>
		    </tr>
		    <tr>
		      <th scope="row" colspan="2" class="align-middle">В лице представителя по доверенности:</th>
		    </tr>
		    <tr>
		      <td scope="row" class="align-middle">ФИО</td>
		      <td><?=$rowsRequest['aFIO'];?></td>
		    </tr>
		    <tr>
		      <td scope="row">Контактный телефон</td>
		      <td><?=$rowsRequest['aTel'];?></td>
		    </tr>
		    <tr>
		      <td scope="row">Реквизиты доверенности или иного документа, подтверждающего полномочия представителя</td>
		      <td><?=$rowsRequest['dFLAgentDoc'];?></td>
		    </tr>
		    <tr>
		      <th scope="row" class="align-middle">Адрес запрашиваемого объекта</th>
		      <td><?=$rowsRequest['realEstate'];?></td>
		    </tr>
		    <tr>
		      <td scope="row">Серия и номер документа, удостоверяющего личность заявителя или представителя</td>
		      <td><?=$dulNum;?></td>
		    </tr>
		    <tr>
		      <td scope="row">Когда и кем выдан документ, удостоверяющий личность заявителя или представителя</td>
		      <td><?=$dulDate.", ".$dulOrg;?></td>
		    </tr>
		</tbody>
	</table>
	<p> Прошу предоставить копию(и) учетно-технической документации:</p>
	<table class="table table-bordered border-dark mb-0">	
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
	<table class="table table-bordered border-dark mb-0">
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
	<table class="table table-bordered border-dark mb-0">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Перечень прилагаемых документов </th>
    	 	</tr>
		    <tr>
		      <td scope="row" colspan="2"><?=$rowsRequest['attachList'];?></td>
		    </tr>
		</tbody>
	</table>
	<br>
	<table class="table table-bordered border-dark mb-0" style="page-break-after: always;">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Комментарий</th>
    	 	</tr>
		    <tr>
		      <td scope="row" colspan="2"><?=$rowsRequest['Comment'];?></td>
		    </tr>
		</tbody>
	</table>
	<br>
	<table class="table table-bordered border-dark">
  		<tbody>
  			<tr>
      			<td scope="row" colspan="2" class="text-center py-0"><b>Согласие на обработку персональных данных</b><br>
      				<span style="font-size: 12px;">
      					Краевому государственному бюджетному учреждению «Камчатская государственная кадастровая оценка»	
      				</span>
      			</td>
    	 	</tr>
		    <tr>
		      <td scope="row" colspan="2" class="text-center border-left-0 pb-0"><?=$FIO;?></td>
		    </tr>
		    <tr class="align-top text-center border-bottom-0">
		      <td scope="row" colspan="2" style="font-size: 10px;" class="py-0">(фамилия, имя, отчество (последнее – при наличии) субъекта персональных данных)</td>
		    </tr>
		    <tr class="border-top-0">
		      <td scope="row" colspan="2" class="text-center pb-0"><?=$address;?></td>
		    </tr>
		    <tr class="align-top text-center border-bottom-0">
		      <td scope="row" colspan="2" style="font-size: 10px;" class="py-0">(адрес места жительства субъекта персональных данных)</td>
		    </tr>
		    <tr class="border-top-0">
		      <td scope="row" colspan="2" class="text-center pb-0"><?=$dulNum.", выдан: ".$dulDate." ".$dulOrg;?></td>
		    </tr>
		    <tr class="align-top text-center border-bottom-0">
		      <td scope="row" colspan="2" style="font-size: 10px;" class="py-0">(документ, удостоверяющий личность субъекта персональных данных, его серия и номер, дата выдачи и выдавший орган)</td>
		    </tr>
		    <tr class="text-center border-top-0">
		      <td scope="row" colspan="2" class="px-5 text-start" style="text-indent: 20px;">
		      	<p>Подтверждаю согласие на обработку моих персональных данных, предусмотренную пунктом 3 статьи 3 Федерального закона от 27 июля 2006 г. № 152-ФЗ «О персональных данных», в целях рассмотрения обращения, в соответствии с Федеральным законом от 3 июля 2016 г. № 237-ФЗ «О государственной кадастровой оценке».</p>
		      	<p>Мне известно, что настоящее согласие действует бессрочно и что согласие на обработку персональных данных может быть отозвано на основании письменного заявления в произвольной форме.</p>
		       <table class="table border-dark">
		  		<tbody>
				    <tr>
				      <td scope="row" class="text-center pb-0"><?=date('d.m.Y');?></td>
				      <td scope="row" class="border-bottom-0"></td>
				      <td scope="row" class="text-center pb-0"></td>
				      <td scope="row" class="border-bottom-0"></td>
				      <td scope="row" class="text-center pb-0"><?=$sFIO;?></td>
				    </tr>
				    <tr class="align-top text-center">
				      <td scope="row" style="font-size: 10px;" class="py-0 border-bottom-0">(дата)</td>
				      <td scope="row" class="border-bottom-0"></td>
				      <td scope="row" style="font-size: 10px;" class="py-0 border-bottom-0">(подпись)</td>
				      <td scope="row" class="border-bottom-0"></td>
				      <td scope="row" style="font-size: 10px;" class="py-0 border-bottom-0">(расшифровка подписи)</td>
				    </tr>
				 </tbody>
				</table>	
		      </td>
		    </tr>
		</tbody>
	</table>
	<br>
	<p class="text-center">Достоверность и полноту предоставленных сведений подтверждаю:</p>
	<table class="table border-dark">
  		<tbody>
		    <tr>
		      <td scope="row" class="text-center pb-0"><?=date('d.m.Y');?></td>
		      <td scope="row" class="border-bottom-0"></td>
		      <td scope="row" class="text-center pb-0"></td>
		      <td scope="row" class="border-bottom-0"></td>
		      <td scope="row" class="text-center pb-0"><?=$sFIO;?></td>
		    </tr>
		    <tr class="align-top text-center">
		      <td scope="row" style="font-size: 10px;" class="py-0 border-bottom-0">(дата)</td>
		      <td scope="row" class="border-bottom-0"></td>
		      <td scope="row" style="font-size: 10px;" class="py-0 border-bottom-0">(подпись заявителя)</td>
		      <td scope="row" class="border-bottom-0"></td>
		      <td scope="row" style="font-size: 10px;" class="py-0 border-bottom-0">(расшифровка подписи)</td>
		    </tr>
		</tbody>
	</table>
</div>
</body>
</html>