$.when($.ready).then(function() {

//$("#toast").show();

});

$("input[name=reqFiles]").change(function() {
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

// upload files
        // var data = new FormData();
        // $.each($('#reqFiles')[0].files, function(i, file) {
        //     data.append('file[]', file);
        // });

        // $.ajax({
        //     url: 'data/new-request.php',
        //     data: data,
        //     cache: false,
        //     contentType: false,
        //     processData: false,
        //     method: 'POST',
        //     success: function(data){
        //         console.log('ok-ok'+data);
        //     }
        // });