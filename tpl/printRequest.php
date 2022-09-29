<?php
	include '../data/getDataReq.php';
?>
<!DOCTYPE html>
<html lang="en" style="font-size: 12px;">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../lib/bootstrap/bootstrap.min.css">

	<title>Запрос №<?=$request->num;?></title>
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
	<p class="text-center my-0 py-0">ЗАПРОС №<?=$request->num;?></p>
	<p class="text-center">о предоставлении копий учетно-технической документации и (или) содержащихся в ней сведений</p>
	<table class="table table-bordered border-dark">
  		<tbody>
  			<tr>
  			<?php
  				if ($request->declarant->type == 'FL'){
  					echo '
  						<th scope="row" colspan="2" class="text-center fw-weight-bold">
  						Сведения о заявителе - физическом лице<br>(паспортные данные подтверждаются копией паспорта)</th>
  					';
  				}
  				if ($request->declarant->type == 'UL'){
  					echo '
  						<th scope="row" colspan="2" class="text-center fw-weight-bold">Сведения о заявителе - юридическом лице</th>
  					';
  				}
  				if ($request->declarant->type == 'OGV'){
  					echo '
  						<th scope="row" colspan="2" class="text-center fw-weight-bold">Сведения о заявителе - орган государственной власти</th>
  					';
  				} 
  			 ?>
    	 	</tr>
		    <tr>
		    	<?php 
		    		if ($request->declarant->type == 'FL') {
		    			echo '<td scope="row">ФИО</td>';
		    		} else
		    		echo '<td scope="row">Наименование юридического лица</td>';
		    	 ?>	
		      <td><?=$request->declarant->name;?></td>
		    </tr>
		    <tr>
		    	<?php 
		    		if ($request->declarant->type == 'FL') {
		    			echo '<td scope="row" class="align-middle">Адрес места жительства</td>';
		    		} else
		    			echo '<td scope="row" class="align-middle">Адрес местонахождения юридического лица</td>';
		    	 ?>
		      <td><?=$request->declarant->address;?></td>
		    </tr>
		    <?php 
		    	if ($request->declarant->type == 'UL') {
		    		echo '
		    		<td scope="row">ИНН/ОГРН</td>
		      		<td>' . $request->declarant->INN . ' / '. $request->declarant->OGRN . '</td>';
		    	}
		    ?>
		    <tr>
		    	<td scope="row">Эл.почта</td>
		    	<?php
			    	if ($request->declarant->haveAgent) {
			    		if ($request->declarant->type == 'FL') {
			    			echo '<td>' . $request->declarant->agent->email . '</td>';
			    		} else {
			    			echo '<td>' . $request->declarant->email . '</td>';	
			    		}
			    	} else {
			    		echo '<td>' . $request->declarant->email . '</td>';
			    	}
		    	 ?>
		    </tr>
		    <?php
		    	if (($request->declarant->type == 'FL' && !$request->declarant->haveAgent) || 
		    	   ($request->declarant->type == 'UL')) {
		    		echo '
		    		<tr>
		    		<td scope="row">Контактный телефон</td>
		    		<td>' . $request->declarant->phone . '</td>
		    		</tr>
		    		';
		    	}
		     ?>
		    <?php
		    	if ($request->declarant->haveAgent) {
		    		echo ' 
		    			<tr>
					      <th scope="row" colspan="2" class="align-middle">В лице представителя по доверенности:</th>
					    </tr>
					    <tr>
					      <td scope="row" class="align-middle">ФИО</td>
					      <td>'.$request->declarant->agent->name.'</td>
					    </tr>
					    <tr>
					      <td scope="row">Контактный телефон</td>
					      <td>'.$request->declarant->agent->phone.'</td>
					    </tr>
					    <tr>
					      <td scope="row">Реквизиты доверенности или иного документа, подтверждающего полномочия представителя</td>
					      <td>'.$request->declarant->agent->agentDoc.'</td>
					    </tr>
		    		';
		    	}
		    ?>
		    <!-- <tr>
		      <th scope="row" class="align-middle">Адрес запрашиваемого объекта</th>
		      <td><?=$request->realEstate;?></td>
		    </tr> -->
		    <?php
		    	if ($request->declarant->haveAgent) {
		    		echo ' 
		    			<tr>
					      <td scope="row">Серия и номер документа, удостоверяющего личность представителя</td>
					      <td>'.$request->declarant->agent->dulNum.'</td>
					    </tr>
					    <tr>
					      <td scope="row">Когда и кем выдан документ, удостоверяющий личность представителя</td>
					      <td>'.$request->declarant->agent->dulDate. ', '.$request->declarant->agent->dulOrg.'</td>
					    </tr>
		    		';
		    	}
		    	else {
		    		echo ' 
		    			<tr>
					      <td scope="row">Серия и номер документа, удостоверяющего личность заявителя</td>
					      <td>'. $request->declarant->dulNum . '</td>
					    </tr>
					    <tr>
					      <td scope="row">Когда и кем выдан документ, удостоверяющий личность заявителя</td>
					      <td>' . $request->declarant->dulDate .', '.$request->declarant->dulOrg.'</td>
					    </tr>
		    		';
		    	}
		    ?>
		</tbody>
	</table>
	<p> Прошу предоставить копию(и) учетно-технической документации:</p>
	<table class="table table-bordered border-dark mb-0">	
  		<tbody>
  			<tr>
  				<th scope="row" class="text-center">№</th>
      			<th scope="row" class="text-center">Услуга</th>
      			<th scope="row" class="text-center">Объект услуги</th>
      			<th scope="row" class="text-center">Размер платы</th>
    	 	</tr>
    	 	<?php
    	 		$num = 0;
    	 		foreach($request->service as $service) {
	    	 		$num++;
	    	 		$svc = $service->name;
	    	 		//$serviceObject = ($service->forHuman == 1 ? $service->human->fullName : $service->realEstate->fullAddress.";".$service->realEstate->info);
	    	 		if ($service->forHuman == 1) {
	    	 			$serviceObject = $service->human->fullName;
	    	 		} else {
	    	 			$objectInfo = [];
	    	 			array_push($objectInfo, $service->realEstate->fullAddress);
	    	 			if ($service->realEstate->inum)
	    	 				array_push($objectInfo, "инв. номер: ".$service->realEstate->inum);
	    	 			if ($service->realEstate->knum)
	    	 				array_push($objectInfo, "кад. номер: ".$service->realEstate->knum);
	    	 			if ($service->realEstate->area)
	    	 				array_push($objectInfo, "площадь, кв.м.: ".$service->realEstate->area);
	    	 			if ($service->realEstate->location)
	    	 				array_push($objectInfo, "местоположение: ".$service->realEstate->location);
	    	 			if ($service->realEstate->info)
	    	 				array_push($objectInfo, "доп. инф.: ".$service->realEstate->info);
	    	 			$serviceObject = implode("; ", $objectInfo);
	    	 		}
	    	 		echo "<tr><th class=\"align-center text-center\">$num</th><td>$service->name</td><td>$serviceObject</td><td></td></tr>";
	    	 	}
    	 	?>
		</tbody>
	</table>
	<br>
	<table class="table table-bordered border-dark mb-0">
  		<tbody>
  			<tr>
      			<th scope="row" colspan="2" class="text-center fw-weight-bold">Способ получения копий учетно-технической документации и (или) содержащихся в ней сведений, уведомлений</th>
    	 	</tr>
		    <tr>
		      <td scope="row" colspan="2"><?=$request->delivery;?></td>
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
		      <td scope="row" colspan="2"><?=$request->attachList;?></td>
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
		      <td scope="row" colspan="2"><?=$request->comment;?></td>
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
    	 	<?php 
    	 		if ($request->declarant->haveAgent) {
    	 			$FIO = $request->declarant->agent->name;
    	 			$address = $request->declarant->agent->address;
    	 			$dulNum = $request->declarant->agent->dulNum;
    	 			$dulDate = $request->declarant->agent->dulDate;
    	 			$dulOrg = $request->declarant->agent->dulOrg;
    	 		} else {
    	 			$FIO = $request->declarant->name;
    	 			$address = $request->declarant->address;
    	 			$dulNum = $request->declarant->dulNum;
    	 			$dulDate = $request->declarant->dulDate;
    	 			$dulOrg = $request->declarant->dulOrg;
    	 		}

    	 		$sFIO = explode(' ', $FIO);
    	 		$firstName = substr($sFIO[1],0,2);
    	 		if (count($sFIO) > 2) {
    	 			$middleName = substr($sFIO[2],0,2) . '.';
    	 		} else {
    	 			$middleName = '';
    	 		}
    	 		$lastName = $sFIO[0];
				$sFIO = ($request->declarant->type == 'OGV' ? '' : substr($sFIO[1],0,2) . '. ' . $middleName . ' ' . $sFIO[0]);

    	 		
    	 	 ?>
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