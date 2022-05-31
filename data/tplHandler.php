<?php 
include 'getDataReq.php';
$request = dataPrepare($request);
function dataPrepare($request)
{

	if (count($request->service) > 1 ) {
		return multiServiceDataPrepare($request);
	}

	return singleServiceDataPrepare($request, 0);

}

function multiServiceDataPrepare($request)
{
	$subject = '';
	$text = '';
	$attach = "Приложение: q";
	$request->tpl->number = '0';
	$attachNum = 0;
	foreach ($request->service as $key => $service) {
		if ($service->type == 'копия') {
			if ($service->status == "Ответ") {
				$answer = "копия документа предоставлена.";
				$attachNum++;
				$attach .= "$attachNum. ".$service->name."(копия) на ".$service->pages." л. в 1 экз.q";
			} else {
				$answer = "в предоставлении документов отказано в связи с ".$service->reason.".";
			}
			$num = $key + 1;
			$text .= "$num. ".$service->name." на объект недвижимости, расположенный по адресу: ".$service->realEstate->fullAddress.", сообщает, что $answer q";
		}

		if ($service->type == 'справка') {
			if ($service->status == 'Ответ') {
				$answer = "справка (выписка) предоставлена.";
				$attachNum++;
				$attach .= "$attachNum. ".$service->name." на 1 л. в 1 экз.q";
			} else {
				$answer = "в предоставлении справки отказано в связи с ".$service->reason.".";
			}
			array_push($request->tpl->needRef, $key);
			$num = $key + 1;
			$text .= "$num. ".$service->name.", сообщает, что $answer q";
		}
	}
	$request->tpl->subject = $subject;
	$request->tpl->text = $text;
	$request->tpl->attach = ($attach == "Приложение: q") ? "" : $attach;
	$request = getSignInfo($request);	
	return $request;
}

function singleServiceDataPrepare($request, $numberService) {
	$subject = '';
	$text = '';
	$attach = '';	
	$service = $request->service[$numberService];
	if ($service->type == "копия") {
		$tpl = '1';
		$objInfoArr = [];
		$objInfoArr = pushObjInfo("инвентарный номер: ", $service->realEstate->inum, $objInfoArr);
		$objInfoArr = pushObjInfo("кадастровый номер: ", $service->realEstate->knum, $objInfoArr);
		$objInfoArr = pushObjInfo("площадь, кв. м.: ", $service->realEstate->area, $objInfoArr);
		$objInfoArr = pushObjInfo("дополнительная информация: ", $service->realEstate->info, $objInfoArr);
		$objInfoArr = pushObjInfo("местоположение: ", $service->realEstate->location, $objInfoArr);
		$objInfo = (count($objInfoArr) > 0) ? " (".implode(" ,", $objInfoArr).")" : "";
		if ($service->status == "Ответ") {
			$subject = "О предоставлении";
			$text = $service->realEstate->address."$objInfo, направляет Вам копии учётно-технической документации на указанный объект";
			$attach = "Приложение: ".$service->name."(копия) на ".$service->pages." л. в 1 экз.";
		}
		if ($service->status == 'Отказ') {
			$subject = 'Отказ в предоставлении';
			$text = $service->realEstate->address."$objInfo, отказывает в её предоставлении в связи с ".$service->reason;
		}		
	}

	if ($service->type == 'справка') {
		$tpl = '10';
		if ($service->status == 'Ответ') {
			$text = " имеются сведения о наличии права собственности в отношении объекта недвижимости, расположенного по адресу:q«".$service->answerText."».";
		}
		if ($service->status == 'Отказ') {
			if ($service->human) {
			$bDate = ($service->human->bDate) ? date("d.m.Y", strtotime($service->human->bDate)) : "";
			$fullName = $service->human->fullName;
			} else {
				$bDate = "";
				$fullName = "";
			}
			$text = "в отношении заявителя: q$fullName, $bDate года рождения, q".$service->reason.".";
		}
		$text .= $service->limits ? "qСведениями об ограничениях, арестах и запретах не располагаем." : "";
		$text .= $service->before2000 ? "qДополнительно сообщаем, что с 01.01.2000 года государственную регистрацию прав на недвижимое имущество и сделки с ним осуществляет Управление Федеральной службы государственной регистрации, кадастра и картографии по Камчатскому краю." : "";	
	}

	$request->tpl->subject = $subject;
	$request->tpl->text = $text;
	$request->tpl->attach = $attach;
	$request->tpl->number = $tpl;
	$request = getSignInfo($request);
	return $request;	
}

function getSignInfo($request) {
	$str = file_get_contents("../data/template.json");
	$data = json_decode($str);
	$type = $request->declarant->type;

	if ($data->$type->signName != 'self') {
		$request->performer->shortName = $data->$type->signName;
		$request->performer->title = $data->$type->signTitle;
		$request->performer->pathIMG = "";
	}

	return $request;
}

function pushObjInfo($name, $value, $arr)
{
	if ($value)
		array_push($arr, $name.$value);
	return $arr;
}

?>
