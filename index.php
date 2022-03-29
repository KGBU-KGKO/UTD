<?php include "header.php"; ?>
  <body>
    <div class="container mb-5">
      <h6 class="display-6">Информационная панель</h6>
<?php 
if ($res['count'] != '0') {
  echo '<div id="reqForUpload" class="mb-5">
  <div class="bd-callout bd-callout-danger">
  <h4 id="asynchronous-methods-and-transitions">Загрузите файлы в данные запросы</h4>
  <p>Сначала укажите запрос для загрузки файлов, после чего с помощью кнопки "Выберите файлы" укажите файлы, которые относятся к данному запросу и нажмите кнопку "Загрузить файлы". После успешной загрузки вы увидите уведомление, а запрос больше не будет отображаться в таблице.</p>
  </div>
<div class="mb-4" >
  <table id="uploadTable" class="table table-hover"   
  data-show-columns="true"
  data-custom-sort="customSort"
  data-page-list="[10, 25, 50, 100, all]">
      <thead>
    <tr>
      <th data-field="num" data-sortable="true" data-formatter="numFormatter">№ запроса</th>
      <th data-field="declarant" data-sortable="true" data-formatter="typeFormatter">Тип</th>
      <th data-field="declarant" data-sortable="true" data-formatter="decFormatter">Заявитель</th>
      <th data-field="realEstate" data-sortable="true" >Объект запроса</th>
      <th data-field="svc" data-sortable="true" >Услуга</th>
    </tr>
  </thead>
  </table>
</div>
<div>
  <form id="formFiles" enctype="multipart/form-data">
  <div class="row g-1 mb-3">
    <div class="col-md">
      <div class="form-floating">
        <input type="text" class="form-control" id="numReq" name="numReq" placeholder="Укажите запрос в таблице" value="">
        <label for="numReq">Укажите запрос в таблице</label>
      </div>
    </div>        
  </div>
  <div class="row g-1 mb-1">
    <div class="mb-3">
      <label for="reqFiles" class="form-label">Загрузите файлы приложений</label>
      <input class="form-control form-control-lg" type="file" id="reqFiles" name="reqFiles" multiple>
    </div>  
  </div>
  </form>
  <div class="row g-1">
    <div class="mb-3">
      <label for="nameFiles" class="form-label">Список файлов для загрузки:</label>
      <div id="nameFiles"></div>
    </div>  
  </div> 

  <div class="row g-2 mb-3">
    <div class="col-md-2 mb-1">
      <button type="button" id="upload" class="btn btn-primary btn-lg">Загрузить файлы</button>   
    </div>
    <div class="col-md-2 mb-1 align-self-center">
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" role="switch" name="isPaid" id="isPaid">
        <label class="form-check-label" for="isPaid">Запрос оплачен</label>
      </div>                
    </div>   
    <div class="col-md mb-1 text-end">
      <button type="button" id="remove" class="btn btn-danger btn-lg">Удалить запрос</button>   
    </div>    
  </div>
  </div>
</div>';   
} else {
  echo '<div id="noForUpload" class="bd-callout bd-callout-info">
  Нет запросов для загрузки файлов
</div>';
}
?>      

