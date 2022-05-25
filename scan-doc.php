<?php include "header.php"; ?>
  <body>
    <div class="container mb-5">
      <h1 class="display-3 mb-3">Оцифровка инвентарного дела</h1>
      <h6 class="display-6">Сведения об инвентарном деле</h6>
      <div class="row g-3 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAddress" name="dFLAddress" placeholder="Адрес места жительства заявителя" value="" required>
            <label for="dFLAddress">Адрес объекта недвижимости</label>
            <div class="invalid-feedback">
              Укажите адрес объекта недвижимости
            </div>            
          </div>
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
<!--       <div class="row g-1 mb-1">
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
      </div> -->
    </div>

<?php include "footer.php"; ?>
<script type="text/javascript" src="js/scan-doc.js"></script>

<!-- 

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
Кол-во томов
Наличие 2-ой группы
Наличие нумерации
После 2013 года
Примечание
Комментарий

 -->