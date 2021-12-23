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
            <span class="badge bg-danger">4</span>
          </a></li>  
          <li><a href="requests.php" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Запросы</a></li>
          <li><a href="new-request.php" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Создать запрос</a></li>
        </ul>

        <form class="col-12 col-lg-auto w-50 mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false" mb-checked="1" data-tip="">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">New project...</a></li>
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">Settings</a></li>
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" mb-checked="1" data-tip="">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <body>
    <div class="container mb-5">
      <h6 class="display-6">Информационная панель</h6>

<div class="bd-callout bd-callout-danger">
<h4 id="asynchronous-methods-and-transitions">Загрузите файлы в данные запросы</h4>
<p>Сначала укажите запрос для загрузки файлов, после чего с помощью кнопки "Выберите файлы" укажите файлы, которые относятся к данному запросу и нажмите кнопку "Загрузить файлы". После успешной загрузки вы увидите уведомление, а запрос больше не будет отображаться в таблице.</p>
</div>
      <div class="bd-example">
        <table class="table table-hover">
            <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td colspan="2">Larry the Bird</td>
            <td>@twitter</td>
          </tr>          
        </tbody>

        </table>
      </div>
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
      <div class="row g-1 mb-3">
        <div class="mb-3">
          <label for="nameFiles" class="form-label">Список файлов для загрузки:</label>
          <div id="nameFiles"></div>
        </div>  
      </div> 

      <div class="row g-2 mb-3">
        <div class="col-md mb-1">
          <button type="button" id="upload" class="btn btn-primary btn-lg">Загрузить файлы</button>   
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
  </body>
</html>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://getbootstrap.com/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/dashboard.js"></script>