<div class="row mb-3">
          <div class="col-12 col-lg-6 col-xl">

            <!-- Value  -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center gx-0">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="text-uppercase text-muted mb-2 card-title">
                      Запросов поступило
                    </h6>

                    <!-- Heading -->
                    <div>
                      <span class="h2 card-head align-middle" id="reqAll">
                        20
                      </span>

                    <!-- Badge -->
                      <span class="badge bg-success align-middle" id="reqToday">
                       +10 сегодня
                      </span>
                    </div>
                    
                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <i class="h2 bi bi-activity text-muted mb-0"></i>

                  </div>
                </div> <!-- / .row -->
              </div>
            </div>

          </div>
          <div class="col-12 col-lg-6 col-xl">

            <!-- Hours -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center gx-0">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="text-uppercase text-muted mb-2 card-title">
                      Запросов в работе
                    </h6>

                    <!-- Heading -->
                    <span class="h2 mb-0 card-head" id="inWork">
                      19
                    </span>

                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <i class="bi bi-arrow-repeat h2 text-muted mb-0"></i>

                  </div>
                </div> <!-- / .row -->
              </div>
            </div>

          </div>
          <div class="col-12 col-lg-6 col-xl">

            <!-- Exit -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center gx-0">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="text-uppercase text-muted mb-2 card-title">
                      Обработано с нарушением срока, %
                    </h6>

                    <!-- Heading -->
                    <span class="h2 mb-0 card-head" id="exp">
                      0.10
                    </span>

                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <i class="bi bi-graph-up h2 text-muted mb-0"></i>

                  </div>
                </div> <!-- / .row -->
              </div>
            </div>

          </div>
          <div class="col-12 col-lg-6 col-xl">

            <!-- Time -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center gx-0">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="text-uppercase text-muted mb-2 card-title">
                      Среднее время обработки запроса, ч
                    </h6>

                    <!-- Heading -->
                    <span class="h2 mb-0 card-head" id="time">
                      2:37
                    </span>

                  </div>
                  <div class="col-auto">

                    <!-- Icon -->
                    <i class="bi bi-stopwatch h2 text-muted mb-0"></i>

                  </div>
                </div> <!-- / .row -->
              </div>
            </div>

          </div>
        </div>

        <!-- Line chart -->
<div class="row mb-3">
  <h6 class="display-6">Поступление за неделю</h6>
  <div class="row justify-content-md-end mb-2">
    <div class="col-md-2">
      <div class="form-floating d-grid gap-2 mx-auto">
        <button type="button" id="first-chart-filter" class="btn btn-primary">Фильтр</button>
      </div>
    </div>    
    <div class="col-md-2">        
      <input class="form-control" id="first-chart-date-from" type="date" placeholder="from" aria-label="date from">  
    </div>    
    <div class="col-md-2">        
      <input class="form-control" id="first-chart-date-to" type="date" placeholder="to" aria-label="date to">  
    </div>
    <div class="btn-group col-3" role="group" aria-label="Basic radio toggle button group">
      <input type="radio" class="btn-check" name="first-chart-btnradio" id="first-chart-btnradio1" autocomplete="off" checked>
      <label class="btn btn-outline-primary" for="first-chart-btnradio1">Неделя</label>

      <input type="radio" class="btn-check" name="first-chart-btnradio" id="first-chart-btnradio2" autocomplete="off">
      <label class="btn btn-outline-primary" for="first-chart-btnradio2">Месяц</label>

      <input type="radio" class="btn-check" name="first-chart-btnradio" id="first-chart-btnradio3" autocomplete="off">
      <label class="btn btn-outline-primary" for="first-chart-btnradio3">Квартал</label>      

      <input type="radio" class="btn-check" name="first-chart-btnradio" id="first-chart-btnradio4" autocomplete="off">
      <label class="btn btn-outline-primary" for="first-chart-btnradio4">Год</label>
    </div>
  </div>
  <canvas id="first-chart" height="350"></canvas>
</div>

<div class="row mb-3">
  <h6 class="display-6">Количество запросов по видам</h6>
  <div class="row justify-content-md-end mb-2">
    <div class="col-md-2">
      <div class="form-floating d-grid gap-2 mx-auto">
        <button type="button" id="second-chart-filter" class="btn btn-primary">Фильтр</button>
      </div>
    </div>    
    <div class="col-md-2">        
      <input class="form-control" id="second-chart-date-from" type="date" placeholder="from" aria-label="date from">  
    </div>    
    <div class="col-md-2">        
      <input class="form-control" id="second-chart-date-to" type="date" placeholder="to" aria-label="date to">  
    </div>
    <div class="btn-group col-3" role="group" aria-label="Basic radio toggle button group">
      <input type="radio" class="btn-check" name="second-chart-btnradio" id="second-chart-btnradio1" autocomplete="off" checked>
      <label class="btn btn-outline-primary" for="second-chart-btnradio1">Неделя</label>

      <input type="radio" class="btn-check" name="second-chart-btnradio" id="second-chart-btnradio2" autocomplete="off">
      <label class="btn btn-outline-primary" for="second-chart-btnradio2">Месяц</label>

      <input type="radio" class="btn-check" name="second-chart-btnradio" id="second-chart-btnradio3" autocomplete="off">
      <label class="btn btn-outline-primary" for="second-chart-btnradio3">Квартал</label>      

      <input type="radio" class="btn-check" name="second-chart-btnradio" id="second-chart-btnradio4" autocomplete="off">
      <label class="btn btn-outline-primary" for="second-chart-btnradio4">Год</label>
    </div>
  </div> 
  <canvas id="second-chart" height="350"></canvas>
