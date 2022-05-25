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
          <th data-field="realEstate" data-sortable="true" data-formatter="objFormatter">Объект запроса</th>
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
              <select class="form-select performer" id="performer" aria-label="Floating label select">
                <option selected>---</option>
                <option value="1">Батышева А.М.</option>
                <option value="2">Понамарёва К.С.</option>
                <option value="3">Гайнуллина М.И.</option>
                <option value="4">Задорожняя Э.О.</option>
                <option value="5">Кондратьева Н.В.</option>
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
        <th data-field="realEstate" data-sortable="true" data-formatter="objFormatter" >Объект запроса</th>
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
        <div class="col-md-2">
          <div class="form-floating">
            <input type="text" class="form-control" id="reqNumWork" name="reqNumWork" placeholder="Номер запроса" value="">
            <label for="reqNumWork">Номер запроса</label>
          </div>
        </div>  
        <div class="col-md-2">
          <div class="form-floating">
            <input type="Date" class="form-control" id="reqOutDate" name="reqOutDate" placeholder="Дата исходящего" value="" readonly>
            <label for="reqOutDate">Дата исходящего</label>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-floating">
            <select class="form-select performer" id="performerInWork" aria-label="Floating label select">
              <option selected>---</option>
                <option value="1">Батышева А.М.</option>
                <option value="2">Понамарёва К.С.</option>
                <option value="3">Гайнуллина М.И.</option>
                <option value="4">Задорожняя Э.О.</option>
                <option value="5">Кондратьева Н.В.</option>
            </select>
            <label for="performerInWork">Выберите исполнителя</label>
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Paid" class="btn btn-warning btn-lg">Оплачен</button>
          </div>
        </div>
        <div class="col-md-2">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="ShowReplyModal" class="btn btn-primary btn-lg">Ответить</button>
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Issue" class="btn btn-success btn-lg">Выдан</button>
          </div>
        </div>  
      </div>
</div>
    </div>

<div class="modal fade" id="reply" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="replyTitle"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <p id="replyText"></p>
        <div class="text-end">
          <span id="replyBtn"></span>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" id="answer" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="answerTitle"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <p id="answerText"></p>
        <div class="text-end">
          <span id="answerBtn"></span>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        </div>
      </div>      
    </div>
  </div>
</div>


<?php include "footer.php"; ?>
<script type="text/javascript" src="js/requests.js"></script>