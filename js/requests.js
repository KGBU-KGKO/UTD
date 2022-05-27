let newReqTable = $('#newReqTable').bootstrapTable({
    pagination: true,
});
let inworkReqTable = $('#inworkReqTable').bootstrapTable({
    pagination: true,
});
let replyModal = new bootstrap.Modal($('#reply'), {});
let answerModal = new bootstrap.Modal($('#answer'), {});
let request = {};

$.when($.ready).then(function() {
    let today = new Date();
    $('#reqOutDate').val(today.getFullYear() + "-" + ('0' + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2));

    newReqTable.bootstrapTable('load', getDataTable("Новый"));
    inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
    inworkReqTable.bootstrapTable('filterBy', {
        status: ["В работе"]
      });

    if (newReqTable.bootstrapTable('getData').length == '0') {
        $('#newReqData').addClass('d-none');
        $('#newReqDataEmpty').removeClass('d-none');
    }

});

$("#onlyDelivery").change(function() {
    let statusList = $(this).prop('checked') ? ["На выдачу (Ответ)", "На выдачу", "На выдачу (Отказ)", "На выдачу (Отказ/Ответ)"] : ["В работе"];
    inworkReqTable.bootstrapTable('filterBy', {
        status: statusList
      });
});

function getDataTable(dataStatus) {
    dataTbl = $.ajax({
        url: 'data/showRequests.php',
        type: 'GET',
        async: false,
        data: { status: dataStatus },
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(dataTbl.responseText)
}

function numFormatter(value) {
    if (value) {
        return '<a class="card-link" role="button">' + value + '</a>';
    }
}

function payFormatter(value) {
    if (value) {
        return '<p class="text-center m-0"><i class="bi bi-check2-square text-success fs-5" ></i></p>';
    }
}

function objFormatter(value) {
    arr = value.split('; ');
    res = [];
    $.each(arr, function(index, value) {
         if ($.inArray(value, res) == -1)
             res.push(value);

    });
    return res.join('; ');
}

function deadlineFormatter(value) {
    let dateDue = new Date(value);
    let dateNow = new Date();
    (dateDue.getMonth() - dateNow.getMonth()) != 0 ? days = dateDue.getDate() + 30 : days = dateDue.getDate();
    let diff = days - dateNow.getDate();
    if (diff < 4) {
        return value + ' <i class="bi bi-exclamation-circle-fill text-danger fs-5"></i>';
    } else {
        return value;
    }
}

function typeFormatter(value) {
    switch (value.type.substring(0, 2)) {
        case 'FL':
            return 'ФЛ';
            break;
        case 'UL':
            return 'ЮЛ';
            break;
        case 'OG':
            return value.type.replace(/OGV/gi, 'ОГВ');
            break;
    }
}

function decFormatter(value) {
    return value.name;
}

function perfFormatter(value) {
    return value.name;
}

function customSort(sortName, sortOrder, data) {
    let order = sortOrder === 'desc' ? -1 : 1
    data.sort(function(a, b) {
        let aa = +((a[sortName] + '').replace(/[^\d]/g, ''))
        let bb = +((b[sortName] + '').replace(/[^\d]/g, ''))
        if (aa < bb) {
            return order * -1
        }
        if (aa > bb) {
            return order
        }
        return 0
    })
}

$("#newReqTable").on('click', 'a', function() {
    addModalInfo($(this).html());
    reqInfoModal.show();
});

$("#inworkReqTable").on('click', 'a', function() {
    addModalInfo($(this).html());
    reqInfoModal.show();
});

$("#newReqTable").on('click', 'tr', function() {
    $('#reqNumNew').val($(this).find('td').eq(0).text());     
});

$("#inworkReqTable").on('click', 'tr', function() {
    $('#reqNumWork').val($(this).find('td').eq(0).text()); 
});

$("#inWork").click(function() {
    if (!validateForm(['reqNumNew', 'select:performer'])) {
        return;
    }

    $.ajax({
        url: 'data/changeStatus.php',
        type: 'GET',
        data: { status: "В работе", num: $('#reqNumNew').val(), performer: $('#performer option:selected').text() },
        success: function(data) {
            if (data == 'done') {
                logger('Взят в работу', $('#reqNumNew').val());
                showSmallToast('bg-primary', 'Запрос '+$('#reqNumNew').val()+' взят в работу.', '5000');
            } else {
                showSmallToast('bg-danger', $('#reqNumNew').val()+": "+data, '10000');
            }
            newReqTable.bootstrapTable('load', getDataTable("Новый"));
            inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
            $('#reqNumNew').val('');
        }
    });
});

$("#Paid").click(function() {
    if (!validateForm(['reqNumWork'])) {
        return;
    }

    $.ajax({
        url: 'data/changeStatus.php',
        type: 'GET',
        data: { status: "Оплачен", num: $('#reqNumWork').val() },
        success: function(data) {
            if (data == 'done') {
                logger('Оплачен', $('#reqNumWork').val())
                showSmallToast('bg-success', 'Запрос '+$('#reqNumWork').val()+' оплачен.', '5000');
            } else {
                showSmallToast('bg-danger', $('#reqNumWork').val()+": "+data, '10000');
            }
            inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
        }
    });
});

$("#Issue").click(function() {
    if (!validateForm(['reqNumWork'])) {
        return;
    }
    $.ajax({
        url: 'data/changeStatus.php',
        type: 'GET',
        data: { status: "Выполнен", num: $('#reqNumWork').val() },
        success: function(data) {
            if (data == 'done') {
                logger('Выдан', $('#reqNumWork').val());
                showSmallToast('bg-success', 'Запрос '+$('#reqNumWork').val()+' выдан.', '5000');
            } else {
                showSmallToast('bg-danger', $('#reqNumWork').val()+": "+data, '10000');
            }
            $('#reqNumWork').val("");
            inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
        }
    });
});

$("#printList").click(function() {
    window.open("/tpl/printRegister.php", "_blank");
});

function validateForm(inputs) {
    result = true;
    $.each(inputs, function(index, value) {
        if ($(`#${value}`).attr('readonly')) {
            return;
        }
        if (value.substring(0, 7) == 'select:') {
            value = value.substring(7);
            if ($('#' + value + ' option:selected').text() == '---') {
                item = '';
            } else {
                item = $('#' + value + ' option:selected').text();
            }
        } else {
            item = $('#' + value).val();
        }
        $('#' + value).removeClass('is-invalid');
        if (!item) {
            $('#' + value).addClass('is-invalid');
            result = false;
        }
    });
    return result;
}

function checkRequest(request) {
    check = $.ajax({
        url: 'data/new-reply.php',
        type: 'GET',
        async: false,
        data: { checkRequest: true, reqNum: request.num },
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(check.responseText);
}

function getRequest(num) {
    request = $.ajax({
        url: 'data/getRequest.php',
        type: 'GET',
        async: false,
        data: { numLog: num },
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(request.responseText);    
}

$(".performer").change(function() {
    setUser(getProfile($(this).children("option:selected").text()));
});

$("#ShowReplyModal").click(function() {
    if (!validateForm(['reqNumWork', 'select:performerInWork'])) 
        return;
    showReplyModal($('#reqNumWork').val());
});

$('body').on('click', '[id^="reply-svc"]', function() {
    let svc = $(this).attr('id').split('-');
    let svcID = svc[4];
    let svcNum = svc[2];
    let answer = svc[3];
    switch (svcNum) {
        case '7':
        case '10':
            textModalReference(answer, svcID);
            break;
        default:
            textModalCopy(answer, svcID);
    }  
});

$('body').on('click', '[id^="svc-edit-btn"]', function() {
    let id = $(this).attr('id').split("-")[4];
    let status = ($(this).attr('id').split("-")[3] == 'yes') ? 'Ответ' : 'Отказ';
    let notValid = true;
    let fields = new Object();
    $('[id^="svc-edit-field"]').each(function() {
        if (!validateForm([$(this).attr('id')])) {
            notValid = false;
            return false;
        }
        fields[$(this).attr('id').split('-')[3]] = $(this).val();
    });    
    if (!notValid)
        return false;
    editService(id, status, fields.reason, fields.answerText, fields.pages, fields.before2000, fields.limits);
    answerModal.hide();
});

function textModalCopy(answer, id) {
    let textModal = '';
    $('#answerBtn').html(`<button id="svc-edit-btn-${answer}-${id}" type="button" class="btn btn-primary">Записать</button>`);
    if (answer == 'yes') {
        textModal = `<div class="row g-3 mb-3">
          <div class="col-md-4">
            <div class="form-floating">
              <input type="text" class="form-control" id="svc-edit-field-pages-${answer}-${id}" name="svc-edit-field-pages-${answer}-${id}" placeholder="Введите количество листов копии" value="">
              <label for="svc-edit-field-pages-${answer}-${id}">Введите количество листов копии</label>
              <div class="invalid-feedback">
                Введите информацию
              </div>                   
            </div>
          </div></div>`;
        showAnswerModal('Ведите данные для ответа', textModal);
    } else {
        textModal = `<div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <textarea class="form-control" id="svc-edit-field-reason-${answer}-${id}" name="svc-edit-field-reason-${answer}-${id}" placeholder="Причина отказа" style="height: 200px"></textarea>
              <label for="svc-edit-field-reason-${answer}-${id}">Причина отказа</label>
              <div class="invalid-feedback">
                Введите информацию
              </div>                   
            </div>
          </div></div>`;    
        let reasonPreset = getReasonPreset(id);   
        showAnswerModal('Ведите причину отказа', reasonPreset+textModal);
    }
}

function textModalReference(answer, id) {
    let textModal = '';
    let textOption = `<div class="mb-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input svc-edit-checkbox" type="checkbox" id="svc-edit-field-before2000-${answer}-${id}" value="0">
                          <label class="form-check-label" for="svc-edit-field-before2000-${answer}-${id}">До 2000</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input svc-edit-checkbox" type="checkbox" id="svc-edit-field-limits-${answer}-${id}" value="0">
                          <label class="form-check-label" for="svc-edit-field-limits-${answer}-${id}">Ограничения</label>
                        </div>
                    </div>`;
    $('#answerBtn').html(`<button id="svc-edit-btn-${answer}-${id}" type="button" class="btn btn-primary">Записать</button>`);
    if (answer == 'yes') { //ответ по справке
        textModal = `<div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <textarea class="form-control" id="svc-edit-field-answerText-${answer}-${id}" name="svc-edit-field-answerText-${answer}-${id}" placeholder="Введите текст справки" style="height: 200px"></textarea>
              <label for="svc-edit-field-answerText-${answer}-${id}">Введите текст справки</label>
              <div class="invalid-feedback">
                Введите информацию
              </div>                   
            </div>
          </div></div>`;
        showAnswerModal('Ведите данные для ответа', textOption+textModal);
    } else { // отказ по справке
        let reasonPreset = getReasonPreset(id);
        textModal = `<div class="row g-3 mb-3">
          <div class="col-md">
            <div class="form-floating">
              <textarea class="form-control" id="svc-edit-field-reason-${answer}-${id}" name="svc-edit-field-reason-${answer}-${id}" placeholder="Причина отказа" style="height: 200px"></textarea>
              <label for="svc-edit-field-reason-${answer}-${id}">Причина отказа</label>
              <div class="invalid-feedback">
                Введите информацию
              </div>                   
            </div>
          </div></div>`;        
        showAnswerModal('Укажите причину отказа', textOption+reasonPreset+textModal);
    }
}

function getReasonPreset(id) {
    let arrOption = [];
    let preset = '';
    let options = '';
    $.ajax({
      url: "data/denyReason.json",
      dataType: 'json',
      async: false,
      success: function(data) {
        $.each(data.reasons, function( index, value ) {
            arrOption.push(`<option value="${value.text}">${value.name}</option>`);
        });
        options = arrOption.join(''); 
      }
    });
    return preset = `                  <div class="col-md mb-3">
                        <div class="form-floating">
                          <select class="form-select" id="svc-edit-field-presetReason-${id}" aria-label="">
                            <option selected>---</option>
                            ${options}
                          </select>
                          <label for="svc-edit-field-presetReason-${id}">Выберите шаблон причины отказа</label>
                        </div>
                      </div>`;
}

$('body').on('change', '[id^="svc-edit-field-presetReason"]', function() {
    let id = $(this).attr('id').split("-")[4];
    $(`#svc-edit-field-reason-no-${id}`).val(this.value);
});

$('body').on('change', 'input[class*="svc-edit-checkbox"]', function() {
    let value = $(this).is(':checked') ? '1' : '0';
    $(this).val(value)
});

function editService(id, status, reason = null, answerText = null, pages = null, before2000 = null, limits = null) {
    $.ajax({
            url: 'data/editService.php',
            type: 'GET',
            async: false,
            data: { id: id, status: status, reason: reason, answerText: answerText, pages: pages, before2000: before2000, limits: limits },
            success: function(data) {
                let service = searchService(id, request.service);
                (data == 'done') ? logger(`${status} по услуге "${service.shortName}"`, request.num) : showNotifyModal(data, 'Ошибка');
            }
        });
}

function searchService(key, services) {
    let result = {};
    services.forEach(function(service){
        if (service.id == key)
          result = service;
    })    
    return result;
}

function showReplyModal(numberRequest) {
    request = getRequest(numberRequest);
    let svcList = '';
    let objInfo = '';
    let objDesc = '';
    let knum = '';
    let inum = '';
    let info = '';
    let location = '';
    let bday = '';
    let dul = '';
    let textBtn = '';
    $.each(request.service, function(index, value) {
        if (value.forHuman == 1) {
            objInfo = value.human.name;
            bday = (value.human.bDate) ? `д.р. ${value.human.bDate}, ` : '';
            dul = (value.human.dulNum) ? `ДУЛ: ${value.human.dulNum} ${value.human.dulDate} ${value.human.dulOrg}` : '';
            objDesc = bday+dul;
        } else {
            objInfo = value.realEstate.address;
            knum = (value.realEstate.knum) ? `КН: ${value.realEstate.knum}, ` : '';
            inum = (value.realEstate.inum) ? `инв. номер: ${value.realEstate.inum}, ` : '';
            info = (value.realEstate.info) ? `доп. инфо: ${value.realEstate.info}, ` : '';
            location = (value.realEstate.location) ? `местоположение: ${value.realEstate.location}` : '';
            objDesc = knum+inum+info+location;
        }
        if (value.status) {
            textBtn = value.status;
        } else {
            textBtn = `<div class="col-md-6 text-end"><button id="reply-svc-${value.num}-yes-${value.id}" type="button" class="btn btn-outline-success btn-sm2"><i class="bi bi-check2"></i></button></div>
                       <div class="col-md-6 text-start"><button id="reply-svc-${value.num}-no-${value.id}" type="button" class="btn btn-outline-danger btn-sm2"><i class="bi bi-x-lg"></i></button></div>`;
        }
        svcList += `<tr><td>${index+1}</td><td>${value.shortName}</td><td>${objInfo}</td><td>${objDesc}</td>
                    <td style="vertical-align: middle"><div id="action" class="row justify-content-md-center align-items-center">${textBtn}</div></td></tr>`;
    });
    let svcTbl = `<table class="table table-bordered table-sm mt-2">
                  <thead><tr><th>#</th><th>Услуга</th><th>Предмет услуги</th><th>Доп. информация</th><th>Действия</th></tr></thead>
                  <tbody>${svcList}</tbody></table>`;
    $('#replyText').html(svcTbl);
    $('#replyTitle').html(`Запрос №${request.num} от ${request.date}`);
    replyModal.show();
}

function showAnswerModal(title, text) {
    $('#answerText').html(text);
    $('#answerTitle').html(title);
    replyModal.hide();
    answerModal.show();
}

$('#answer').on('hidden.bs.modal', function () {
  showReplyModal(request.num);
})

$('#reply').on('shown.bs.modal', function () {
    let btn = $("button[id*='reply-svc']").length == 0 ? '<button id="newReply" type="button" class="btn btn-primary">Сформировать ответ</button>' : '';
    $('#replyBtn').html(btn);
})

$('body').on('click', '[id="newReply"]', function() {
    newReply(request);
    window.open(`/tpl/getReply.php?numLog=${request.num}`, "_blank");
    inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
});

function newReply(request) {
    $.ajax({
            url: 'data/new-reply.php',
            type: 'GET',
            async: false,
            data: {
                id: request.id,
            },
            success: function(data) {
                if (data == 'done') {
                    logger('Сформирован ответ по запросу', request.num);
                    replyModal.hide();
                    showSmallToast('bg-success', `Ответ на запрос ${request.num} сформирован.`, '20000');
                } else {
                    showNotifyModal(data, 'Ошибка');
                }
            }
    });
}