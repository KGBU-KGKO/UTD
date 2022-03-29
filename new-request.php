<?php include "header.php"; ?>
  <body>
    <div class="container mb-5">
      <h1 class="display-3 mb-3">Новый запрос</h1>
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
        <form id="reqFL" class="needs-validation" novalidate>
      <div class="row g-3 mb-3">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" name="agentFLSwitch" id="agentFLSwitch">
          <label class="form-check-label" for="agentFLSwitch">Представитель по доверенности</label>
        </div>                
      </div>    
      <div class="row g-1 mb-3">
        <div class="col-md-9">
          <div class="form-floating">
            <input type="text" class="form-control" id="dFLName" name="dFLName" placeholder="ФИО" value="" required>
            <label for="dFLName">ФИО заявителя</label>
            <div class="invalid-feedback">
              Укажите ФИО заявителя
            </div>
          </div>
        </div>  
        <div class="col-md-3">
          <div class="form-floating">
            <input type="date" class="form-control" id="dFLBD" name="dFLBD" placeholder="Дата рождения" value="" required>
            <label for="dFLBD">Дата рождения</label>
            <div class="invalid-feedback">
              Укажите дату рождения
            </div>            
          </div>
        </div>              
      </div>
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAddress" name="dFLAddress" placeholder="Адрес места жительства заявителя" value="" required>
            <label for="dFLAddress">Адрес места жительства заявителя</label>
            <div class="invalid-feedback">
              Укажите адрес места жительства заявителя
            </div>            
          </div>
        </div> 
      </div> 
      <div class="row g-3 mb-3 decDataGroup">
        <div class="col-md">
          <div class="form-floating">
            <input type="tel" class="form-control decData" id="dFLPhone" name="dFLPhone" placeholder="Контактный телефон" value="">
            <label for="dFLPhone">Контактный телефон</label>
          </div>
        </div>         
        <div class="col-md">
          <div class="form-floating">
            <input type="email" class="form-control decData" id="dFLEmail" name="dFLEmail" placeholder="name@example.com" value="">
            <label for="dFLEmail">Адрес эл. почты</label>
          </div>
        </div> 
      </div>
      <div class="row g-3 mb-3 decDataGroup">
        <div class="col-md-2">
          <div class="form-floating">
            <input type="text" class="form-control decData" id="dFLNumDUL" name="dFLNumDUL" placeholder="Серия и номер ДУЛ" value="" required>
            <label for="dFLNumDUL">Серия и номер ДУЛ</label>
            <div class="invalid-feedback">
              Укажите серию и номер ДУЛ
            </div>            
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating">
            <input type="Date" class="form-control decData" id="dFLDateDUL" name="dFLDateDUL" placeholder="Даты выдачи ДУЛ" value="" required>
            <label for="dFLDateDUL">Даты выдачи ДУЛ</label>
            <div class="invalid-feedback">
              Укажите дату выдачи ДУЛ
            </div>            
          </div>
        </div> 
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" class="form-control decData" id="dFLWhoDUL" name="dFLWhoDUL" placeholder="Кем выдан ДУЛ" value="" required>
            <label for="dFLWhoDUL">Кем выдан ДУЛ</label>
            <div class="invalid-feedback">
              Укажите кем выдан ДУЛ
            </div>            
          </div>
        </div>                 
      </div>       
      </form>    
      <form id="agentFLForm" style="display: none;">
      <h6 class="display-6">Сведения о представителе заявителя</h6>
      <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dFLAgentName" name="dFLAgentName" placeholder="ФИО представителя" value="" required>
              <label for="dFLAgentName">ФИО представителя</label>
              <div class="invalid-feedback">
                Укажите ФИО представителя
              </div>              
            </div>
          </div>
          <div class="col-md">
            <div class="form-floating">
              <input type="tel" class="form-control agentData" id="dFLAgentPhone" name="dFLAgentPhone" placeholder="Контактный телефон" value="">
              <label for="dFLPhone">Контактный телефон</label>
            </div>
          </div>         
          <div class="col-md">
            <div class="form-floating">
              <input type="email" class="form-control agentData" id="dFLAgentEmail" name="dFLAgentEmail" placeholder="name@example.com" value="">
              <label for="dFLEmail">Адрес эл. почты</label>
            </div>
          </div>           
      </div>    
      <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dFLAgentDoc" name="dFLAgentDoc" placeholder="Реквизиты доверенности представителя" value="" data-bs-toggle="tooltip" data-bs-placement="left" title="Или иного документа, подтверждающего полномочия" required>
              <label for="dFLAgentDoc">Реквизиты доверенности представителя</label>
              <div class="invalid-feedback">
                Укажите реквизиты доверенности представителя
              </div>              
            </div>
          </div>
      </div>     
      <div class="row g-1 mb-3">
        <div class="col-md">
          <div class="form-floating">
            <input type="text" class="form-control address" id="dFLAgentAddress" name="dFLAgentAddress" placeholder="Адрес места жительства представителя" value="" required>
            <label for="dFLAgentAddress">Адрес места жительства представителя</label>
            <div class="invalid-feedback">
              Укажите адрес места жительства представителя
            </div>               
          </div>
        </div> 
      </div>    
      <div class="row g-3 mb-3">
        <div class="col-md-2">
          <div class="form-floating">
            <input type="text" class="form-control agentData" id="dFLAgentNumDUL" name="dFLAgentNumDUL" placeholder="Серия и номер ДУЛ" value="" required>
            <label for="dFLNumDUL">Серия и номер ДУЛ</label>
            <div class="invalid-feedback">
              Укажите серию и номер ДУЛ представителя
            </div>               
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating">
            <input type="Date" class="form-control agentData" id="dFLAgentDateDUL" name="dFLAgentDateDUL" placeholder="Даты выдачи ДУЛ" value="" required>
            <label for="dFLDateDUL">Даты выдачи ДУЛ</label>
            <div class="invalid-feedback">
              Укажите дату выдачи ДУЛ представителя
            </div>               
          </div>
        </div> 
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" class="form-control agentData" id="dFLAgentWhoDUL" name="dFLAgentWhoDUL" placeholder="Кем выдан ДУЛ" value="" required>
            <label for="dFLWhoDUL">Кем выдан ДУЛ</label>
            <div class="invalid-feedback">
              Укажите кем выдан ДУЛ представителя
            </div>               
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
              <input type="text" class="form-control" id="dULName" name="dULName" placeholder="Наименование юр. лица" value="" required>
              <label for="dULName">Наименование юр. лица</label>
              <div class="invalid-feedback">
                Укажите наименование юр. лица
              </div>              
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULINN" name="dULINN" placeholder="ИНН" value="" required>
              <label for="dULINN">ИНН</label>
              <div class="invalid-feedback">
                Укажите ИНН
              </div>               
            </div>
          </div>
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dULOGRN" name="dULOGRN" placeholder="ОГРН" value="" required>
              <label for="dULOGRN">ОГРН</label>
              <div class="invalid-feedback">
                Укажите ОГРН
              </div>               
            </div>
          </div>                 
        </div> 
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control address" id="dULAddress" name="dULAddress" placeholder="Адрес местонахождения" value="" required>
              <label for="dULAddress">Адрес местонахождения</label>
              <div class="invalid-feedback">
                Укажите адрес местонахождения
              </div>               
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
              <input type="text" class="form-control" id="dULAgentName" name="dULAgentName" placeholder="ФИО представителя" value="" required>
              <label for="dULAgentName">ФИО представителя</label>
              <div class="invalid-feedback">
                Укажите ФИО представителя
              </div>               
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
              <input type="text" class="form-control" id="dULAgentDoc" name="dULAgentDoc" placeholder="Реквизиты доверенности представителя" value="" data-bs-toggle="tooltip" data-bs-placement="left" title="Или иного документа, подтверждающего полномочия" required>
              <label for="dULAgentDoc">Реквизиты доверенности представителя</label>
              <div class="invalid-feedback">
                Укажите реквизиты доверенности представителя
              </div>               
            </div>
          </div>
      </div>        
        <div class="row g-1 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control address" id="dULAgentAddress" name="dULAgentAddress" placeholder="Адрес проживания представителя" value="" required>
              <label for="dULAgentAddress">Адрес проживания представителя</label>
              <div class="invalid-feedback">
                Укажите адрес проживания представителя
              </div>               
            </div>
          </div>                  
        </div>        
      <div class="row g-3 mb-3">
        <div class="col-md-2">
          <div class="form-floating" data-bs-toggle="tooltip" data-bs-placement="left" title="Серия и номер паспорта заявителя (представителя)">
            <input type="text" class="form-control" id="dULNumDUL" name="dULNumDUL" placeholder="Серия и номер ДУЛ" value="" required>
            <label for="dULNumDUL">Серия и номер ДУЛ</label>
              <div class="invalid-feedback">
                Укажите серию и паспорт ДУЛ
              </div>             
          </div>
        </div> 
        <div class="col-md-2">
          <div class="form-floating">
            <input type="Date" class="form-control" id="dULDateDUL" name="dULDateDUL" placeholder="Даты выдачи ДУЛ" value="" required>
            <label for="dULDateDUL">Даты выдачи ДУЛ</label>
              <div class="invalid-feedback">
                Укажите дату выдачи ДУЛ
              </div>             
          </div>
        </div> 
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" class="form-control" id="dULWhoDUL" name="dULWhoDUL" placeholder="Кем выдан ДУЛ" value="" required>
            <label for="dULWhoDUL">Кем выдан ДУЛ</label>
              <div class="invalid-feedback">
                Укажите кем выдан ДУЛ
              </div>             
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
              <input type="text" class="form-control" id="dOGVName" name="dOGVName" placeholder="Наименование ОГВ" value="" required>
              <label for="dOGVName">Наименование ОГВ</label>
              <div class="invalid-feedback">
                Укажите наименование ОГВ
              </div>              
            </div>
          </div>                   
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="dOGVSenderNum" name="dOGVSenderNum" placeholder="Исходящий номер отправителя" value="" required>
              <label for="dOGVSenderNum">Исходящий номер отправителя</label>
              <div class="invalid-feedback">
                Укажите исходящий номер отправителя
              </div>              
            </div>
          </div>  
          <div class="col-md">
            <div class="form-floating">
              <input type="Date" class="form-control" id="dOGVSenderDate" name="dOGVSenderDate" placeholder="Дата исходящего отправителя" value="" required>
              <label for="dOGVSenderDate">Дата исходящего отправителя</label>
              <div class="invalid-feedback">
                Укажите дата исходящего отправителя
              </div>              
            </div>
          </div>
          <div class="col-md">
            <div class="form-floating">
              <input type="text" class="form-control" id="numSMEV" name="numSMEV" placeholder="Номер СМЭВ" value="" required>
              <label for="numSMEV">Номер СМЭВ</label>
              <div class="invalid-feedback">
                Укажите номер СМЭВ
              </div>              
            </div>
          </div>           
        </div>        
        </form>
      </div>   
      <h6 class="display-6">Сведения о запросе</h6>
      <form id="reqInfo">
      <div class="row g-3 mb-3 d-none">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" name="likeAddress" id="likeAddress">
          <label class="form-check-label" for="likeAddress">Адрес совпадает с адресом места жительства</label>
        </div>                
      </div> 
      <div class="row g-1 mb-3">
        <div class="col-md-8">
          <div class="form-floating">
            <input type="text" class="form-control address" id="reqObjAddress" name="reqObjAddress" placeholder="Адрес объекта недвижимости" value="">
            <label for="reqObjAddress">Адрес объекта недвижимости</label>
          </div>
        </div>  
        <div class="col-md-4">
          <div class="form-floating">
            <input type="date" class="form-control" id="reqDate" name="reqDate" placeholder="Дата регистрации" value="" readonly>
            <label for="reqDate">Дата регистрации</label>
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
      <div class="row g-2 mb-3 groupCheck" id="services">
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
      <div class="row g-1 mb-3 groupCheck" id="delivery">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="smev" id="smev" value="СМЭВ">
          <label class="form-check-label" for="smev">
            СМЭВ
          </label>
        </div>          
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="post" id="post" value="Почтовым отправление">
          <label class="form-check-label" for="post">
            Почтовым отправление
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="email" id="email" value="Электронной почтой">
          <label class="form-check-label" for="email">
            Электронной почтой
          </label>
        </div>      
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="foot" id="foot" value="При личном обращении в КГБУ «КГКО»" checked>
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

<div class="modal fade" id="notify" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
<div class="modal-header">
        <h5 class="modal-title">Ошибка</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
</div>
<div class="modal-body">
<p>Возникла ошибка при создании запроса. Обратитесь в отдел ИТ.</p>
<p>Текст ошибки: </p>
<p id="txtInfo"></p>
</div>      
<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Понятно</button>
</div>
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

<?php include "footer.php"; ?>
<script type="text/javascript" src="js/new-requests.js"></script>