</div>

<div class="row mb-3">
  <h6 class="display-6">Количество исполненных запросов</h6>
  <div class="row justify-content-md-end mb-2">
    <div class="col-md-2">
      <div class="form-floating d-grid gap-2 mx-auto">
        <button type="button" id="third-chart-filter" class="btn btn-primary">Фильтр</button>
      </div>
    </div>    
    <div class="col-md-2">        
      <input class="form-control" id="third-chart-date-from" type="date" placeholder="from" aria-label="date from">  
    </div>    
    <div class="col-md-2">        
      <input class="form-control" id="third-chart-date-to" type="date" placeholder="to" aria-label="date to">  
    </div>
    <div class="btn-group col-3" role="group" aria-label="Basic radio toggle button group">
      <input type="radio" class="btn-check" name="third-chart-btnradio" id="third-chart-btnradio1" autocomplete="off" checked>
      <label class="btn btn-outline-primary" for="third-chart-btnradio1">Неделя</label>

      <input type="radio" class="btn-check" name="third-chart-btnradio" id="third-chart-btnradio2" autocomplete="off">
      <label class="btn btn-outline-primary" for="third-chart-btnradio2">Месяц</label>

      <input type="radio" class="btn-check" name="third-chart-btnradio" id="third-chart-btnradio3" autocomplete="off">
      <label class="btn btn-outline-primary" for="third-chart-btnradio3">Квартал</label>      

      <input type="radio" class="btn-check" name="third-chart-btnradio" id="third-chart-btnradio4" autocomplete="off">
      <label class="btn btn-outline-primary" for="third-chart-btnradio4">Год</label>
    </div>
  </div>         
  <canvas id="third-chart" height="350"></canvas>
</div>

<div class="row mb-3">
  <h6 class="display-6">Сформировать журнал</h6>
  <div class="row g-3">
    <div class="col-md-3">
      <div class="form-floating">
        <input type="Date" class="form-control" id="logDate" name="logDate" placeholder="Укажите дату" value="">
        <label for="logDate">Укажите дату начала</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-floating">
        <input type="text" class="form-control" id="logNum" name="logNum" placeholder="Укажите номер запроса" value="0001">
        <label for="logNum">Укажите номер запроса</label>
      </div>
    </div> 
    <div class="col-md-3">
      <div class="form-floating">
        <select class="form-select" id="logType" aria-label="Floating label select">
          <option value="in" selected>Входящий журнал</option>
          <option value="out">Исходящий журнал</option>
        </select>
        <label for="logType">Выберите вид заявителя</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-floating d-grid gap-2 mx-auto">
        <button style="height: 58px;" type="button" id="printIn" class="btn btn-success btn-lg">Печать журнала</button>
      </div>
    </div>                             
  </div> 
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="notifyToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="10000">
    <div class="d-flex">
      <div id="notifyToastBody" class="toast-body"></div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

</div>

<div class="modal fade" id="removeAlert" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" id="removeAlertContent">
<div class="modal-header">
        <h5 class="modal-title">Подтвердите удаление запроса</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
</div>
<div class="modal-body" id="removeAlertBody">
<p>Ты уверена, что хочешь удалить запрос №<span id="numForDelete"></span>?</p>
</div>      
<div class="modal-footer">
  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
  <button type="button" class="btn btn-danger" id="deleteReq">Да, удалить</button>
</div>
    </div>
  </div>
</div>  

<?php include "footer.php"; ?>
<script type="text/javascript" src="lib/chart/Chart.min.js"></script>
<script type="text/javascript" src="js/dashboard.js"></script>
   