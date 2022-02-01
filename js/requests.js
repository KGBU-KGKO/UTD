let newReqTable = $('#newReqTable').bootstrapTable({
           pagination: true,
           search: true,
         });
let inworkReqTable = $('#inworkReqTable').bootstrapTable({
           pagination: true,
           search: true,
         });
let denyModal = new bootstrap.Modal($('#deny'), {});
let notifyModal = new bootstrap.Modal($('#notify'), {});
let replyModal = new bootstrap.Modal($('#reply'), {});

$.when($.ready).then(function() {

  let today = new Date();
  $('#reqOutDate').val(today.getFullYear() + "-" + ('0' + (today.getMonth()+1)).slice(-2)  + "-" + ('0' + today.getDate()).slice(-2));

  newReqTable.bootstrapTable('load', getDataTable("Новый"));
  inworkReqTable.bootstrapTable('load', getDataTable("В работе"));

  if (newReqTable.bootstrapTable('getData').length == '0') {
    $('#newReqData').addClass('d-none');
    $('#newReqDataEmpty').removeClass('d-none');
  }

});

function getDataTable(dataStatus) {
  dataTbl = $.ajax({
      url: 'data/showRequests.php',
      type: 'GET',
      async : false,
      data: { status: dataStatus },
      success: function(data){
         return data;
      }
  }); 
  return $.parseJSON(dataTbl.responseText)
}

function showNotifyModal(text) {
  $('#txtInfo').html(text);
  notifyModal.show();
}

function numFormatter(value) {
  if (value) {
    return '<a href="#">' + value + '</a>';
  }
}

function payFormatter(value) {
  if (value) {
    return '<p class="text-center m-0"><i class="bi bi-check2-square text-success fs-5" ></i></p>';
  }
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
    return value.type;
}

function decFormatter(value) {
    return value.name;
}

function perfFormatter(value) {
    return value.name;
}

