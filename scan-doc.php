<?php include "header.php"; ?>
  <body>
    <div class="container mb-5">
      <h1 class="display-3 mb-3">Оцифровка инвентарного дела</h1>
      <h6 class="display-6">Сведения об инвентарном деле</h6>
<div class="row g-1 mb-3">
                              <div class="col-md">
                                <div class="form-floating">
                                  <input type="text" class="form-control address" id="svcInfoObj-address-${id}" name="svcInfoObj-address-${id}" placeholder="Адрес объекта недвижимости" value="" required>
                                  <label for="svcInfoObj-address-${id}">Адрес объекта недвижимости</label>
                                </div>
                              </div>  
                            </div>
                            <div class="row g-1 mb-3">
                              <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-postcode-${id}" name="svcInfoObj-address-postcode-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-address-postcode-${id}">Индекс</label>
                                </div>
                              </div>   
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-region-${id}" name="svcInfoObj-address-region-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-region-${id}">Регион</label>
                                </div>
                                <div class="form-floating d-none">
                                  <input type="text" class="form-control" id="svcInfoObj-address-region-code-${id}" name="svcInfoObj-address-region-code-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-region-code-${id}">Регион</label>
                                </div>                                
                              </div>
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-area-${id}" name="svcInfoObj-address-area-${id}" placeholder="Район" value="">
                                  <label for="svcInfoObj-address-area-${id}">Район</label>
                                </div>
                                <div class="form-floating d-none">
                                  <input type="text" class="form-control" id="svcInfoObj-address-area-code-${id}" name="svcInfoObj-address-area-code-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-area-code-${id}">Регион</label>
                                </div>                                
                              </div>                              
                              <div class="col-md-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-local-${id}" name="svcInfoObj-address-local-${id}" placeholder="Населенный пункт" value="">
                                  <label for="svcInfoObj-address-local-${id}">Населенный пункт</label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-street-${id}" name="svcInfoObj-address-street-${id}" placeholder="Улица" value="">
                                  <label for="svcInfoObj-address-street-${id}">Улица</label>
                                </div>
                              </div> 
                             <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-house-${id}" name="svcInfoObj-address-house-${id}" placeholder="Дом" value="">
                                  <label for="svcInfoObj-address-house-${id}">Дом</label>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-flat-${id}" name="svcInfoObj-address-flat-${id}" placeholder="Квартира" value="">
                                  <label for="svcInfoObj-address-flat-${id}">Квартира</label>
                                </div>
                              </div>                   
                            </div>
                            <div class="row g-1 mb-3">
                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-location-${id}" name="svcInfoObj-address-location-${id}" placeholder="Местоположение" value="">
                                  <label for="svcInfoObj-address-location-${id}">Местоположение объекта недвижимости</label>
                                </div>
                              </div>
                            </div>
                            <div class="row g-1 mb-3">
                                <div class="form-floating">
                                  <textarea class="form-control" placeholder="Дополнительная информация" id="svcInfoObj-addInfo-${id}" name="svcInfoObj-addInfo-${id}" style="height: 200px"></textarea>
                                  <label for="svcInfoObj-addInfo-${id}">Дополнительная информация</label>
                                </div>                            
                            </div>      
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAddress" name="dFLAddress" placeholder="Инвентарный номер дела" value="" required>
            <label for="dFLAddress">Инвентарный номер дела</label>
            <div class="invalid-feedback">
              Укажите инвентарный номер дела
            </div>            
          </div>
        </div>        
      </div>
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAddress" name="dFLAddress" placeholder="Комментарий" value="">
            <label for="dFLAddress">Комментарий</label>
          </div>
        </div>        
      </div>    
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAddress" name="dFLAddress" placeholder="Комментарий" value="">
            <label for="dFLAddress">Кадастровый номер</label>
          </div>
        </div>        
      </div>       




      <div class="row g-1 mb-1">
        <div class="mb-3">
          <label for="reqFiles" class="form-label">Загрузите файлы приложений</label>
          <input class="form-control form-control-lg" type="file" id="reqFiles" name="reqFiles" multiple disabled>
        </div>  
      </div>
      <div class="row g-1">
        <div class="mb-3">
          <label for="nameFiles" class="form-label">Список файлов для загрузки:</label>
          <div id="nameFiles"></div>
        </div>  
      </div> 
      <div class="row g-2 mb-3">
        <div class="col-md-2 mb-1">
          <button type="button" id="upload" class="btn btn-primary btn-lg" disabled>Загрузить файлы</button>   
        </div>
      </div>
    </div>

<?php include "footer.php"; ?>
<script type="text/javascript" src="js/scan-doc.js"></script>

<!-- 

загрузить таблицу с кадастровами номерами и сразу при выборе ИД подставлять их
выводить список запросов по которым надо сканировать ИД

1. Проверка, что ИД уже отсканировано (предложить посмотреть ИД и добавить материалы)
2. Найти КН по адресу и предложить добавить в ИД
3. Добавить файлы (надо ли их группировать?)


номер ИД
кадастровый номер (может быть несколько)
Адрес
Литера? 
Примечание
Файлы

Литер?
Кол-во томов?
Наличие 2-ой группы
Наличие нумерации
После 2013 года
Примечание
Комментарий

 -->