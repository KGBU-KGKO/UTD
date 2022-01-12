$.when($.ready).then(function() {

  let today = new Date();
  $('#reqOutDate').val(today.getFullYear() + "-" + ('0' + (today.getMonth()+1)).slice(-2)  + "-" + ('0' + today.getDate()).slice(-2));

  $.ajax({
      url: 'data/showRequests.php',
      type: 'GET',
      data: { status: "Новый" },
      success: function(data){
         $('#newReqTable').html(data);
      }
  });  
  $.ajax({
      url: 'data/showRequests.php',
      type: 'GET',
      data: { status: "В работе" },
      success: function(data){
         $('#inworkReqTable').html(data);
      }
  }); 

});

$("#newReqTable").on('click','a',function(){
  let reqInfoModal = new bootstrap.Modal($('#reqInfo'), {});
  addModalInfo($(this).html());
  reqInfoModal.show();
});

$("#inworkReqTable").on('click','a',function(){
  let reqInfoModal = new bootstrap.Modal($('#reqInfo'), {});
  addModalInfo($(this).html());
  reqInfoModal.show();
});

function addModalInfo(num) {
  $.ajax({
      url: 'data/getRequestInfo.php',
      type: 'GET',
      data: { numLog: num },
      success: function(data){
         $('#reqInfoContent').html(data);
      }
  });   
}

$("#newReqTable").on('click','tr',function(){
    $('#reqNumNew').val($(this).find('td').eq(0).text());
    $('html, body').animate({
        scrollTop: $("#reqNumNew").offset().top
    }, 50);     
});

$("#inworkReqTable").on('click','tr',function(){
    $('#reqNumWork').val($(this).find('td').eq(0).text());
    $('html, body').animate({
        scrollTop: $("#reqNumWork").offset().top
    }, 50);       
});

$("#inWork").click(function() {
  $('#performer').removeClass('is-invalid');
  $('#reqNumNew').removeClass('is-invalid');  

  if ($('#reqNumNew').val() == '') {
  $('#reqNumNew').addClass('is-invalid');
  return;
  }

  if ($('#performer option:selected').text() == '---') {
  $('#performer').addClass('is-invalid');
  return;
  }

  $.ajax({
      url: 'data/changeStatus.php',
      type: 'GET',
      data: { status: "В работе", num: $('#reqNumNew').val(), performer: $('#performer option:selected').text() },
      success: function(data){
        window.location.replace("requests.php");
      }
  }); 
});

$("#Complete").click(function() {
  $('#reqNumWork').removeClass('is-invalid');
  $('#reqOutDate').removeClass('is-invalid');
  $('#performerInWork').removeClass('is-invalid');  

  if ($('#reqNumWork').val() == '') {
    $('#reqNumWork').addClass('is-invalid');
  return;
  }

  if ($('#reqOutDate').val() == '') {
  $('#reqOutDate').addClass('is-invalid');
  return;
  }  

  if ($('#performerInWork option:selected').text() == '---') {
  $('#performerInWork').addClass('is-invalid');
  return;
  }

  $.ajax({
      url: 'data/new-reply.php',
      type: 'GET',
      data: { status: "Выполнен", reqNum: $('#reqNumWork').val(), repNum: $('#reqOutNum').val(), repDate: $('#reqOutDate').val(), repPerformer: $('#performerInWork option:selected').text() },
      success: function(data){
        data = $.parseJSON(data);
        window.open("/tpl/printReply.php?numLog="+data.numLog+"&ID="+data.ID, "_blank");
        window.location.replace("requests.php");
      }
  }); 
});

$("#Paid").click(function() {
  $('#reqNumWork').removeClass('is-invalid');

  if ($('#reqNumWork').val() == '') {
  $('#reqNumWork').addClass('is-invalid');
  return;
  }
 
  $.ajax({
      url: 'data/changeStatus.php',
      type: 'GET',
      data: { status: "Оплачен", num: $('#reqNumWork').val()},
      success: function(data){
        if (data == 'done') {
          window.location.replace("requests.php");
        } else {
          console.log('Ошибка: '+data);
        }
      }
  }); 
});

$("#Issue").click(function() {
  $('#reqNumWork').removeClass('is-invalid');

  if ($('#reqNumWork').val() == '') {
  $('#reqNumWork').addClass('is-invalid');
  return;
  }
 
  $.ajax({
      url: 'data/changeStatus.php',
      type: 'GET',
      data: { status: "Ожидает выдачи", num: $('#reqNumWork').val()},
      success: function(data){
        if (data == 'done') {
          window.location.replace("requests.php");
        } else {
          console.log('Ошибка: '+data);
        }
      }
  }); 
});

$("#Cancel").click(function() {
  $('#reqNumWork').removeClass('is-invalid');
  $('#reqOutDate').removeClass('is-invalid');
  $('#performerInWork').removeClass('is-invalid');  

  if ($('#reqNumWork').val() == '') {
    $('#reqNumWork').addClass('is-invalid');
  return;
  }

  if ($('#reqOutDate').val() == '') {
  $('#reqOutDate').addClass('is-invalid');
  return;
  }  

  if ($('#performerInWork option:selected').text() == '---') {
  $('#performerInWork').addClass('is-invalid');
  return;
  }

  $.ajax({
      url: 'data/new-reply.php',
      type: 'GET',
      data: { status: "Отказано", reqNum: $('#reqNumWork').val(), repNum: $('#reqOutNum').val(), repDate: $('#reqOutDate').val(), repPerformer: $('#performerInWork option:selected').text() },
      success: function(data){
        data = $.parseJSON(data);
        window.open("/tpl/printReply.php?numLog="+data.numLog+"&ID="+data.ID, "_blank");        
        window.location.replace("requests.php");
      }
  }); 
});

$("#printList").click(function() {
  window.open("/tpl/printRegister.php", "_blank");
});