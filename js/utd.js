$.when( $.ready ).then(function() {
  console.log('123');
});

$('#agentSwitch').on('switchChange.bootstrapSwitch', function (event, state) {
  console.log(state);
}); 

// $.when(
//   $.getJSON( "ajax/test.json" ),
//   $.ready
// ).done(function( data ) {
//   // Document is ready.
//   // Value of test.json is passed as `data`.
// });