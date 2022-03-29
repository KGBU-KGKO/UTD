<?php 
include 'getDataReq.php';

$request = checkTemplate(explode(', ', $request->svc), $request);

function checkTemplate($services, $request) {
	if (count($services) > 1) {
		$num = $request->reply->num;
		echo "Много услуг<br>Шаблон для этого запроса еще не создан, вот тебе пока только номер для ответа. <br>Регистрационный номер: $num<br>";
		die();
	}

    foreach ($services as $item) {
    	$request->tpl->number = $item;
    	$request = getMoreInfo($request);
		switch ($item) {
		    case "Тех. паспорт":
		    	$request->tpl->number = '1';
		        if ($request->reply->status == "Ответ") {
		        	$request->tpl->answerText = "направляет Вам копии учётно-технической документации на указанный объект";
		        	$request->tpl->attach = "Приложение: копия технического паспорта на 0 л. в 1 экз.";
		        	$request->tpl->subject = "О предоставлении";
		        }
		        if ($request->reply->status == "Отказ") {
		        	$request->tpl->answerText = "отказывает в её предоставлении в связи с ".$request->reply->reason;
		        	$request->tpl->subject = "Отказ в предоставлении";
		        }
		        return $request;
		        break;
		    case "ПД":
		        $request->tpl->number = '1';
		        if ($request->reply->status == "Ответ") {
		        	$request->tpl->answerText = "направляет Вам копии учётно-технической документации на указанный объект";
		        	$request->tpl->attach = "Приложение: копия правоустанавливающих документов на 0 л. в 1 экз.";
		        	$request->tpl->subject = "О предоставлении";
		        }
		        if ($request->reply->status == "Отказ") {
		        	$request->tpl->answerText = "отказывает в её предоставлении в связи с ".$request->reply->reason;
		        	$request->tpl->subject = "Отказ в предоставлении";
		        }
		        return $request;
		        break;		    
		    case "Справка о собственности":
		    	$request->tpl->number = '10';
		        if ($request->reply->status == "Ответ") {
		        	$request->tpl->answerText = " имеются сведения о наличии права собственности в отношении объекта недвижимости, расположенного по адресу:";
		        	$request->reply->text = "\n\"".$request->reply->text."\"";
		        }
		        if ($request->reply->status == "Отказ") {
		        	$name = $request->declarant->name;
		        	$birth = $request->declarant->birth;
		        	$request->tpl->answerText = ", в отношении заявителя: \n$name, $birth года рождения, \nотсутствуют сведения о наличии права собственности на объекты недвижимости";
		        }
		        return $request;
		        break;			    
    		default:
		        echo "Шаблон для услуги $item еще не создан, вот тебе пока только номер для ответа. <br>Регистрационный номер: ".$request->reply->num;
		        break;
		}
    }
}

function getMoreInfo($request) {
	$str = file_get_contents("../data/template.json");
	$data = json_decode($str);

	$answer = $request->reply->status;
	$type = $request->declarant->type;
	$tpl = $request->tpl->number;

	if ($data->$tpl->answer->$answer->decType->$type->signName != 'self') {
		$request->performer->shortName = $data->{$tpl}->answer->$answer->decType->$type->signName;
		$request->performer->title = $data->{$tpl}->answer->$answer->decType->$type->signTitle;
	}

	return $request;
}

?>