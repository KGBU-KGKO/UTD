<?php
	include '../data/config.php';
	include 'classRequest.php';

	if (empty($num)) $num = (isset($_GET["numLog"])) ? $_GET["numLog"] : die('Не указан номер запроса');
	$query = "select request.ID as 'idReq', request.numLog as 'numLogReq', request.dateReq, request.dateDue, request.datePayment, request.dateIssue, request.status as 'statusReq', 
request.Comment, request.smevNum, request.senderNum, request.senderDate, request.delivery, request.attachList, request.path, IDa,

declarant.name, declarant.type, declarant.INN, declarant.OGRN, declarant.address as 'addressDec', declarant.tel as 'telDec', 
declarant.email as 'emailDec', declarant.dateBirth, declarant.dulNum as 'dulNumDec', declarant.dulDate as 'dulDateDec', declarant.dulOrg as 'dulOrgDec', 
declarant.shortName as 'sNameDec', 

agent.FIO as 'nameAgent', agent.tel as 'telAgent', agent.email as 'emailAgent', request.agentDoc as 'docAgent', agent.address as 'addressAgent', agent.dulNum as 'dulNumAgent', 
agent.dulDate as 'dulDateAgent', agent.dulOrg as 'dulOrgAgent', 

reply.numLog as 'numLogRep', reply.dateReply, reply.status as 'statusRep', 

users.FIO as 'userFIO', users.shortFIO as 'userShortFIO', users.jobTitle as 'userJobTitle', users.imgPath as 'userIMGPath', users.iconPath as 'userIconPath'

