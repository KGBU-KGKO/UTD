$.when($.ready).then(function() {

  let today = new Date();
  $('#reqOutDate').val(today.getFullYear() + "-" + (today.getMonth()+1)  + "-" + today.getDate());

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

$("#newReqTable").on('click','tr',function(){
    $('#reqNumNew').val($(this).find('td').eq(0).text());
});

$("#inworkReqTable").on('click','tr',function(){
    $('#reqNumWork').val($(this).find('td').eq(0).text());
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
        console.log(data);
        window.location.replace("requests.php");
      }
  }); 
});

$("#Complete").click(function() {
  $('#reqNumWork').removeClass('is-invalid');
  $('#reqOutNum').removeClass('is-invalid');  

  if ($('#reqNumWork').val() == '') {
  $('#reqNumWork').addClass('is-invalid');
  return;
  }

  if ($('#reqOutNum').val() == '') {
  $('#reqOutNum').addClass('is-invalid');
  return;
  }  
  $.ajax({
      url: 'data/changeStatus.php',
      type: 'GET',
      data: { status: "Выполнен", num: $('#reqNumWork').val(), reqOutNum: $('#reqOutNum').val(), reqOutNum: $('#reqOutDate').val() },
      success: function(data){
        console.log(data);
        window.location.replace("requests.php");
      }
  }); 
});

$("#printList").click(function() {
  console.log('Напечатал реестр');
});