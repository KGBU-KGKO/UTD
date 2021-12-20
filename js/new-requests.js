$.when($.ready).then(function() {
    $('#numSMEV').prop('disabled', "true");
    $.removeCookie('listFL');
    $.ajax({
        url: 'data/new-request.php',
        method: 'GET',
        data: { getNumLog: "true" },
        success: function(data){
            numLogData = data.split("/");
            num = parseInt(numLogData[1]);
            num++;
            let zeros = '';
            for (let i = 0; i < num.toString().length; i++) { 
              zeros = zeros + '0';
            }
            $('#reqNum').val(numLogData[0] + "/" + zeros + num.toString());
            $('#numTitle').html($('#reqNum').val());
        }
    });

    //   console.log(new Date());
    // $('#reqDate').val($.now());

    //Enable tooltips everywhere
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })    

});

$( "#dFLName" ).on( "autocompleteselect", function( event, ui ) {
    //console.log(ui.item.value);
    //console.log(ui.item.label);
    let listDec = [];
    decID = ui.item.label.split(" | ")[3];
    listDec = $.parseJSON(eval($.cookie('listFL')));
    index = listDec.findIndex(x => x.ID === decID);
    $('#dFLAddress').val(listDec[index].address);
} );

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

$('#agentFLSwitch').change(function() {
    if ($(this).prop('checked')) {
        $('#agentFLForm').show();
    } else {
        $('#agentFLForm').hide();
    }
})

$('#reqNum').on('input', function() {
    $('#numTitle').html($('#reqNum').val());
})

$('#declarantType').on('change', function() {
    $('.declarant').hide();
    $('#numSMEV').prop('disabled', "true");
    switch (this.value) {
        case 'FL':
            $('#declarantFL').show();
            let listFL = [];
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data){
                    $.cookie("listFL", JSON.stringify(data));
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key,value) {
                      listFL.push({label: value.name + " | " +value.dulNum+ " | " + value.dateBirth+ " | " + value.ID, value: value.name});
                    }); 

                    $( "#dFLName" ).autocomplete({
                      source: listFL
                    });
                }
            }); 
            break;
        case 'UL':
            $('#declarantUL').show();
            break;
        case 'OGV':
            $('#declarantOGV').show();
            $('#numSMEV').prop('disabled', "");
            break;
    }
});

$(".attach button").click(function() {
    if (!$('#attachList').val()) {
        $('#attachList').val($(this).text());
    } else {
        let attachList = $('#attachList').val().split(', ');
        if ($.inArray($(this).text(), attachList) == -1) {
            $('#attachList').val($('#attachList').val() + ', ' + $(this).text());
        }
    }
});

$("#send").click(function() {
    let decType = $('#declarantType').val();
    switch (decType) {
        case 'FL':
            console.log('decType=' + decType + '&' + $('#reqFL').serialize() +'&'+ $('#reqInfo').serialize());
            break;
        case 'UL':
            console.log('decType=' + decType + '&' + $('#reqUL').serialize() +'&'+ $('#reqInfo').serialize());
            break;
        case 'OGV':
            console.log('decType=' + decType + '&' + $('#reqOGV').serialize() +'&'+ $('#reqInfo').serialize() +'&'+ $('#formFiles').serialize());
            break;
    }



var data = new FormData();
$.each($('#reqFiles')[0].files, function(i, file) {
    data.append('file[]', file);
});

$.ajax({
    url: 'data/new-request.php',
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    method: 'POST',
    success: function(data){
        //console.log(data);
    }
});


});

$("#clearForms").click(function() {
    $('form').trigger("reset");
    $("#nameFiles").html('');
});



// $.when(
//   $.getJSON( "ajax/test.json" ),
//   $.ready
// ).done(function( data ) {
//   // Document is ready.
//   // Value of test.json is passed as `data`.
// });