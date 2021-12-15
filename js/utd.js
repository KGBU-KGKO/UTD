$.when( $.ready ).then(function() {
  $('#numSMEV').prop('disabled', "true");
  $('#reqNum').val('02-20/2628');

  //   console.log(new Date());
  // $('#reqDate').val($.now());


});


$('#agentFLSwitch').change(function() {
  if ($(this).prop('checked')) {
    $('#agentFLForm').show();
  } else {
    $('#agentFLForm').hide();
  }
})

$('#declarantType').on('change', function() {
  $('.declarant').hide();
  $('#numSMEV').prop('disabled', "true");
  switch (this.value) {
    case 'ФЛ':
      $('#declarantFL').show();
      break;
    case 'ЮЛ':
      $('#declarantUL').show();
      break;
    case 'ОГВ':
      $('#declarantOGV').show();
      $('#numSMEV').prop('disabled', "");
      break;  }
});

$( ".attach button" ).click(function() {
  if (!$('#attachList').val()) {
    $('#attachList').val($(this).text());
  } else {
    let attachList = $('#attachList').val().split(', ');
    if($.inArray($(this).text(), attachList) == -1) {
      $('#attachList').val($('#attachList').val()+', '+$(this).text());      
    }
  }
});

$( "#send" ).click(function() {

});

// $.when(
//   $.getJSON( "ajax/test.json" ),
//   $.ready
// ).done(function( data ) {
//   // Document is ready.
//   // Value of test.json is passed as `data`.
// });