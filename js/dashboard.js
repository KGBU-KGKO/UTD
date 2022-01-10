$.when($.ready).then(function() {

  $.ajax({
      url: 'data/showRequests.php',
      type: 'GET',
      data: { status: "Ожидает загрузки" },
      success: function(data){
         $('#waitUploadTable').html(data);
      }
  }); 

});

$("#waitUploadTable").on('click','tr',function(){
    $('#numReq').removeClass('is-invalid');
    $('#numReq').val($(this).find('td').eq(0).text());
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
    let data = new FormData();
    $.each($('#reqFiles')[0].files, function(i, file) {
        data.append('file[]', file);
    });
    data.append('num', num);

    $.ajax({
        url: 'data/upload.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(data){
            if (data.split(" ")[0] == 'Ошибка') {
                window.location.replace("index.php?error="+data);
            } else {
                window.location.replace("index.php?success="+data);
            }
        }
    });

});