<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="css/utd.css">
    <title>ИС УТД - Запросы</title>
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  </head>
<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none" mb-checked="1" data-tip="" style="margin-right: 20px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
            <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
          </svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="/" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Инф. панель 
            <span class="badge bg-danger"><?php 
              include 'data/config.php';
              $query = "select count(*) as count from request where status = 'Ожидает загрузки'";

              $stmt = $conn->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
              $stmt->execute();
              $res = $stmt->fetch(PDO::FETCH_ASSOC);
              if ($res['count'] != '0') {
                echo $res['count'];                
              }
              $stmt = null;
              $conn = null;
              ?></span></a></li>
          <li><a href="requests.php" class="nav-link px-2 link-secondary" mb-checked="1" data-tip="">Запросы</a></li>
          <li><a href="new-request.php" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Создать запрос</a></li>
        </ul>

        <form class="col-12 col-lg-auto w-50 mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control" placeholder="Поиск..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" mb-checked="1" data-tip="">
            <img src="img/avatar/2624892_deadpool_marvel_super hero_hero.svg" alt="mdo" width="64" height="64" class="rounded-circle"> Батышева А.М.
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">New project...</a></li>
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">Settings</a></li>
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">Выйти</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <body>
    <div class="container mb-5">
<div id="newReqData">
  <h6 class="display-6">Новые запросы</h6>
  <div class="newRequests">
    <div class="mb-4" >
      <table id="newReqTable" class="table table-hover"   
        data-show-columns="true"
        data-custom-sort="customSort"
        data-page-list="[10, 25, 50, 100, all]">
          <thead>
        <tr>
          <th data-field="reqNum" data-sortable="true" data-formatter="numFormatter">№ запроса</th>
          <th data-field="type" data-sortable="true" >Тип</th>
          <th data-field="name" data-sortable="true" >Заявитель</th>
          <th data-field="objAddress" data-sortable="true" >Объект запроса</th>
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

<div class="newRequests">
  <div class="mb-4" >
    <table id="inworkReqTable" class="table table-hover"   
    data-show-columns="true"
    data-custom-sort="customSort"
    data-page-list="[10, 25, 50, 100, all]">
        <thead>
      <tr>
        <th data-field="reqNum" data-sortable="true" data-formatter="numFormatter">№ запроса</th>
        <th data-field="type" data-sortable="true" >Тип</th>
        <th data-field="name" data-sortable="true" >Заявитель</th>
        <th data-field="objAddress" data-sortable="true" >Объект запроса</th>
        <th data-field="svc" data-sortable="true" >Услуга</th>
        <th data-field="status" data-sortable="true" >Статус</th>
        <th data-field="performer" data-sortable="true" >Исполнитель</th>
        <th data-field="datePay" data-sortable="true" data-formatter="payFormatter">Оплата</th>
        <th data-field="dateDue" data-sortable="true" data-formatter="deadlineFormatter">Дата исполнения</th>
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

<div class="modal fade" id="reqInfo" tabindex="-1" aria-labelledby="reqInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" id="reqInfoContent">
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

<div class="modal fade" id="deny" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Отказ в предоставлении данных на запрос №<span id="denyNum"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <h6 class="display-6">Укажите причину отказа</h6>
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <select class="form-select" id="denyTxtSelect" aria-label="Floating label select">
                <option selected>---</option>
                <option value="1">отсутствием инвентарного дела</option>
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

  </body>
</html>
    <script type="text/javascript" src="lib/bootstrap/bootstrap.bundle.min.js" ></script>
    <script type="text/javascript" src="lib/jquery/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="lib/bootstrap-table/bootstrap-table.min.js"></script>
    <script type="text/javascript" src="lib/bootstrap-table/bootstrap-table-ru-RU.min.js" ></script>  
    <script type="text/javascript" src="js/requests.js"></script>
    <script type="text/javascript" src="js/common.js"></script>       