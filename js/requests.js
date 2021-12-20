$.when($.ready).then(function() {
  $.ajax({
      url: 'data/showRequests.php',
      type: 'GET',
      success: function(data){
         $('#newReqTable').html(data);
      }
  });  

});

