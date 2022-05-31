<?php
include "getDataReq.php";

$data = (object) [
  'decTbl' => '',
  'svcTbl' => '',
  'svcTblReply' => '',
  'history' => '',
  'request' => $request,
];
$agent = '';

switch ($request->declarant->type) {
  case 'FL':
  $decTelEmail = implode(', ', array_filter([$request->declarant->phone, $request->declarant->email]));
  $decTelEmail = ($decTelEmail == '') ? '-' : $decTelEmail;
  $decDUL = $request->declarant->dulNum." от ".$request->declarant->dulDate." выдан: ".$request->declarant->dulOrg;
  $decDUL = ($decDUL == ' от  выдан: ') ? '-' : $decDUL;
  if ($request->declarant->haveAgent) {
    $agent = "<tr>
      <td class='w600'>ФИО представителя</td>
      <td>".$request->declarant->agent->name."</td>
    </tr>
    <tr>
      <td class='w600'>Реквизиты доверенности</td>
      <td>".$request->declarant->agent->agentDoc."</td>
    </tr>
    <tr>
      <td class='w600'>Место жительства</td>
      <td>".$request->declarant->agent->address."</td>
    </tr>
    <tr>
      <td class='w600'>Тел., email</td>
      <td>".implode(', ', array_filter([$request->declarant->agent->phone, $request->declarant->agent->email]))."</td>
    </tr>
    <tr>
      <td class='w600'>ДУЛ</td>
      <td>".$request->declarant->agent->dulNum." от ".$request->declarant->agent->dulDate." выдан: ".$request->declarant->agent->dulOrg."</td>
    </tr>";
  } 
  $data->decTbl = "<table class='table table-bordered table-sm mt-2'>
  <tbody>
    <tr>
      <td class='w600'>ФИО</td>
      <td>".$request->declarant->name."</td>
    </tr>
    <tr>
      <td class='w600'>Место жительства</td>
      <td>".$request->declarant->address."</td>
    </tr>
    <tr>
      <td class='w600'>Дата рождения</td>
      <td>".$request->declarant->birth."</td>
    </tr>
    <tr>
      <td class='w600'>Тел., email</td>
      <td>$decTelEmail</td>
    </tr>
    <tr>
      <td class='w600'>ДУЛ</td>
      <td>$decDUL</td>
    </tr>
    $agent
  </tbody>
</table>";
    break;

  case 'UL':
  $decTelEmail = implode(', ', array_filter([$request->declarant->phone, $request->declarant->email]));
  $decTelEmail = ($decTelEmail == '') ? '-' : $decTelEmail;
  $data->decTbl = "<table class='table table-bordered table-sm mt-2'>
  <tbody>
    <tr>
      <td class='w600'>Наименование</td>
      <td>".$request->declarant->name."</td>
    </tr>
    <tr>
      <td class='w600'>ИНН/ОГРН</td>
      <td>".$request->declarant->INN."/".$request->declarant->OGRN."</td>
    </tr>
    <tr>
      <td class='w600'>Адрес местонахождения</td>
      <td>".$request->declarant->address."</td>
    </tr>
    <tr>
      <td class='w600'>Тел., email</td>
      <td>$decTelEmail</td>
    </tr>
    <tr>
      <td class='w600'>ФИО представителя</td>
      <td>".$request->declarant->agent->name."</td>
    </tr>
    <tr>
      <td class='w600'>Реквизиты доверенности</td>
      <td>".$request->declarant->agent->agentDoc."</td>
    </tr>
    <tr>
      <td class='w600'>Адрес проживания</td>
      <td>".$request->declarant->agent->address."</td>
    </tr>
    <tr>
      <td class='w600'>ДУЛ</td>
      <td>".$request->declarant->agent->dulNum." от ".$request->declarant->agent->dulDate.", выдан: ".$request->declarant->agent->dulOrg."</td>
    </tr>
  </tbody>
</table>";
    break;

  case 'OGV':
  $data->decTbl = "<table class='table table-bordered table-sm mt-2'>
  <tbody>
    <tr>
      <td class='w600'>Наименование</td>
      <td>".$request->declarant->name."</td>
    </tr>
    <tr>
      <td class='w600'>Исходящий №</td>
      <td>".$request->senderNum." от ".$request->senderDate."</td>
    </tr>
    <tr>
      <td class='w600'>Номер СМЭВ</td>
      <td>".$request->smevNum."</td>
    </tr>
  </tbody>
</table>";
    break;        

}

foreach ($request->history as $record) {
  $event = $record->event;
  $time = $record->time;
  $user = $record->user;
  $row = "<li><div class=\"w600\">$event</div>
              <div class=\"history-detail\"><i class=\"bi bi-calendar-event\"></i> $time</div>
              <div class=\"history-detail\"><i class=\"bi bi-person\"></i> $user</div></li>";
  $data->history .= $row;
}

foreach ($request->service as $service) {
  $serviceName = $service->shortName;
  if ($service->forHuman == 0) {
    $serviceObject = $service->realEstate->address;
    $location = $service->realEstate->location ? 'месторасположение: '.$service->realEstate->location : '';
    $inum = $service->realEstate->inum ? 'инв. номер: '.$service->realEstate->inum : '';
    $knum = $service->realEstate->knum ? 'КН: '.$service->realEstate->knum : '';
    $area = $service->realEstate->area ? 'площадь, кв. м.: '.$service->realEstate->area : '';
    $info = $service->realEstate->info ? 'доп. инф.: '.$service->realEstate->info: '';
    $serviceObjectInfo = concatInfo([$location, $inum, $knum, $area, $info]);
  } else {
    $serviceObject = $service->human->name;
    $bday = $service->human->bDate ? 'дата рождения: '.prettyDate($service->human->bDate) : '';
    $dulNum = $service->human->dulNum ? 'серия и номер: '.$service->human->dulNum : '';
    $dulDate = $service->human->dulDate ? 'дата документа: '.prettyDate($service->human->dulDate) : '';
    $dulOrg = $service->human->dulOrg ? 'кем выдан: '.$service->human->dulOrg : '';
    $serviceObjectInfo = concatInfo([$bday, $dulNum, $dulDate, $dulOrg]);
  }
  $row = "<tr><td>$serviceName</td><td>$serviceObject</td><td>$serviceObjectInfo</td></tr>";
  $data->svcTbl .= $row;
  if ($service->status) {
    $status = $service->status;
    $reason = $service->reason ? 'причина отказа: в связи с '.$service->reason : '';
    $answerText = $service->answerText ? 'текст справки: '.$service->answerText : '';
    $pages = $service->pages ? 'кол-во листов: '.$service->pages : '';
    $serviceReplyInfo = concatInfo([$reason, $answerText, $pages]);
    $row = "<tr><td>$serviceName</td><td>$status</td><td>$serviceReplyInfo</td></tr>";
    $data->svcTblReply .= $row;    
  }

}

function prettyDate($date)
{
  return ($date) ? date("d.m.Y", strtotime($date)) : '';
}

function concatInfo($arr = [])
{
  $newArr = [];
  foreach ($arr as $value) {
    if ($value)
      array_push($newArr, $value);
  }
  return implode(', ', $newArr);
}

echo json_encode($data);
?>