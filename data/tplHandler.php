<?php 
include 'config.php';

$listServices = array(
    1 => "Тех. паспорт",
    2 => "План",
    3 => "Экспликация",
    4 => "d",
    5 => "a",
    6 => "b",
    7 => "c",
    8 => "d",
    9 => "a",
    10 => "b",
    11 => "Справка о собственности"
);

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
		        return getData($numInLog, $item);
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
	//echo $tpl."|".$num;
	global $conn;
	$query = "select reply.dateReply as 'logOutDate', reply.numLog as 'logOutNum', request.numLog as 'logInNum', request.dateReq as 'logInDate', declarant.name, declarant.address, declarant.email, request.realEstate, reply.status as 'answer', reply.reason, request.performer from request  
			inner join reply on request.ID = reply.IDr
			inner join declarant on request.IDd = declarant.ID
			where request.numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	$request->logInNum = $rows["logInNum"];
	$request->logOutNum = $rows["logOutNum"];
	$request->logInDate = $rows["logInDate"];
	$request->logOutDate = $rows["logOutDate"];
	$request->declarant->name = $rows["name"];
	$request->declarant->address = $rows["address"];
	$request->declarant->email = $rows["email"];
	$request->realEstate = $rows["realEstate"];
	$request->answer = $rows["answer"];
	$request->reason = $row["reason"];
	$request->performer->name = $rows["performer"];
	$request->performer->shortName = $rows["performer"];
	$request->performer->title = "Документовед";
	return $request;
}

?>