from request 
inner join declarant on request.IDd = declarant.ID
left join agent on request.IDa = agent.ID
left join reply on request.ID = reply.IDr
left join users on request.performer = users.shortFIO
where request.numLog = '$num'";
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);				

	$request = new Request();
	//запрос
	$request->id = $rows["idReq"];
	$request->num = $rows["numLogReq"];
	$request->date = ($rows["dateReq"]) ? date("d.m.Y", strtotime($rows["dateReq"])) : '';
	$request->dateDue = ($rows["dateDue"]) ? date("d.m.Y", strtotime($rows["dateDue"])) : '';
	$request->datePay = ($rows["datePayment"]) ? date("d.m.Y", strtotime($rows["datePayment"])) : '';
	$request->dateIssue = ($rows["dateIssue"]) ? date("d.m.Y", strtotime($rows["dateIssue"])) : '';
	$request->senderNum = $rows["senderNum"];
	$request->senderDate = ($rows["senderDate"]) ? date("d.m.Y", strtotime($rows["senderDate"])) : '';
	$request->smevNum = $rows["smevNum"];
	$request->status = $rows["statusReq"];
	$request->comment = $rows["Comment"]; 
	$request->delivery = $rows["delivery"];
	$request->attachList = $rows["attachList"];
	$request->fileList = getFileList($request->num);
	//исполнитель
	$request->performer->name = $rows["userFIO"];
	$request->performer->shortName = $rows["userShortFIO"];
	$request->performer->title = $rows["userJobTitle"];
	$request->performer->pathIMG = $rows["userIMGPath"];
	//заявитель
	$request->declarant->type = $rows["type"];
	$request->declarant->haveAgent = ($rows["IDa"]) ? True : False;
	$request->declarant->name = $rows["name"];
	$request->declarant->address = $rows["addressDec"];
	$request->declarant->birth = ($rows["dateBirth"]) ? date("d.m.Y", strtotime($rows["dateBirth"])) : '';
	$request->declarant->email = $rows["emailDec"];
	$request->declarant->phone = $rows["telDec"];
	$request->declarant->INN = $rows["INN"];
	$request->declarant->OGRN = $rows["OGRN"];
	$request->declarant->dulNum = $rows["dulNumDec"];
	$request->declarant->dulDate = ($rows["dulDateDec"]) ? date("d.m.Y", strtotime($rows["dulDateDec"])) : '';
	$request->declarant->dulOrg = $rows["dulOrgDec"];
	$request->declarant->shortName = $rows["sNameDec"];
	//агент 
	if ($request->declarant->haveAgent) {
		$request->declarant->agent = new Agent();
		$request->declarant->agent->name = $rows["nameAgent"];
		$request->declarant->agent->address = $rows["addressAgent"];
		$request->declarant->agent->email = $rows["emailAgent"];
		$request->declarant->agent->phone = $rows["telAgent"];	
		$request->declarant->agent->dulNum = $rows["dulNumAgent"];
		$request->declarant->agent->dulDate = $rows["dulDateAgent"];
		$request->declarant->agent->dulOrg = $rows["dulOrgAgent"];	
		$request->declarant->agent->agentDoc = $rows["docAgent"];
	}
	//ответ
	$request->reply->num = $rows["numLogRep"];
	$request->reply->date = ($rows["dateReply"]) ? date("d.m.Y", strtotime($rows["dateReply"])) : '';
	//история
	$query = "select FORMAT (time, 'dd.MM.yyyy hh:mm tt') as time, event, shortFIO as 'user' from log inner join users on log.IDu = users.ID where IDr = ".$request->id;
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach ($rows as $row) {
		array_push($request->history, new History($row));
	}
	//услуги по запросу
	$query = "select service.id, IDs as 'num', dict_svc.name, dict_svc.shortName, service.forHum as 'forHuman', service.status, service.reason, service.answerText,
			IDoh as 'idObject', pages, before2000, limits
			from service 
			inner join dict_svc on service.IDs = dict_svc.number
			where IDr = ".$request->id;
	$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt->execute();	
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);	

	foreach ($rows as $row) {
		$service = new Service($row);
		if ($service->forHuman == 1) {
			$query = "select firstName, middleName, lastName, humInfo, bDate, dulNum, dulDate, dulOrg, 
CONCAT((lastName),(' '+firstName),(' '+middleName)) as 'fullName',
CONCAT((lastName),(' '+SUBSTRING(firstName,1,1)+'.'),(' '+SUBSTRING(middleName,1,1)+'.')) as 'name'
from human where ID = ".$service->idObject;
		} else {
			$query = "select postcode, dict_region.name as 'region', dict_district.name as 'district', dict_city.pre+'. '+dict_city.name as 'city', dict_street.pre+'. '+dict_street.name as 'street', 
'д. '+house as 'house', 'кв. '+flat as 'flat', location, numInventory as 'inum', kn as 'knum', area, objInfo as 'info',
CONCAT((dict_city.pre+'. '+dict_city.name),(', '+dict_street.pre+'. '+dict_street.name),(', д. '+house),(', кв. '+flat) ) as 'address',
CONCAT((dict_street.pre+'. '+dict_street.name),(', д. '+house),(', кв. '+flat),(', '+dict_city.pre+'. '+dict_city.name),(', '+dict_district.name),(', '+dict_region.name),(', '+postcode) ) as 'fullAddress'
from object
left join dict_region on object.IDreg = dict_region.ID
left join dict_district on object.IDdis = dict_district.ID
left join dict_city on object.IDcit = dict_city.ID
left join dict_street on object.IDstr = dict_street.ID
where object.ID = ".$service->idObject;
		}
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();	
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);	
		($service->forHuman == 1) ? $service->human = new Human($rows) : $service->realEstate = new RealEstate($rows);
		array_push($request->service, $service);
	}
	foreach ($request->service as $service) {
		$service->type = (in_array($service->num, [7,10])) ? 'справка' : 'копия';
	}
	//var_dump($request);
	function getServicesName($svc, $typeName)
	{	
		$svc_str = "";
		$svc_arr = explode(';', $svc);
		global $conn;
		$query = "select number, name, shortName from dict_svc where status is null";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();	
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($svc_arr as $value) {
			$svc_str .= '; '.$rows[($value - 1)][$typeName];
		}
		return substr($svc_str, 2); 
	}

	function getFileList($num)
	{
	  $filesList = '';
	  $files = glob("../files/".explode('/', $num)[1]."/*.*");
	  if(!empty($files)) {
	    foreach ($files as $file) {
	        $filesList .= ', <a href="'.substr($file, 2).'" target="_blank">'.explode("/", $file)[3].'</a>';
	    }    
	  }
	  return substr($filesList, 2);
	}

$stmt = null;
$conn = null;
?>