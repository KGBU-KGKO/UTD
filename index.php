<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/utd.css">
    <title>ИС УТД - Инф. панель</title>
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
          <li><a href="/" class="nav-link px-2 link-secondary" mb-checked="1" data-tip="">Инф. панель 
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
          <li><a href="requests.php" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Запросы</a></li>
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
      <th data-field="reqNum" data-sortable="true" data-formatter="numFormatter">№ запроса</th>
      <th data-field="type" data-sortable="true" >Тип</th>
      <th data-field="name" data-sortable="true" >Заявитель</th>
      <th data-field="objAddress" data-sortable="true" >Объект запроса</th>
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
    <div class="col-md-2 mb-1">
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
                    <span class="h2 mb-0 card-head">
                      20
                    </span>

                    <!-- Badge -->
                    <span class="badge bg-success mt-n1">
                      +10 сегодня
                    </span>
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
                    <span class="h2 mb-0 card-head">
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
                    <span class="h2 mb-0 card-head">
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
                    <span class="h2 mb-0 card-head">
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
        <canvas id="line-chart" height="350"></canvas>
</div>

<div class="row mb-3">
  <h6 class="display-6">Сформировать журналы</h6>
  <div class="row g-3">
    <div class="col-md-3">
      <div class="form-floating">
        <input type="Date" class="form-control" id="inDate" name="inDate" placeholder="Укажите дату" value="">
        <label for="inDate">Укажите дату</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-floating">
        <input type="text" class="form-control" id="inNum" name="inNum" placeholder="Укажите номер запроса" value="">
        <label for="inNum">Укажите номер запроса</label>
      </div>
    </div>      
    <div class="col-md-3">
      <div class="form-floating d-grid gap-2 mx-auto">
        <button style="height: 58px;" type="button" id="printIn" class="btn btn-success btn-lg">Печать входящего журнала</button>
      </div>
    </div>                             
  </div> 
  <div class="row g-3 mb-3">
    <div class="col-md-3">
      <div class="form-floating">
        <input type="Date" class="form-control" id="outDate" name="outDate" placeholder="Укажите дату" value="">
        <label for="outDate">Укажите дату</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="form-floating">
        <input type="text" class="form-control" id="outNum" name="outNum" placeholder="Укажите номер запроса" value="">
        <label for="outNum">Укажите номер запроса</label>
      </div>
    </div>    
    <div class="col-md-3">
      <div class="form-floating d-grid gap-2 mx-auto">
        <button style="height: 58px;" type="button" id="printOut" class="btn btn-success btn-lg">Печать исходящего журнала</button>
      </div>
    </div>                             
  </div>           
</div>

<div style="display: none;" id="toast" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
<div class="toast bg-success text-white fade show" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body">
      Привет, мир! Это тост-сообщение.
    </div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
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

<?php 

if (isset($_GET['success'])) {
  $text = $_GET['success'];
  $class = 'success';
} 

if (isset($_GET['error'])) {
  $text = $_GET['error'];
  $class = 'danger';
} 

if (isset($_GET['success']) || isset($_GET['error'])) {
  echo '
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div class="toast bg-'.$class.' text-white fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">'.$text.'</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Закрыть"></button>
    </div>
  </div>
  </div>';
}

?>    
  </body>
</html>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.19.1/locale/bootstrap-table-ru-RU.min.js" integrity="sha512-VWiWx34Bykw/3DL8PNzXeMvGKA9osnJ4Hf9uplXFNa2ln+YS3Swup4K8SdHzFxVPYlf1r2B/OpPVWsG2pfmenA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script type="text/javascript" src="js/dashboard.js"></script>
    <script type="text/javascript" src="js/common.js"></script>    