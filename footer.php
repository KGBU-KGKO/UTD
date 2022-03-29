<!-- новая модалка запроса -->

<div class="modal fade" id="reqInfo" tabindex="-1" aria-labelledby="reqInfoLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
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
              </div>
              <div class="tab-pane fade" id="reqTabInfo" role="tabpanel" aria-labelledby="req-tab">
                <table class="table table-bordered table-sm mt-2">
                  <tbody>
                    <tr>
                      <td class="w600">Объект</td>
                      <td id="reqTabInfoObject"></td>
                    </tr>
                    <tr>
                      <td class="w600">Комментарий</td>
                      <td id="reqTabInfoComment"></td>
                    </tr>
                    <tr>
                      <td class="w600">Услуги</td>
                      <td id="reqTabInfoServices"></td>
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
                    <tr>
                      <td class="w600">Статус</td>
                      <td id="repTabInfoStatus"></td>
                    </tr>
                    <tr>
                      <td class="w600">Причина отказа</td>
                      <td id="repTabInfoReason"></td>
                    </tr>
                  </tbody>
                </table>     
              </div>
            </div> 
          </div>
          <div class="col-md-3 ms-auto">
            <h1 class="display-6 display-small mx-4">История</h1>
            <ul class="timeline">
              <li>
                <div class="w600">Запрос создан</div>
                <div class="history-detail"><i class="bi bi-calendar-event"></i> 21 March, 2014</div>
                <div class="history-detail"><i class="bi bi-person"></i> Понамарёва К.С.</div>
              </li>
              <li>
                <div class="w600">Взят в работу</div>
                <div class="history-detail"><i class="bi bi-calendar-event"></i> 4 March, 2014</div>
                <div class="history-detail"><i class="bi bi-person"></i> Понамарёва К.С.</div>
              </li>
              <li>
                <div class="w600">Оплачен</div>
                <div class="history-detail"><i class="bi bi-calendar-event"></i> 1 April, 2014</div>
                <div class="history-detail"><i class="bi bi-person"></i> Понамарёва К.С.</div>
              </li>
            </ul>
          </div>

        </div>
      </div>
      <div class="modal-footer justify-content-between">

          <div class="col-md-5 text-start">
            <button id="modalPrintReq" type="button" class="btn btn-primary">Печать запроса</button>            
            <button type="button" class="btn btn-primary">Печать ответа</button>            
            <button type="button" class="btn btn-primary">Новый запрос</button>            
          </div>
          <div class="col-md-5 text-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
          </div>

      </div>
    </div>
  </div>
</div>

<!-- новая модалка запроса -->

  </body>
</html>
<script type="text/javascript" src="lib/bootstrap/bootstrap.bundle.min.js" ></script>
<script type="text/javascript" src="lib/jquery/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="lib/bootstrap-table/bootstrap-table.min.js"></script>
<script type="text/javascript" src="lib/bootstrap-table/bootstrap-table-ru-RU.min.js" ></script>
<script type="text/javascript" src="lib/jquery/jquery-ui.js"></script>
<script type="text/javascript" src="lib/suggestions/jquery.suggestions.min.js"></script>  
<script type="text/javascript" src="js/common.js"></script> 