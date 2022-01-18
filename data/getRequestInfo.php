<?php
$type = $_GET['typeDec'];
$num = $_GET['numLog'];

include "getData$type.php";

function getFileList($num)
{
  $filesList = '';
  $files = glob("../files/".explode('/', $num)[1]."/*.*");
  if(!empty($files)) {
    foreach ($files as $file) {
        $filesList = $filesList.'<li><a href="'.substr($file, 2).'" target="_blank">'.explode("/", $file)[3].'</a></li>';
    }    
  }
  return $filesList;
}

function getListAttachments($attachRow)
{
  $attachmentsList = '';
  if ($attachRow) {
    $attachments = explode(", ", $attachRow);
    foreach ($attachments as $attachment) {
        $attachmentsList = $attachmentsList.'<li>'.$attachment.'</li>';
    }
  }
  return $attachmentsList;
}

echo '<div class="modal-header">
        <h5 class="modal-title" id="reqInfoLabel">Запрос №'.$rowsRequest['numLog'].' от '.date_format(new DateTime($rowsRequest['dateReq']),"d.m.Y").'</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body" id="reqInfoBody">
        <h6 class="display-6">Заявитель</h6>';

switch ($type) {
    case "FL":
        echo '<p class="ps-4">
              <b>ФИО:</b> '.$rowsRequest['name'].' <br>
              <b>Место жительства:</b> '.$rowsRequest['address'].' <br>
              <b>Дата рождения:</b> '.$rowsRequest['dateBirth'].' <br>
              <b>ДУЛ:</b> '.$rowsRequest['dulNum'].' от '.$rowsRequest['dulDate'].', выдан: '.$rowsRequest['dulOrg'].' <br>
              <b>Тел.:</b> '.$rowsRequest['tel'].' <b>Email:</b> '.$rowsRequest['email'].' 
              </p>';
        break;
    case "UL":
        echo '<p class="ps-4">
              <b>Наименование:</b> '.$rowsRequest['name'].' <br>
              <b>ИНН/ОГРН:</b> '.$rowsRequest['INN'].'/'.$rowsRequest['OGRN'].' <br>
              <b>Адрес местонахождения:</b> '.$rowsRequest['address'].' <br>
              <b>Тел.:</b> '.$rowsRequest['tel'].' <b>Email:</b> '.$rowsRequest['email'].' <br>
              <b>ФИО представителя:</b> '.$rowsRequest['aFIO'].' <b>Тел.:</b> '.$rowsRequest['aTel'].' <br>
              <b>Реквизиты доверенности:</b> '.$rowsRequest['dFLAgentDoc'].' <br>
              <b>Адрес проживания:</b> '.$rowsRequest['aAddress'].' <br>
              <b>ДУЛ:</b> '.$rowsRequest['aDulNum'].' от '.$rowsRequest['aDulDate'].', выдан: '.$rowsRequest['aDulOrg'].'
              </p>';
        break;
    case "OGV":
        echo '<p class="ps-4">
              <b>Наименование:</b> '.$rowsRequest['name'].' <br>
              <b>Исходящий № </b> '.$rowsRequest['senderNum'].' от '.$rowsRequest['senderDate'].'<br>
              <b>Номер СМЭВ:</b> '.$rowsRequest['smevNum'].'
              </p>';
        break;
}

if ($rowsRequest['realEstate']) {
  $realEstate = $rowsRequest['realEstate'];
} else {
  $realEstate = 'не указан';
}

if ($rowsRequest['Comment']) {
  $Comment = $rowsRequest['Comment'];
} else {
  $Comment = 'отсутствует';
}

echo '<h6 class="display-6">Запрос</h6>
        <p class="ps-4">
          <b>Объект:</b> '.$realEstate.' <br>
          <b>Комментарий:</b> '.$Comment.' <br>
          <b>Услуги:</b> '.preg_replace('/[0-9]+/', '<br>- ', $rowsSvc['svcConcat']).' <br>
          <b>Способ получения:</b> '.$rowsRequest['delivery'].'
        </p>';

if (getListAttachments($rowsRequest['attachList'])) {
  echo '<h6 class="display-6">Список приложений</h6>
        <p class="ps-4"><ul>'.getListAttachments($rowsRequest['attachList']).'</ul></p>';
}

if (getFileList($num)) {
  echo '<h6 class="display-6">Файлы приложений</h6>
        <p class="ps-4"><ul>'.getFileList($num).'</ul></p>';
}

echo '</div>';

$stmt = null;
$conn = null;
?>


