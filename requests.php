  <?php include "header.php"; ?>
  <body>
    <div class="container mb-5">
<div id="newReqData">
  <h6 class="display-6">Новые запросы</h6>
  <div class="newRequests">
    <div class="mb-4" >
      <table id="newReqTable" class="table table-hover"   
        data-search="true"
        data-show-columns="true"
        data-custom-sort="customSort"
        data-page-list="[10, 25, 50, 100, all]">
          <thead>
        <tr>
          <th data-field="num" data-sortable="true" data-formatter="numFormatter">№ запроса</th>
          <th data-field="declarant" data-sortable="true" data-formatter="typeFormatter" >Тип</th>
          <th data-field="declarant" data-sortable="true" data-formatter="decFormatter">Заявитель</th>
          <th data-field="realEstate" data-sortable="true" >Объект запроса</th>
          <th data-field="svc" data-sortable="true" >Услуга</th>
        </tr>
      </thead>
      </table>
    </div>  
        <h3>Взять запрос в работу</h3>
        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <div class="form-floating">
              <input type="text" class="form-control" id="reqNumNew" name="reqNumNew" placeholder="Регистрационный номер" value="">
              <label for="reqNumNew">Регистрационный номер</label>
            </div>
          </div>  
         <div class="col-md-3">
            <div class="form-floating">
              <select class="form-select" id="performer" aria-label="Floating label select">
                <option selected>---</option>
                <option value="1">Батышева А.М.</option>
                <option value="2">Понамарёва К.С.</option>
                <option value="3">Кондратьева Н.В.</option>
                <option value="4">Захарова Е.А.</option>
              </select>
              <label for="performer">Выберите исполнителя</label>
            </div>
          </div> 
          <div class="col-md-3">
            <div class="form-floating d-grid gap-2 mx-auto">
              <button style="height: 58px;" type="button" id="inWork" class="btn btn-primary btn-lg">Взять в работу</button>
            </div>
          </div>   
          <div class="col-md-3">
            <div class="form-floating d-grid gap-2 mx-auto">
              <button style="height: 58px;" type="button" id="printList" class="btn btn-success btn-lg">Печать реестра</button>
            </div>
          </div>                             
        </div> 
  </div>
</div>
<div id="newReqDataEmpty" class="d-none">
  <div id="noForUpload" class="bd-callout bd-callout-info">
    Нет новых запросов
  </div>
</div>
<h6 class="display-6 mt-5">Запросы в работе</h6>     

<div id="toolbar" class="row">
  <div class="col mt-2">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" name="onlyDelivery" id="onlyDelivery">
        <label class="form-check-label" for="onlyDelivery">На выдачу</label>
      </div>                
  </div>
</div>

