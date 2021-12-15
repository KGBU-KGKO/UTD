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
    <title>ИС УТД</title>
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
          <li><a href="#" class="nav-link px-2 link-secondary" mb-checked="1" data-tip="">Создать запрос</a></li>
          <li><a href="#" class="nav-link px-2 link-dark" mb-checked="1" data-tip="">Перечень УТД</a></li>
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
      <h1 class="display-3 mb-3">Новый запрос <span>№004132</span></h1>
      <h6 class="display-6">Сведения о заявителе</h6>
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <select class="form-select" id="declarantType" aria-label="Floating label select">
              <option selected>---</option>
              <option value="ФЛ">Физическое лицо</option>
              <option value="ЮЛ">Юридическое лицо</option>
              <option value="ОГВ">Орган государственной власти</option>
            </select>
            <label for="declarantType">Выберите вид заявителя</label>
          </div>
        </div>
      </div>  
      <div id="declarantFL" class="declarant">
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="dFLName" placeholder="ФИО" value="">
            <label for="dFLName">ФИО</label>
          </div>
        </div>        
      </div>
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="date" class="form-control" id="dFLBD" placeholder="Дата рождения" value="">
            <label for="dFLBD">Дата рождения</label>
          </div>
        </div>  
        <div class="col-md">
          <div class="form-floating">
            <input type="tel" class="form-control" id="dFLPhone" placeholder="Контактный телефон" value="">
            <label for="dFLPhone">Контактный телефон</label>
          </div>
        </div>         
        <div class="col-md">
          <div class="form-floating">
            <input type="email" class="form-control" id="dFLEmail" placeholder="name@example.com" value="">
            <label for="dFLEmail">Адрес эл. почты</label>
          </div>
        </div> 
      </div>
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="dFLAddress" placeholder="Адрес места жительства" value="">
            <label for="dFLAddress">Адрес места жительства</label>
          </div>
        </div> 
      </div>
      <div class="row g-3 mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" name="agentFLSwitch" id="agentFLSwitch">
          <label class="form-check-label" for="agentFLSwitch">Представитель по доверенности</label>
        </div>                
      </div>  
      <div id="agentFLForm" style="display: none;">
        <h6 class="display-6">Сведения о представителе</h6>
        <div class="row g-2 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dFLAgentName" placeholder="ФИО представителя" value="">
              <label for="dFLAgentName">ФИО представителя</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="tel" class="form-control" id="dFLAgentPhone" placeholder="Контактный телефон" value="">
              <label for="dFLAgentPhone">Контактный телефон</label>
            </div>
          </div>         
        </div>        
      </div>        
      </div>  
      <div id="declarantUL" class="declarant">
        <div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">Наименование юр. лица</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">ИНН</label>
            </div>
          </div>
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">ОГРН</label>
            </div>
          </div>                 
        </div> 
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">Адрес местонахождения</label>
            </div>
          </div>                  
        </div>    
        <div class="row g-2 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">Адрес эл. почты</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">Контактный телефон</label>
            </div>
          </div>
        </div>
        <div class="row g-2 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">ФИО представителя</label>
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" value="">
              <label for="floatingInputGrid">Контактный телефон представителя</label>
            </div>
          </div>
        </div>                    
      </div>
      <div id="declarantOGV" class="declarant">
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dOGVName" placeholder="Наименование ОГВ" value="">
              <label for="dOGVName">Наименование ОГВ</label>
            </div>
          </div>                   
        </div>
      </div>   
      <h6 class="display-6">Сведения о запросе</h6>
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="reqNum" placeholder="Регистрационный номер" value="">
            <label for="reqNum">Регистрационный номер</label>
          </div>
        </div>  
        <div class="col-md">
          <div class="form-floating">
            <input type="date" class="form-control" id="reqDate" placeholder="Дата регистрации" value="">
            <label for="reqDate">Дата регистрации</label>
          </div>
        </div>
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="numSMEV" placeholder="Номер СМЭВ" value="">
            <label for="numSMEV">Номер СМЭВ</label>
          </div>
        </div>                 
      </div> 
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control" id="reqObjAddress" placeholder="Адрес объекта недвижимости" value="">
            <label for="reqObjAddress">Адрес объекта недвижимости</label>
          </div>
        </div>  
      </div>      
      <div class="row g-1 mb-3">
        <div class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" id="reqComment" style="height: 200px"></textarea>
          <label for="reqComment">Комментарий</label>
        </div> 
      </div>     
      <h6 class="display-6">Сведения об услуге</h6>
      <div class="row g-2 mb-3">
        <div class="col-md">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-1">
            <label class="form-check-label" for="svc-1">
              Технический паспорт ОКС/помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-2" >
            <label class="form-check-label" for="svc-2">
              Пэтажный/ситуационный план
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-3">
            <label class="form-check-label" for="svc-3">
              Экспликация поэтажного плана/ОКС/помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-4" >
            <label class="form-check-label" for="svc-4">
              УТД, содержащая сведения об инвентаризационной, восстановительной, балансовой или иной стоимости ОКС/помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-5">
            <label class="form-check-label" for="svc-5">
              Проектно-разрешительная документация, техническое или экспертное заключение, или иная документация, содржащаяся в архиве
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-6" >
            <label class="form-check-label" for="svc-6">
              Правоустанавливающий документ, хранящийся в материалах инвентарного дела
            </label>
          </div>
        </div>
        <div class="col-md">
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-7">
            <label class="form-check-label" for="svc-7">
              Выписка из реестровой книги о праве собственности на ОКС/помещение (до 1988 года)
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-8" >
            <label class="form-check-label" for="svc-8">
              Справка, содержащая сведения об инвентаризационной стоимости ОКС
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-9">
            <label class="form-check-label" for="svc-9">
              Справка, содержащая сведения об инвентаризационной стоимости помещения
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-10" >
            <label class="form-check-label" for="svc-10">
              Справка, содержащая сведения о наличии (отсутствии) права собствености на объекты недвижимости (один правообладатель)
            </label>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" value="" id="svc-11">
            <label class="form-check-label" for="svc-11">
              Справка, содержащая сведения о характеристиках объекта государственного учета
            </label>
          </div>
        </div>                
      </div>
      <h6 class="display-6">Способ получения копии/справки</h6>      
      <div class="row g-1 mb-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="post" value="option1" checked>
          <label class="form-check-label" for="post">
            Почтовым отправление
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="email" value="option2">
          <label class="form-check-label" for="email">
            Электронной почтой
          </label>
        </div>      
        <div class="form-check">
          <input class="form-check-input" type="radio" name="delivery" id="foot" value="option3">
          <label class="form-check-label" for="foot">
            При личном обращении в КГБУ "КГКО"
          </label>
        </div>           
      </div>  
      <h6 class="display-6">Перечень прилагаемых документов</h6>      
      <div class="row g-1 mb-3">
        <div class="col-md mb-1 attach">        
          <button type="button" class="btn btn-outline-secondary">Копия паспорта</button>
          <button type="button" class="btn btn-outline-secondary">Копия доверенности</button>
          <button type="button" class="btn btn-outline-secondary">Выписка из ЕГРН</button>
          <button type="button" class="btn btn-outline-secondary">Выписка из ЕГРЮЛ</button>
        </div>
        <div class="form-floating">
          <textarea class="form-control" placeholder="Leave a comment here" id="attachList" style="height: 100px"></textarea>
          <label for="attachList">Перечень документов</label>
        </div>   
      </div> 
      <div class="row g-1 mb-3">
        <div class="mb-3">
          <label for="formFileMultiple" class="form-label">Загрузите файлы приложений</label>
          <input class="form-control" type="file" id="formFileMultiple" multiple>
        </div>  
      </div>
      <div class="row g-2 mb-3">
        <div class="col-md mb-1">
          <button type="button" id="send" class="btn btn-primary btn-lg">Создать запрос</button>   
          <button type="button" class="btn btn-secondary btn-lg">Сбросить</button>       
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

    <script type="text/javascript" src="js/utd.js"></script>