let notifyToast = bootstrap.Toast.getOrCreateInstance($('#notifyToast'));
let uploadTable = $('#uploadTable').bootstrapTable({
           pagination: true,
           search: true,
         });


$.when($.ready).then(function() {
  uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
new Chart(document.getElementById("line-chart"), {
  type: 'line',
  data: {
    labels: [10.01,11.01,12.01,13.01,14.01],
    datasets: [{ 
        data: [5,10,7,8,5],
        label: "ФЛ",
        borderColor: "#198754",
        backgroundColor: "#198754",
        fill: false
      }, { 
        data: [2,3,5,3,2],
        label: "ЮЛ",
        borderColor: "#ffc107",
        backgroundColor: "#ffc107",
        fill: false
      }, { 
        data: [10,12,15,10,6],
        label: "СМЭВ",
        borderColor: "#dc3545",
        backgroundColor: "#dc3545",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false,
      text: 'Поступление запрос за текущую неделю'
    }
  }
});

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

function notify(status, text) {
  $('#notifyToastBody').html(text);
  $('#notifyToast').addClass('bg-'+status);
  notifyToast.show();
}

function numFormatter(value) {
    return '<a href="#">' + value + '</a>';
}

function customSort(sortName, sortOrder, data) {
  var order = sortOrder === 'desc' ? -1 : 1
  data.sort(function (a, b) {
    var aa = +((a[sortName] + '').replace(/[^\d]/g, ''))
    var bb = +((b[sortName] + '').replace(/[^\d]/g, ''))
    if (aa < bb) {
      return order * -1
    }
    if (aa > bb) {
      return order
    }
    return 0
  })
}

$("#uploadTable").on('click','tr',function(){
    $('#numReq').removeClass('is-invalid');
    $('#numReq').val($(this).find('td').eq(0).text());
    // if (event.target.nodeName != 'A') {
    //   $('html, body').animate({
    //       scrollTop: $("#numReq").offset().top-100
    //   }, 50);         
    // }
});

$("#uploadTable").on('click','a',function(){
    window.open('/tpl/form'+$(this).parents().eq(1).find('td').eq(1).text()+'.php?numLog='+$(this).html(), '_blank');
});

$("input[name=reqFiles]").change(function() {
    $('#reqFiles').removeClass('is-invalid');
    let names = [];
    let text = '';
    for (var i = 0; i < $(this).get(0).files.length; ++i) {
        names.push($(this).get(0).files[i].name);
    }
    $.each(names, function( index, value ) {
      text = text + value + '<br>';
    });
    $("#nameFiles").html(text);
});


$("#upload").click(function() {
  if ($('#numReq').val() == '') {
  $('#numReq').addClass('is-invalid');
  return;
  }

  if ($('#reqFiles').val() == '') {
  $('#reqFiles').addClass('is-invalid');
  return;
  }  

    // upload files
    let num = $('#numReq').val();
    let isPaid = $('#isPaid').prop('checked');
    let data = new FormData();
    $.each($('#reqFiles')[0].files, function(i, file) {
        data.append('file[]', file);
    });
    data.append('num', num);
    data.append('isPaid', isPaid);

    $.ajax({
        url: 'data/upload.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(data){
            if (data.split(" ")[0] == 'Ошибка') {
                $('#numReq').val('');
                uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
                notify('danger', data);
            } else {
                $('#numReq').val('');
                uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
                notify('success', data);
            }
        }
    });

});

$("#remove").click(function() {
  $('#numReq').removeClass('is-invalid');
  if ($('#numReq').val() == '') {
  $('#numReq').addClass('is-invalid');
  return;
  }    
  let removeAlertModal = new bootstrap.Modal($('#removeAlert'), {});
  $('#numForDelete').html($('#numReq').val());
  removeAlertModal.show();
});    

$("#deleteReq").click(function() {
  $.ajax({
      url: 'data/changeStatus.php',
      type: 'GET',
      data: { status: "Удалён-Свободен", num: $('#numForDelete').html() },
      success: function(data){
        if (data == 'done') {
          window.location.replace("index.php");
        } else {
          console.log('Ошибка: '+data); //тут сделать тост
        }
      }
  }); 
});  

$("#printIn").click(function() {
  window.open('/tpl/inLog.php?logDateStart='+$('#inDate').val(), '_blank');
});  