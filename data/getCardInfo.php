<?php
$num = $_GET['numLog'];

include "getDataReq.php";

$data = (object) [
  'decTbl' => '',
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

echo json_encode($data);
?>