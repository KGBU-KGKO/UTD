<!-- новая модалка запроса -->

<div class="modal fade" id="reqInfoModal" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content" id="reqInfoContent">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Запрос №<span id="reqInfoNum"></span> от <span id="reqInfoDate"></span> <span id="reqInfoStatus" class="badge bg-primary"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-9">
            <ul class="nav nav-tabs" id="reqTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dec-tab" data-bs-toggle="tab" data-bs-target="#decTabInfo" type="button" role="tab" aria-controls="decTabInfo" aria-selected="true">Заявитель</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="req-tab" data-bs-toggle="tab" data-bs-target="#reqTabInfo" type="button" role="tab" aria-controls="reqTabInfo" aria-selected="false">Запрос</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="rep-tab" data-bs-toggle="tab" data-bs-target="#repTabInfo" type="button" role="tab" aria-controls="repTabInfo" aria-selected="false">Ответ</button>
              </li>
            </ul>
            <div class="tab-content" id="reqTabContent">
              <div class="tab-pane fade show active" id="decTabInfo" role="tabpanel" aria-labelledby="dec-tab">
                <img src="/img/preload.gif" alt="mdo" width="64" height="64" class="rounded-circle mx-auto d-block">
              </div>
              <div class="tab-pane fade" id="reqTabInfo" role="tabpanel" aria-labelledby="req-tab">
                <table class="table table-bordered table-sm mt-2">
                  <thead class="thead600"><tr><th class="w600">Услуга</th><th>Предмет услуги</th><th>Доп. инфо</th></tr></thead>
                  <tbody id="servicesInfo">
                  </tbody>
                </table>
                <table class="table table-bordered table-sm mt-2">
                  <tbody>
                    <tr>
                      <td class="w600">Комментарий</td>
                      <td id="reqTabInfoComment"></td>
                    </tr>
                    <tr>
                      <td class="w600">Способ получения</td>
                      <td id="reqTabInfoDelivery"></td>
                    </tr>
                    <tr>
                      <td class="w600">Список приложений</td>
                      <td id="reqTabInfoAttach"></td>
                    </tr>
                    <tr>
                      <td class="w600">Файлы приложений</td>
                      <td id="reqTabInfoFiles"></td>
                    </tr>
                  </tbody>
                </table>  
              </div>
              <div class="tab-pane fade" id="repTabInfo" role="tabpanel" aria-labelledby="rep-tab">
                <table class="table table-bordered table-sm mt-2">
                  <tbody>
                    <tr>
                      <td class="w600">Дата ответа</td>
                      <td id="repTabInfoDate"></td>
                    </tr>
                    <tr>
                      <td class="w600">Номер ответа</td>
                      <td id="repTabInfoNum"></td>
                    </tr>
                  </tbody>
                </table>   

                <table class="table table-bordered table-sm mt-2" id="servicesInfoReply">
                  <thead class="thead600"><tr><th>Услуга</th><th>Статус</th><th>Доп. инфо</th></tr></thead>
                  <tbody id="servicesInfoReplyBody">
                  </tbody>
                </table>

              </div>
            </div> 
          </div>
          <div class="col-md-3 ms-auto">
            <h1 class="display-6 display-small mx-4">История</h1>
            <ul class="timeline" id="history"></ul>
          </div>

        </div>
      </div>
      <div class="modal-footer justify-content-between">

          <div class="col-md-5 text-start">
            <button id="modalPrintReq" type="button" class="btn btn-primary">Печать запроса</button>            
            <button id= "modalGetReply" type="button" class="btn btn-primary">Печать ответа</button>            
            <button type="button" class="btn btn-primary" disabled>Новый запрос</button>            
          </div>
          <div class="col-md-5 text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          </div>

      </div>
    </div>
  </div>
</div>

<!-- новая модалка запроса -->

<!-- новая модалка notify -->
<div class="modal fade" id="notify" tabindex="-1" aria-labelledby="removeAlertLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="notifyTitle"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
      </div>
      <div class="modal-body">
        <p id="notifyText"></p>
        <div class="text-end"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Понятно</button></div>
      </div>      
    </div>
  </div>
</div>
<!-- новая модалка notify -->

<!-- toast -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
  
</div>
<!-- toast -->

  </body>
</html>
<script type="text/javascript" src="lib/bootstrap/bootstrap.bundle.min.js" ></script>
<script type="text/javascript" src="lib/jquery/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="lib/bootstrap-table/bootstrap-table.min.js"></script>
<script type="text/javascript" src="lib/bootstrap-table/bootstrap-table-ru-RU.min.js" ></script>
<script type="text/javascript" src="lib/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="lib/suggestions/jquery.suggestions.min.js"></script>   
<script type="text/javascript" src="lib/cookie/jquery-cookie.js"></script>  
<script type="text/javascript" src="js/common.js"></script> 