<div class="newRequests">
  <div class="mb-4" >
    <table id="inworkReqTable" class="table table-hover"   
    data-search="true"
    data-show-columns="true"
    data-custom-sort="customSort"
    data-toolbar="#toolbar"
    data-page-list="[10, 25, 50, 100, all]">
        <thead>
      <tr>
        <th data-field="num" data-sortable="true" data-formatter="numFormatter">№ запроса</th>
        <th data-field="declarant" data-sortable="true" data-formatter="typeFormatter">Тип</th>
        <th data-field="declarant" data-sortable="true" data-formatter="decFormatter">Заявитель</th>
        <th data-field="realEstate" data-sortable="true" >Объект запроса</th>
        <th data-field="svc" data-sortable="true" >Услуга</th>
        <th data-field="status" data-sortable="true" >Статус</th>
        <th data-field="performer" data-sortable="true" data-formatter="perfFormatter">Исполнитель</th>
        <th data-field="datePay" data-sortable="true" data-formatter="payFormatter">Оплата</th>
        <th data-field="date" data-sortable="true" >Дата рег.</th>
        <th data-field="dateDue" data-sortable="true" data-formatter="deadlineFormatter">Дата испол.</th>
      </tr>
    </thead>
    </table>
  </div>  
      <h3>Закрыть запрос</h3>
      <div class="row g-3 mb-3">
        <div class="col-md-3">
          <div class="form-floating">
            <input type="text" class="form-control" id="reqNumWork" name="reqNumWork" placeholder="Номер запроса" value="">
            <label for="reqNumWork">Номер запроса</label>
          </div>
        </div>  
        <div class="col-md-3">
          <div class="form-floating">
            <input type="Date" class="form-control" id="reqOutDate" name="reqOutDate" placeholder="Дата исходящего" value="" readonly>
            <label for="reqOutDate">Дата исходящего</label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating">
            <select class="form-select" id="performerInWork" aria-label="Floating label select">
              <option selected>---</option>
              <option value="1">Батышева А.М.</option>
              <option value="2">Понамарёва К.С.</option>
              <option value="3">Кондратьева Н.В.</option>
              <option value="4">Захарова Е.А.</option>
            </select>
            <label for="performerInWork">Выберите исполнителя</label>
          </div>
        </div>    
      </div>
      <div class="row g-3 mb-3">           
        <div class="col-md-3">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Paid" class="btn btn-warning btn-lg">Оплачен</button>
          </div>
        </div>      
        <div class="col-md-3">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Cancel" class="btn btn-danger btn-lg">Отказ</button>
          </div>
        </div> 
        <div class="col-md-3">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Answer" class="btn btn-success btn-lg">Ответ</button>
          </div>
        </div> 
        <div class="col-md-3">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Issue" class="btn btn-success btn-lg">Выдан</button>
          </div>
        </div>                                    
      </div> 
</div>
    </div>

<div class="modal fade" id="notify" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Информация</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <p id="txtInfo"></p>
        <div class="text-end"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Понятно</button></div>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="denyСopies" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Отказ в предоставлении данных на запрос №<span id="denyСopiesNum"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <form id="denyСopiesModalForm">
          <h6 class="display-6">Укажите причину отказа</h6>
          <div class="row g-1 mb-3">
            <div class="col-md">
              <div class="form-floating">
                <select class="form-select" id="denyTxtSelect" aria-label="Floating label select">
                  <option selected>---</option>
                  <option value="1">отсутствием инвентарного дела</option>
                  <option value="2">ОГВ прислал не по СМЭВ</option>
                  <option value="3">нет сведений в инвентарном деле</option>
                  <option value="4">невозможно идентифицировать объект</option>
                </select>
                <label for="denyTxtSelect">Выберите шаблон причины отказа</label>
              </div>
            </div>
          </div> 
          <div class="row g-1 mb-3">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Leave a comment here" id="denyTxt" name="denyTxt" style="height: 200px"></textarea>
              <label for="denyTxt">Причина отказа на запрос</label>
            </div> 
          </div> 
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
            <button type="button" class="btn btn-danger" id="denyReq">Да, отказать</button>          
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="infoRef" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Текст справки/выписки по запросу №<span id="infoRefNum"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <form id="infoRefModalForm">
          <div class="row g-1 mb-3">
            <div class="form-floating">
              <textarea class="form-control" placeholder="Leave a comment here" id="textRef" name="denyTxt" style="height: 200px"></textarea>
              <label for="textRef">Укажите текст справки/выписки</label>
            </div> 
          </div> 
          <div class="text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
            <button type="button" class="btn btn-success" id="createRef">Сформировать справку</button>          
          </div>
        </form>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="reply" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">В запросе №<span id="replyNumTitle">02-22/0117</span> найдено несколько услуг</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <h5 class="mb-3">Укажите резолюцию по каждой услуге запроса:</h5>
        <div id="replyBody"></div>
        <div class="text-end mt-3">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
          <button type="button" class="btn btn-success" id="multiReply">Подтвердить</button>          
        </div>
      </div>      
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
<script type="text/javascript" src="js/requests.js"></script>