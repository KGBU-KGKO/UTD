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
	$subjectTitle = 'УВЕДОМЛЕНИЕ';
	$subject = '';
	$text = '';
	$attach = "Приложение: ";
	$request->tpl->number = '0';
	$attachNum = 0;
	foreach ($request->service as $key => $service) {
		if ($service->type == 'копия') {
			if ($service->status == "Ответ") {
				$answer = "направляет копию";
				$denyReason = "";
				$attachNum++;
				$attach .= "\r$attachNum. ".$service->name." (копия) на ".$service->pages." л. в 1 экз.";
			} else {
				$answer = "отказывает в предоставлении";
				$denyReason = " в связи с ".$service->reason;
			}
			$num = $key + 1;
			$text .= "$num) $answer документа «".$service->name."» на объект недвижимости, расположенного по адресу: ".$service->realEstate->fullAddress."$denyReason;\r";
		}

		if ($service->type == 'справка') {
			if ($service->status == 'Ответ') {
				$answer = "направляет справку (выписка) «".$service->name."»";
				$denyReason = "";
			} else {
				$answer = "отказывает в предоставлении справки (выписки) «".$service->name."»";
				$denyReason = " в связи с ".$service->reason;
			}
			$attachNum++;
			$attach .= "\r$attachNum. ".$service->name." на 1 л. в 1 экз.";
			array_push($request->tpl->needRef, $key);
			$num = $key + 1;
			//$newline = ($num == 1) ? "" : "\r";
			$text .= "$num) $answer$denyReason;\r";
		}
	}
	$request->tpl->subjectTitle = $subjectTitle;
	$request->tpl->subject = $subject;
	$request->tpl->text = $text;
	$request->tpl->attach = ($attach == "Приложение: \r") ? "" : $attach;
	$request = getSignInfo($request);	
	return $request;
}

function singleServiceDataPrepare($request, $numberService) {
	$subjectTitle = 'УВЕДОМЛЕНИЕ';
	$subject = '';
	$text = '';
	$attach = '';	
	$service = $request->service[$numberService];
	if ($service->type == "копия") {
		$tpl = '1';
		$objInfo = getObjInfo($service->realEstate);
		if ($service->status == "Ответ") {
			$subject = "О предоставлении";
			$text = $service->realEstate->address."$objInfo, направляет Вам копии учётно-технической документации на указанный объект.";
			$attach = "Приложение: \r".$service->name."(копия) на ".$service->pages." л. в 1 экз.";
		}
		if ($service->status == 'Отказ') {
			$subject = 'Отказ в предоставлении';
			$text = $service->realEstate->address."$objInfo, отказывает в её предоставлении в связи с ".$service->reason.".";
		}		
	}

	if ($service->type == 'справка') {
		$tpl = '10';
		$subjectTitle = $service->shortName == "Выписка" ? "" : "СПРАВКА"; 
		$subject = $service->shortName == "Выписка" ? "Выписка из реестровой книги о праве собственности на объект капитального строительства, помещение (до 1998 года)" : "Справка, содержащая сведения о наличии/отсутствии права собственности на объекты недвижимости (до 2000 года)";
		$text = "В учетно-технической документации, регистрационных книгах (журналах), информационной системе, находящихся на хранении* в КГБУ «КГКО» ";
		if ($service->status == 'Ответ') {
			$text .= $service->shortName == "Выписка" ? "имеется следующая регистрационная запись: \r«".$service->answerText."»." : " имеются сведения о наличии права собственности в отношении объекта недвижимости, расположенного по адресу: \r«".$service->answerText."».";
		}
		if ($service->status == 'Отказ') {
			if ($service->human) {
			$bDate = $service->human->bDate;
			$fullName = $service->human->fullName;
			$info = $service->human->humInfo ? " (".$service->human->humInfo.")" : "";
			$text .= "в отношении заявителя: \r$fullName$info, $bDate года рождения, \r".$service->reason.".";
			} else {
				if ($service->realEstate) {
					$address = $service->realEstate->address;
					$objInfo = getObjInfo($service->realEstate);
					$text .= "в отношении объекта недвижимости, расположенного по адресу: \r$address$objInfo, \r".$service->reason.".";
				} else {
					$bDate = "";
					$fullName = "";		
					$text .= "в отношении заявителя: \r$fullName, $bDate года рождения, \r".$service->reason.".";			
				}
			}
		}
		$text .= $service->limits ? "\rСведениями об ограничениях, арестах и запретах не располагаем." : "";
		$text .= $service->before2000 ? "\rДополнительно сообщаем, что с 01.01.2000 года государственную регистрацию прав на недвижимое имущество и сделки с ним осуществляет Управление Федеральной службы государственной регистрации, кадастра и картографии по Камчатскому краю." : "";	
		$text .= $service->shortName == "Выписка" ? "\rНастоящая выписка дана для предоставления по месту требования." : "\rСправка дана по месту требования.";
	}

	$request->tpl->subjectTitle = $subjectTitle;
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

function getObjInfo($realEstate)
{
	$objInfoArr = [];
	$objInfoArr = pushObjInfo("инвентарный номер: ", $realEstate->inum, $objInfoArr);
	$objInfoArr = pushObjInfo("кадастровый номер: ", $realEstate->knum, $objInfoArr);
	$objInfoArr = pushObjInfo("площадь, кв. м.: ", $realEstate->area, $objInfoArr);
	$objInfoArr = pushObjInfo("дополнительная информация: ", $realEstate->info, $objInfoArr);
	$objInfoArr = pushObjInfo("местоположение: ", $realEstate->location, $objInfoArr);
	$objInfo = (count($objInfoArr) > 0) ? " (".implode(", ", $objInfoArr).")" : "";
	return $objInfo;
}
?>
