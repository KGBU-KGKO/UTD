<?php
error_reporting(E_ALL);
include '../tpl/createForm.php';

$attachmentsList = '';
$attachments = explode(", ", $rowsRequest['attachList']);
foreach ($attachments as $attachment) {
    $attachmentsList = $attachmentsList.'<li><a href="'.'files/'.explode('/', $rowsRequest['numLog'])[1].'/" target="_blank">'.$attachment.'</a></li>';
}

echo '<div class="modal-header">
        <h5 class="modal-title" id="reqInfoLabel">Запрос №'.$rowsRequest['numLog'].' от '.date_format(new DateTime($rowsRequest['dateReq']),"d.m.Y").'</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body" id="reqInfoBody">
        <h6 class="display-6">Заявитель</h6>
        <p class="ps-4">
          <b>ФИО:</b> '.htmlspecialchars($rowsRequest['name']).' <br>
          <b>Место жительства:</b> '.$rowsRequest['address'].' <br>
          <b>Дата рождения:</b> '.$rowsRequest['dateBirth'].' <br>
          <b>ДУЛ:</b> '.$rowsRequest['dulNum'].' от '.$rowsRequest['dulDate'].', выдан: '.$rowsRequest['dulOrg'].' <br>
          <b>Тел.:</b> '.$rowsRequest['tel'].' <b>Email:</b> '.$rowsRequest['email'].' 
        </p>
        <h6 class="display-6">Запрос</h6>
        <p class="ps-4">
          <b>Объект:</b> '.$rowsRequest['realEstate'].' <br>
          <b>Комментарий:</b> '.$rowsRequest['Comment'].' <br>
          <b>Услуги:</b> '.preg_replace('/[0-9]+/', '<br>- ', $rowsSvc['svcConcat']).' <br>
          <b>Способ получения:</b> '.$rowsRequest['delivery'].'
        </p>        
        <h6 class="display-6">Приложения</h6>
        <p class="ps-4">
          <ul>'.$attachmentsList.'</ul>             
        </p>
      </div>';

$stmt = null;
$conn = null;
?>


