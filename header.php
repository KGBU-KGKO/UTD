<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-table/bootstrap-table.min.css">
    <link rel="stylesheet" type="text/css" href="lib/jquery/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="lib/suggestions/suggestions.min.css">
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
          <input id="gSearch" type="search" class="form-control" placeholder="Поиск..." aria-label="Search">
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