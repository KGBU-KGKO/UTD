<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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
      <h6 class="display-6">Новые запросы</h6>

<div class="newRequests">
  <table class="table table-hover">
      <thead>
    <tr>
      <th scope="col">№ запроса</th>
      <th scope="col">Заявитель</th>
      <th scope="col">Объект недвижимости</th>
      <th scope="col">Вид услуги</th>
    </tr>
  </thead>
  <tbody id="newReqTable">
  </tbody>
  </table>
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

      <h6 class="display-6 mt-5">Запросы в работе</h6>

<div class="newRequests">
  <table class="table table-hover">
      <thead>
    <tr>
      <th scope="col">№ запроса</th>
      <th scope="col">Заявитель</th>
      <th scope="col">Объект недвижимости</th>
      <th scope="col">Вид услуги</th>
      <th scope="col">Исполнитель</th>
      <th scope="col">Дата исполнения</th>
    </tr>
  </thead>
  <tbody id="inworkReqTable">
  </tbody>

  </table>
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
            <input type="text" class="form-control" id="reqOutNum" name="reqOutNum" placeholder="Исходящий рег. номер" value="">
            <label for="reqOutNum">Исходящий рег. номер</label>
          </div>
        </div>   
        <div class="col-md-3">
          <div class="form-floating">
            <input type="Date" class="form-control" id="reqOutDate" name="reqOutDate" placeholder="Дата исходящего" value="">
            <label for="reqOutDate">Дата исходящего</label>
          </div>
        </div>                
        <div class="col-md-3">
          <div class="form-floating d-grid gap-2 mx-auto">
            <button style="height: 58px;" type="button" id="Complete" class="btn btn-success btn-lg">Закрыть запрос</button>
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

  </body>
</html>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/requests.js"></script>
    <script type="text/javascript" src="js/common.js"></script>       