function customSort(sortName, sortOrder, data) {
  let order = sortOrder === 'desc' ? -1 : 1
  data.sort(function (a, b) {
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

$("#newReqTable").on('click','a',function(){
  let reqInfoModal = new bootstrap.Modal($('#reqInfo'), {});
  addModalInfo($(this).html(), $(this).parents().eq(1).find('td').eq(1).text().split(" ")[0]);
  reqInfoModal.show();
});

$("#inworkReqTable").on('click','a',function(){
  let reqInfoModal = new bootstrap.Modal($('#reqInfo'), {});
  addModalInfo($(this).html(), $(this).parents().eq(1).find('td').eq(1).text().split(" ")[0]);
  reqInfoModal.show();
});

function addModalInfo(num, type) {
  $.ajax({
      url: 'data/getRequestInfo.php',
      type: 'GET',
      data: { numLog: num, typeDec: type },
      success: function(data){
         $('#reqInfoContent').html(data);
      }
  });   
}

$("#newReqTable").on('click','tr',function(){
    $('#reqNumNew').val($(this).find('td').eq(0).text());
    // if (event.target.nodeName != 'A') {
    //   $('html, body').animate({
    //       scrollTop: $("#reqNumNew").offset().top
    //   }, 50);         
    // }      
});

$("#inworkReqTable").on('click','tr',function(){
    $('#reqNumWork').val($(this).find('td').eq(0).text());
    // if (event.target.nodeName != 'A') {
    //   $('html, body').animate({
    //       scrollTop: $("#reqNumWork").offset().top
    //   }, 50);         
    // }    
});

$("#inWork").click(function() {
  if (!validateForm(['reqNumNew', 'select:performer'])) {
    return;
  }

  $.ajax({
      url: 'data/changeStatus.php',
      type: 'GET',
      data: { status: "В работе", num: $('#reqNumNew').val(), performer: $('#performer option:selected').text() },
      success: function(data){
        if (data == 'done') {
        } else {
            showNotifyModal(data);
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
      data: { status: "Оплачен", num: $('#reqNumWork').val()},
      success: function(data){
        if (data == 'done') {
        } else {
            showNotifyModal(data);
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
      data: { status: "Выполнен", num: $('#reqNumWork').val()},
      success: function(data){
        if (data == 'done') {
        } else {
            showNotifyModal(data);
        }
        $('#reqNumWork').val("");
        inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
      }
  }); 
});

$("#Cancel").click(function() {
  if (!validateForm(['reqNumWork', 'select:performerInWork'])) {
    return;
  }
  request = getRequest($('#reqNumWork').val(), "inworkReqTable", "Отказ");
  check = checkRequest(request);
  if (check.status == "yes") {
    //переделать на тосты
    showNotifyModal(check.text);
    $('#reqNumWork').val("");
    inworkReqTable.bootstrapTable('load', getDataTable("В работе")); 
    return;
  }  
  prepareReply(request, "Отказ");
});

$("#denyReq").click(function() {
  if (!validateForm(['denyTxt'])) {
    return;
  }
  request = getRequest($('#reqNumWork').val(), "inworkReqTable", "Отказ");
  request.svc[0].reason = $('#denyTxt').val();
  request.performer = $('#performerInWork option:selected').text();
  request.replayDate = $('#reqOutDate').val();
  createReply(request);
  denyModal.hide();
});  

$("#multiReply").click(function() {
  let id = [];
  let reasons = "", answers = "";
  $('[id^="reason-"]').each(function() {
      id.push(this.id);
  });  
  if (!validateForm(id)) {
    return;
  }  
  request = getRequest($('#reqNumWork').val(), "inworkReqTable", "");
  request.performer = $('#performerInWork option:selected').text();
  request.replayDate = $('#reqOutDate').val();    
  $.each(request.svc, function(index, value) {
    answer = $(`#responseSVC-${++index} option:selected`).text();
    answers = answers + ";" + answer;
    if (answer == 'Отказ') {
      reason = $(`#reason-${index}`).val();
      reasons = reasons + ";" + reason;  
    }
  });
  answers = answers.substr(1);
  reasons = reasons.substr(1);
  request.svc = [];
  request.svc.push({name: 'Несколько услуг', answer: "", reason: reasons, answers: answers});
  if (answers.includes("Ответ", 0) && answers.includes("Отказ", 0)) {
    request.svc[0].answer = "Отказ/Ответ";
  }
  if (!answers.includes("Ответ", 0)) {
    request.svc[0].answer = "Отказ";
  }
  if (!answers.includes("Отказ", 0)) {
    request.svc[0].answer = "Ответ";
  } 
  replyModal.hide();
  createReply(request);
});  

$("#Answer").click(function() {
  if (!validateForm(['reqNumWork', 'select:performerInWork'])) {
    return;
  }
  request = getRequest($('#reqNumWork').val(), "inworkReqTable", "Ответ");
  request.performer = $('#performerInWork option:selected').text();
  request.replayDate = $('#reqOutDate').val();  
  check = checkRequest(request);
  if (check.status == "yes") {
    //переделать на тосты
    showNotifyModal(check.text);
    $('#reqNumWork').val("");
    inworkReqTable.bootstrapTable('load', getDataTable("В работе")); 
    return;
  }
  prepareReply(request, "Ответ");
});

$('#denyTxtSelect').on('change', function() {
  denySel = $('#denyTxtSelect option:selected').val();
  $.getJSON("data/denyReason.json", function(data){
    $('#denyTxt').val(data['var'+denySel]);
  }).fail(function(){
      console.log("An error has occurred.");
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
        if ($('#'+value+' option:selected').text() == '---') { 
          item = '';
        } else {
          item = $('#'+value+' option:selected').text();
        }
      } else {
        item = $('#'+value).val(); 
      }
      $('#'+value).removeClass('is-invalid');
      if (!item) {
        $('#'+value).addClass('is-invalid');
        result = false;
      } 
    });
  return result;
}

function prepareReply(request, answer) {
  $('#replyBody').html('');
  if (request.svc.length > 1) {
    //множественный ответ или отказ
    $.each(request.svc, function(index, value) {
      let yes = "", no = "", dnone = "", readonly = "";
      if (value.answer == 'Ответ') {
        yes = 'selected'; 
        dnone = 'd-none';
        readonly = 'readonly';
      } else {
        no = 'selected';
      }
      //let itemindex = index+1;
      let item = `<div class="row g-3 mb-2 me-2" id="svc-${++index}">
                  <div class="col-md-8">
                    <div class="form-floating">
                      <input type="text" readonly class="form-control-plaintext" id="svc-${index}" value="${index}. ${value.name}" placeholder="Наименование услуги">
                      <label for="svc-1" class="visually-hidden">Услуга</label>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-floating">
                      <select class="form-select answer" id="responseSVC-${index}" aria-label="Floating label select">
                        <option ${yes} value="1">Ответ</option>
                        <option ${no} value="2">Отказ</option>
                      </select>
                      <label for="responseSVC-${index}">Выберите резолюцию</label>
                    </div>
                  </div>
                  </div>
                  <div class="row g-3 mb-1 ${dnone}" id="reasonText-${index}">
                  <div class="row g-3 mb-1">
                    <div class="col-md">
                      <div class="form-floating">
                        <select class="form-select" id="denyManyTxtSelect-${index}" aria-label="Floating label select">
                          <option selected>---</option>
                          <option value="1">отсутствием инвентарного дела</option>
                        </select>
                        <label for="denyManyTxtSelect-${index}">Выберите шаблон причины отказа</label>
                      </div>
                    </div>
                  </div> 
                    <div class="row g-3 mb-3">
                      <div class="form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="reason-${index}" name="reason-${index}" style="height: 200px" ${readonly}></textarea>
                        <label class="px-4" for="denyTxt">Причина отказа </label>
                      </div> 
                    </div>                  
                  </div>`;
      $('#replyBody').append(item);
    });
    $('#replyNumTitle').html(request.num);
    replyModal.show();
  } else {
    if (answer == "Отказ") {
      //единственный отказ
      $('#denyNum').html(request.num);
      denyModal.show();      
    } else {
      //единственный ответ
      createReply(request);
    }   
  }

}

function checkRequest(request) {
  check = $.ajax({
              url: 'data/new-reply.php',
              type: 'GET',
              async : false,
              data: { checkRequest: true, reqNum: request.num},
              success: function(data){
                return data;
              }
          }); 
  return $.parseJSON(check.responseText);
}

function createReply(request) {
  // записать отказ в бд
  repData = writeReplyDB(request);
  if (repData.status) {
    //переделать на тосты
    showNotifyModal(repData.status);
    return;
  }
  // отдать печатную форму
  window.open(`/tpl/getReply.php?numInLog=${request.num}&numOutLog=${repData.numLog}`, "_blank");
  // отдать тост
  // обновить таблицу
  $('#reqNumWork').val("");
  inworkReqTable.bootstrapTable('load', getDataTable("В работе"));
}

// function createReplyCancel(request) {
//   $.each(request.svc, function(index, item) {
//     data = $.parseJSON(writeReplyDB(request, index));
//     //в ответ мне нужно получить номер ответа
//     switch (item) {
//       case "Тех. паспорт":
//         //отдаем word
//         window.open(`/tpl/getReply.php?numInLog=${request.num}&numOutLog=${data.num}&tpl=${item}`, "_blank");        
//         //тут нужно перегрузить таблицу
//         window.location.replace("requests.php");        
//         break;
//       case "ПД":
//         console.log("ПД");
//         break;
//       case "Выписка":
//       case "План":
//       case "Справка1":
//       case "Справка2":
//       case "Справка3":
//       case "Справка4":
//         window.open("/tpl/printReply.php?numLog="+data.numLog+"&ID="+data.ID, "_blank");
//         break;
//       default:
//         console.log( "Что-то пошло не так... :(" );
//     }    
//   });    
// }

// function createReplyAnswer(services, action, num) {
//   //
// }

function writeReplyDB(request) {
  let statusRep = "";
  if (request.svc[0].name == "Несколько услуг") {
    statusRep = request.svc[0].answers;
  }
  dataReply = $.ajax({
              url: 'data/new-reply.php',
              type: 'GET',
              async : false,
              data: { status: request.svc[0].answer,
                      statusRep: statusRep,
                      reqNum: request.num, 
                      repDate: request.replayDate, 
                      repPerformer: request.performer,
                      reason: request.svc[0].reason},
              success: function(data){
                return data;
              }
          }); 
  return $.parseJSON(dataReply.responseText);
}

function getRequest(num, table, answer = "") {
  let request = {
    num: num,
    svc: [],
    data: {},
  };
  let svc = $(`#${table}  td:contains(${num})`).parents('tr').find('td').eq(4).text().split(', ');
  $.each(svc, function(index, value) {
    request.svc.push({name: value, answer: answer});
  });

  return request;
}

$('#reply').on('change', '.answer', function () {
    id = $(this).attr('id').split("-")[1];
    $(`#reasonText-${id}`).toggleClass("d-none");
    $(`#reason-${id}`).attr('readonly') ? $(`#reason-${id}`).attr('readonly', false) : $(`#reason-${id}`).attr('readonly', true)
});

$('#reply').on('change', 'select[id^="denyManyTxtSelect-"]', function () {
    num = $(this).attr('id').split("-")[1];
    denySel = $(`#denyManyTxtSelect-${num} option:selected`).val();
    $.getJSON("data/denyReason.json", function(data){
      $(`#reason-${num}`).val(data[`var${denySel}`]);
    }).fail(function(){
        console.log("An error has occurred.");
    });
});
