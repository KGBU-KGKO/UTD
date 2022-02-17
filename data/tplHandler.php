<?php 
include 'config.php';

$request = checkTemplate(getServices($numInLog), $numInLog, $numOutLog);

function checkTemplate($services, $numInLog, $numOutLog) {
	//var_dump($services);
	if (count($services) > 1) {
		echo "Много услуг<br>";
		echo "Шаблон для этого запроса еще не создан, вот тебе пока только номер для ответа. <br>Регистрационный номер: $numOutLog<br>";
		die();
	}

    foreach ($services as $item) {
		switch ($item) {
		    case 1:
		        $request = getData($numInLog, $item);
		        if ($request->answer == "Ответ") {
		        	$request->answerText = "направляет копию технического паспорта";
		        	$request->attach = "Приложение: Копия технического паспорта на 0 л. в 1 экз.";
		        	$request->subject = "Предоставление";
		        }
		        if ($request->answer == "Отказ") {
		        	$request->answerText = "отказывает в её предоставлении в связи с ".$request->reason;
		        	$request->subject = "Отказ в предоставлении";
		        }
		        return $request;
		        break;
		    case 2:
		    case 3:
		    case 4:
		    case 5:
		    case 6:
		    case 7:
		    case 8:
		    case 9:
		    case 10:
		    case 11:
		        echo "Шаблон для услуги $item еще не создан, вот тебе пока только номер для ответа. <br>Регистрационный номер: $numOutLog<br>";
		        break;
		}
    }
}

function getServices($num) {
	global $conn;
	$query = "select request.IDs from request where numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	return explode (";", $rows['IDs']);
}

function getData($num, $tpl) {
	$request = new Request(new Declarant(), new Performer());
	$str = file_get_contents("../data/template.json");
	$data = json_decode($str);
	global $conn;
	$query = "select reply.dateReply as 'logOutDate', reply.numLog as 'logOutNum', request.numLog as 'logInNum', request.dateReq as 'logInDate', 
		declarant.name, declarant.type, declarant.address, declarant.email, request.realEstate, reply.status as 'answer', request.senderNum, request.senderDate,
		reply.reason, request.performer, request.smevNum, users.shortFIO, users.FIO, users.jobTitle, users.imgPath
		from request  
			inner join reply on request.ID = reply.IDr
			inner join declarant on request.IDd = declarant.ID
			inner join users on request.performer = users.shortFIO
			where request.numLog ='$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	$request->logInNum = $rows["logInNum"];
	$request->logOutNum = $rows["logOutNum"];
	$request->logInDate = $rows["logInDate"];
	$request->logOutDate = $rows["logOutDate"];
	$request->senderNum = $rows["senderNum"];
	$request->senderDate = $rows["senderDate"];
	$request->smev = $rows["smevNum"];
	$request->declarant->name = $rows["name"];
	$request->declarant->address = $rows["address"] ?? '';
	$request->declarant->email = $rows["email"] ?? '';
	$request->realEstate = $rows["realEstate"];
	$answer = $rows["answer"];
	$type = $rows["type"];
	$request->answer = $answer;
	$request->reason = $rows["reason"];

	if ($data->{$tpl}->answer->$answer->decType->$type->signName == 'self') {
		$request->performer->shortName = $rows["shortFIO"];
		$request->performer->title = $rows["jobTitle"]; 
		$request->performer->name = $rows["FIO"]; 
		$request->performer->pathIMG = $rows["imgPath"];
	} else {
		$request->performer->shortName = $data->{$tpl}->answer->$answer->decType->$type->signName;
		$request->performer->title = $data->{$tpl}->answer->$answer->decType->$type->signTitle;
		$request->performer->name = $rows["FIO"]; 
	}

	return $request;
}

?>