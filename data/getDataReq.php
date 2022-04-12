<?php
	include '../data/config.php';
	include 'classRequest.php';

	if (empty($num)) $num = (isset($_GET["numLog"])) ? $_GET["numLog"] : die('Не указан номер запроса');
	$query = "select request.numLog as 'numLogReq', request.dateReq, request.status as 'statusReq', request.realEstate, request.Comment, request.IDs,request.delivery, request.attachList, request.dFLAgentDoc, request.IDa, request.senderNum, request.senderDate, request.smevNum, request.objInfo,

declarant.name, declarant.type, declarant.INN, declarant.OGRN, declarant.address as 'addressDec', declarant.tel as 'telDec', 
declarant.email as 'emailDec', declarant.dateBirth, declarant.dulNum as 'dulNumDec', declarant.dulDate as 'dulDateDec', declarant.dulOrg as 'dulOrgDec', 
declarant.shortName, 

agent.FIO, agent.tel as 'telAgent', agent.email as 'emailAgent', request.dFLAgentDoc, agent.address as 'addressAgent', agent.dulNum as 'dulNumAgent', 
agent.dulDate as 'dulDateAgent', agent.dulOrg as 'dulOrgAgent', 

reply.numLog as 'numLogRep', reply.dateReply, reply.status as 'statusRep', reply.reason, reply.text, 

users.FIO as 'userFIO', 
users.shortFIO as 'userShortFIO', users.jobTitle as 'userJobTitle', users.imgPath as 'userIMGPath', users.iconPath as 'userIconPath'

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
	$request->num = $rows["numLogReq"];
	$request->date = ($rows["dateReq"]) ? date("d.m.Y", strtotime($rows["dateReq"])) : '';
	$request->senderNum = $rows["senderNum"];
	$request->senderDate = ($rows["senderDate"]) ? date("d.m.Y", strtotime($rows["senderDate"])) : '';
	$request->smevNum = $rows["smevNum"];
	$request->status = $rows["statusReq"];
	$request->realEstate = $rows["realEstate"];
	$request->objInfo = $rows["objInfo"]; 
	$request->comment = $rows["Comment"]; 
	$request->svc = getServicesName($rows["IDs"], "shortName");
	$request->svcFull = getServicesName($rows["IDs"], "name");
	$request->delivery = $rows["delivery"];
	$request->attachList = $rows["attachList"];
	$request->fileList = getFileList($request->num);
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
	$request->declarant->ORGN = $rows["OGRN"];
	$request->declarant->dulNum = $rows["dulNumDec"];
	$request->declarant->dulDate = $rows["dulDateDec"];
	$request->declarant->dulOrg = $rows["dulOrgDec"];
	$request->declarant->shortName = $rows["shortName"];
	//агент 
	$request->declarant->agent->name = $rows["FIO"];
	$request->declarant->agent->address = $rows["addressAgent"];
	$request->declarant->agent->email = $rows["emailAgent"];
	$request->declarant->agent->phone = $rows["telAgent"];	
	$request->declarant->agent->dulNum = $rows["dulNumAgent"];
	$request->declarant->agent->dulDate = $rows["dulDateAgent"];
	$request->declarant->agent->dulOrg = $rows["dulOrgAgent"];	
	$request->declarant->agent->agentDoc = $rows["dFLAgentDoc"];
	//ответ
	$request->reply->num = $rows["numLogRep"];
	$request->reply->date = ($rows["dateReply"]) ? date("d.m.Y", strtotime($rows["dateReply"])) : '';
	$request->reply->status = $rows["statusRep"];
	$request->reply->reason = $rows["reason"];
	$request->reply->text = $rows["text"];
	//история

	//var_dump($request);
	function getServicesName($svc, $typeName)
	{	
		$svc_str = "";
		$svc_arr = explode(';', $svc);
		global $conn;
		$query = "select number, name, shortName from service where status is null";
		$stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt->execute();	
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		foreach ($svc_arr as $value) {
			$svc_str .= ', '.$rows[($value - 1)][$typeName];
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