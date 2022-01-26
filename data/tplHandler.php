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

checkTemplate(getServices($numInLog), $numInLog, $numOutLog);

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
		        //echo getData($numInLog, $item);
		    	echo "Шаблон для услуги $item еще не создан, вот тебе пока только номер для ответа. <br>Регистрационный номер: $numOutLog<br>";
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
	echo $tpl."|".$num;
	// global $conn;
	// $query = "select request.IDs from request where numLog = '$num'";
	// $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	// $stmt->execute();	
	// $rows = $stmt->fetch(PDO::FETCH_ASSOC);
	// return explode (";", $rows['IDs']);

	$logOutDate = '';
	$logOutNum = '';
	$dateReq = '';
	$name = '';
	$realEstate = '';
	$performer = 'Батышева Анастасия Михайловна';
	$performer2 = '';
	$title = 'Документовед';

}

?>