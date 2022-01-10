<!doctype html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/utd.css">
    <link href="css/suggestions.min.css" rel="stylesheet" />
    <title>ИС УТД - Создать запрос</title>
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
          <li><a href="requests.php" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Запросы</a></li>
          <li><a href="new-request.php" class="nav-link px-2 link-secondary" mb-checked="1" data-tip="">Создать запрос</a></li>
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
      <h1 class="display-3 mb-3">Новый запрос №<span id="numTitle"></span></h1>
      <h6 class="display-6">Сведения о заявителе</h6>
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <select class="form-select" id="declarantType" aria-label="Floating label select">
              <option selected>---</option>
              <option value="FL">Физическое лицо</option>
              <option value="UL">Юридическое лицо</option>
              <option value="OGV">Орган государственной власти</option>
            </select>
            <label for="declarantType">Выберите вид заявителя</label>
          </div>
        </div>
      </div>  
      <div id="declarantFL" class="declarant">
        <form id="reqFL">
      <div class="row g-3 mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" name="agentFLSwitch" id="agentFLSwitch">
          <label class="form-check-label" for="agentFLSwitch">Представитель по доверенности</label>
        </div>                
      </div>    
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="dFLName" name="dFLName" placeholder="ФИО" value="">
            <label for="dFLName">ФИО заявителя</label>
          </div>
        </div>        
      </div>
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAddress" name="dFLAddress" placeholder="Адрес места жительства заявителя" value="">
            <label for="dFLAddress">Адрес места жительства заявителя</label>
          </div>
        </div> 
      </div> 
      <div id="agentFLForm" style="display: none;">
      <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dFLAgentName" name="dFLAgentName" placeholder="ФИО представителя" value="">
              <label for="dFLAgentName">ФИО представителя</label>
            </div>
          </div>
      </div>    
      <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dFLAgentDoc" name="dFLAgentDoc" placeholder="Реквизиты доверенности представителя" value="" data-bs-toggle="tooltip" data-bs-placement="left" title="Или иного документа, подтверждающего полномочия">
              <label for="dFLAgentDoc">Реквизиты доверенности представителя</label>
            </div>
          </div>
      </div>     
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAgentAddress" name="dFLAgentAddress" placeholder="Адрес места жительства представителя" value="">
            <label for="dFLAgentAddress">Адрес места жительства представителя</label>
          </div>
        </div> 
      </div>       
      </div>       
     
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="date" class="form-control" id="dFLBD" name="dFLBD" placeholder="Дата рождения" value="">
            <label for="dFLBD">Дата рождения</label>
          </div>
        </div>  
        <div class="col-md">
          <div class="form-floating">
            <input type="tel" class="form-control" id="dFLPhone" name="dFLPhone" placeholder="Контактный телефон" value="">
            <label for="dFLPhone">Контактный телефон</label>
          </div>
        </div>         
        <div class="col-md">
          <div class="form-floating">
            <input type="email" class="form-control" id="dFLEmail" name="dFLEmail" placeholder="name@example.com" value="">
            <label for="dFLEmail">Адрес эл. почты</label>
          </div>
        </div> 
      </div>
      <div class="row g-3 mb-3">
        <div class="col-md-2">
          <div class="form-floating" data-bs-toggle="tooltip" data-bs-placement="left" title="Серия и номер паспорта заявителя (представителя)">
            <input type="text" class="form-control" id="dFLNumDUL" name="dFLNumDUL" placeholder="Серия и номер ДУЛ" value="">
            <label for="dFLNumDUL">Серия и номер ДУЛ</label>
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating">
            <input type="Date" class="form-control" id="dFLDateDUL" name="dFLDateDUL" placeholder="Даты выдачи ДУЛ" value="">
            <label for="dFLDateDUL">Даты выдачи ДУЛ</label>
          </div>
        </div> 
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" class="form-control" id="dFLWhoDUL" name="dFLWhoDUL" placeholder="Кем выдан ДУЛ" value="">
            <label for="dFLWhoDUL">Кем выдан ДУЛ</label>
          </div>
        </div>                 
      </div>       
      </form>      
      </div>  
      <div id="declarantUL" class="declarant">
        <form id="reqUL">
        <div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULName" name="dULName" placeholder="Наименование юр. лица" value="">
              <label for="dULName">Наименование юр. лица</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULINN" name="dULINN" placeholder="ИНН" value="">
              <label for="dULINN">ИНН</label>
            </div>
          </div>
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULOGRN" name="dULOGRN" placeholder="ОГРН" value="">
              <label for="dULOGRN">ОГРН</label>
            </div>
          </div>                 
        </div> 
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control address" id="dULAddress" name="dULAddress" placeholder="Адрес местонахождения" value="">
              <label for="dULAddress">Адрес местонахождения</label>
            </div>
          </div>                  
        </div>    
        <div class="row g-2 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="dULEmail" name="dULEmail" placeholder="name@example.com" value="">
              <label for="dULEmail">Адрес эл. почты</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="tel" class="form-control" id="dULPhone" name="dULPhone" placeholder="Контактный телефон" value="">
              <label for="dULPhone">Контактный телефон</label>
            </div>
          </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULAgentName" name="dULAgentName" placeholder="ФИО представителя" value="">
              <label for="dULAgentName">ФИО представителя</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="tel" class="form-control" id="dULAgentPhone" name="dULAgentPhone" placeholder="Контактный телефон представителя" value="">
              <label for="dULAgentPhone">Контактный телефон представителя</label>
            </div>
          </div>
        </div>
      <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULAgentDoc" name="dULAgentDoc" placeholder="Реквизиты доверенности представителя" value="" data-bs-toggle="tooltip" data-bs-placement="left" title="Или иного документа, подтверждающего полномочия">
              <label for="dULAgentDoc">Реквизиты доверенности представителя</label>
            </div>
          </div>
      </div>        
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control address" id="dULAgentAddress" name="dULAgentAddress" placeholder="Адрес проживания представителя" value="">
              <label for="dULAgentAddress">Адрес проживания представителя</label>
            </div>
          </div>                  
        </div>        
      <div class="row g-3 mb-3">
        <div class="col-md-2">
          <div class="form-floating" data-bs-toggle="tooltip" data-bs-placement="left" title="Серия и номер паспорта заявителя (представителя)">
            <input type="text" class="form-control" id="dULNumDUL" name="dULNumDUL" placeholder="Серия и номер ДУЛ" value="">
            <label for="dULNumDUL">Серия и номер ДУЛ</label>
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating">
            <input type="Date" class="form-control" id="dULDateDUL" name="dULDateDUL" placeholder="Даты выдачи ДУЛ" value="">
            <label for="dULDateDUL">Даты выдачи ДУЛ</label>
          </div>
        </div> 
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" class="form-control" id="dULWhoDUL" name="dULWhoDUL" placeholder="Кем выдан ДУЛ" value="">
            <label for="dULWhoDUL">Кем выдан ДУЛ</label>
          </div>
        </div>                 
      </div>          
        </form>                  
      </div>
      <div id="declarantOGV" class="declarant">
        <form id="reqOGV">
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dOGVName" name="dOGVName" placeholder="Наименование ОГВ" value="">
              <label for="dOGVName">Наименование ОГВ</label>
            </div>
          </div>                   
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dOGVSenderNum" name="dOGVSenderNum" placeholder="Исходящий номер отправителя" value="">
              <label for="dOGVSenderNum">Исходящий номер отправителя</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="Date" class="form-control" id="dOGVSenderDate" name="dOGVSenderDate" placeholder="Дата исходящего отправителя" value="">
              <label for="dOGVSenderDate">Дата исходящего отправителя</label>
            </div>
          </div>
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="numSMEV" name="numSMEV" placeholder="Номер СМЭВ" value="">
              <label for="numSMEV">Номер СМЭВ</label>
            </div>
          </div>           
        </div>        
        </form>
      </div>   
      <h6 class="display-6">Сведения о запросе</h6>
      <form id="reqInfo">
      <div class="row g-2 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="reqNum" name="reqNum" placeholder="Регистрационный номер" value="">
            <label for="reqNum">Регистрационный номер</label>
          </div>
        </div>  
        <div class="col-md">
          <div class="form-floating">
            <input type="date" class="form-control" id="reqDate" name="reqDate" placeholder="Дата регистрации" value="">
            <label for="reqDate">Дата регистрации</label>
          </div>
        </div>
      </div> 
      <div class="row g-3 mb-3 d-none">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" name="likeAddress" id="likeAddress">
          <label class="form-check-label" for="likeAddress">Адрес совпадает с адресом места жительства</label>
        </div>                
      </div> 
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="reqObjAddress" name="reqObjAddress" placeholder="Адрес объекта недвижимости" value="">
            <label for="reqObjAddress">Адрес объекта недвижимости</label>
          </div>
        </div>  
      </div>      
      <div class="row g-1 mb-3">
        <div class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" id="reqComment" name="reqComment" style="height: 200px"></textarea>
          <label for="reqComment">Комментарий</label>
        </div> 
      </div>     
      <h6 class="display-6">Сведения об услуге</h6>
      <div class="row g-2 mb-3">
        <div class="col-md">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-1" name="svc-1">
            <label class="form-check-label" for="svc-1">
              Технический паспорт ОКС/помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-2" name="svc-2">
            <label class="form-check-label" for="svc-2">
              Поэтажный/ситуационный план
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-3" name="svc-3">
            <label class="form-check-label" for="svc-3">
              Экспликация поэтажного плана/ОКС/помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-4" name="svc-4">
            <label class="form-check-label" for="svc-4">
              УТД, содержащая сведения об инвентаризационной, восстановительной, балансовой или иной стоимости ОКС/помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-5" name="svc-5">
            <label class="form-check-label" for="svc-5">
              Проектно-разрешительная документация, техническое или экспертное заключение, или иная документация, содржащаяся в архиве
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-6" name="svc-6">
            <label class="form-check-label" for="svc-6">
              Правоустанавливающий документ, хранящийся в материалах инвентарного дела
            </label>
          </div>
        </div>
        <div class="col-md">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-7" name="svc-7">
            <label class="form-check-label" for="svc-7">
              Выписка из реестровой книги о праве собственности на ОКС/помещение
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-8" name="svc-8">
            <label class="form-check-label" for="svc-8">
              Справка, содержащая сведения об инвентаризационной стоимости ОКС
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-9" name="svc-9">
            <label class="form-check-label" for="svc-9">
              Справка, содержащая сведения об инвентаризационной стоимости помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-10" name="svc-10">
            <label class="form-check-label" for="svc-10">
              Справка, содержащая сведения о наличии (отсутствии) права собствености на объекты недвижимости (один правообладатель)
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-11" name="svc-11">
            <label class="form-check-label" for="svc-11">
              Справка, содержащая сведения о характеристиках объекта государственного учета
            </label>
          </div>
        </div>                
      </div>
      <h6 class="display-6">Способ получения копии/справки</h6>      
      <div class="row g-1 mb-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="smev" value="СМЭВ">
          <label class="form-check-label" for="smev">
            СМЭВ
          </label>
        </div>          
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="post" value="Почтовым отправление">
          <label class="form-check-label" for="post">
            Почтовым отправление
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="email" value="Электронной почтой">
          <label class="form-check-label" for="email">
            Электронной почтой
          </label>
        </div>      
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="foot" value="При личном обращении в КГБУ «КГКО»" checked>
          <label class="form-check-label" for="foot">
            При личном обращении в КГБУ "КГКО"
          </label>
        </div>           
      </div>  
      <h6 class="display-6">Перечень прилагаемых документов</h6>      
      <div class="row g-1 mb-3">
        <div class="col-md mb-1 attach">        
          <button type="button" class="btn btn-outline-secondary mb-1">Копия паспорта</button>
          <button type="button" class="btn btn-outline-secondary mb-1">Копия доверенности</button>
          <button type="button" class="btn btn-outline-secondary mb-1">Выписка из ЕГРН</button>
          <button type="button" class="btn btn-outline-secondary mb-1">Выписка из ЕГРЮЛ</button>
        </div>
        <div class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" id="attachList" name="attachList" style="height: 100px"></textarea>
          <label for="attachList">Перечень документов</label>
        </div>   
      </div> 
      </form>
     
      <div class="row g-2 mb-3">
        <div class="col-md mb-1">
          <button type="button" id="send" class="btn btn-primary btn-lg">Создать запрос</button>   
          <button type="button" id="clearForms" class="btn btn-secondary btn-lg">Сбросить</button>       
        </div>
      </div>
    </div>

<?php 

if (isset($_GET['toast'])) {



  echo '
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div class="toast bg-success text-white fade show" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">
        Запрос <a class="wlink" href="/tpl/form'.$_GET['decType'].'.php?numLog='.$_GET['toast'].'" target="_blank">№'.$_GET['toast'].'</a> создан.
      </div>
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
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script type="text/javascript" src="js/new-requests.js"></script>
    <script type="text/javascript" src="js/common.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.8.0/dist/js/jquery.suggestions.min.js"></script>    