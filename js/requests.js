$.when($.ready).then(function() {

  let today = new Date();
  //$('#reqDate').val(today.getFullYear() + "-" + (today.getMonth()+1)  + "-" + today.getDate());

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

