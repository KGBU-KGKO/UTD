$.when($.ready).then(function() {
    localStorage.setItem("listFL", "");
    localStorage.setItem("listAgents", "");
    localStorage.setItem("listUL", "");
    localStorage.setItem("listOGV", "");
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

    let today = new Date();
    $('#reqDate').val(today.getFullYear() + "-" + (today.getMonth()+1)  + "-" + today.getDate());

    //Enable tooltips everywhere
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

});

$( "#dFLName" ).on( "autocompleteselect", function( event, ui ) {
    //console.log(ui.item.value);
    //console.log(ui.item.label);
    decID = ui.item.label.split(" | ")[3];
    listFL = $.parseJSON(localStorage.getItem("listFL"));
    index = listFL.findIndex(x => x.ID === decID);
    $('#dFLAddress').val(listFL[index].address);
    $('#dFLEmail').val(listFL[index].email);
    $('#dFLPhone').val(listFL[index].tel);
    $('#dFLBD').val(listFL[index].dateBirth);
    $('#dFLNumDUL').val(listFL[index].dulNum);
    $('#dFLDateDUL').val(listFL[index].dulDate);
    $('#dFLWhoDUL').val(listFL[index].dulOrg);
} );

$( "#dFLAgentName" ).on( "autocompleteselect", function( event, ui ) {
    let listAgents = [];
    agID = ui.item.label.split(" | ")[3];
    listAgents = $.parseJSON(localStorage.getItem("listAgents"));
    index = listAgents.findIndex(x => x.ID === agID);
    $('#dFLPhone').val(listAgents[index].tel);
    $('#dFLAgentAddress').val(listAgents[index].address);
    $('#dFLNumDUL').val(listAgents[index].dulNum);
    $('#dFLDateDUL').val(listAgents[index].dulDate);
    $('#dFLWhoDUL').val(listAgents[index].dulOrg);
} );

$( "#dULName" ).on( "autocompleteselect", function( event, ui ) {
    decID = ui.item.label.split(" | ")[3];
    listUL = $.parseJSON(localStorage.getItem("listUL"));
    index = listUL.findIndex(x => x.ID === decID);
    $('#dULINN').val(listUL[index].INN);
    $('#dULOGRN').val(listUL[index].OGRN);
    $('#dULAddress').val(listUL[index].address);
    $('#dULEmail').val(listUL[index].email);
    $('#dULPhone').val(listUL[index].tel);
} );

$( "#dULAgentName" ).on( "autocompleteselect", function( event, ui ) {
    let listAgents = [];
    agID = ui.item.label.split(" | ")[3];
    listAgents = $.parseJSON(localStorage.getItem("listAgents"));
    index = listAgents.findIndex(x => x.ID === agID);
    $('#dULAgentPhone').val(listAgents[index].tel);
    $('#dULAgentAddress').val(listAgents[index].address);
    $('#dULNumDUL').val(listAgents[index].dulNum);
    $('#dULDateDUL').val(listAgents[index].dulDate);
    $('#dULWhoDUL').val(listAgents[index].dulOrg);
} );

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

// function getRef(referenceType, declarantType, storageName, inputName, haveDUL, listAttr) {
//     let listRef = [];
//     $.ajax({
//         url: 'data/getRef.php',
//         method: 'GET',
//         data: { ref: referenceType, decType: declarantType },
//         success: function(data){
//             localStorage.setItem(storageName, data);
//             let obj = $.parseJSON(data);
//             if (haveDUL) {
//                 $.each(listAttr, function(value) {
//                     rowRef = value + ' + " | " +value.';
//                 });
//                 rowRef = '{label: value.' + rowRef + ', value: value.name}';
//             }
//             $.each(obj, function(key,value) {
//               listRef.push(rowRef);
//             }); 

//             $( "#"+inputName ).autocomplete({
//               source: listRef
//             });
//         }
//     });     
// }

$('#declarantType').on('change', function() {
    let listFL = [];
    let listUL = [];
    let listOGV = [];
    let listAgents = []; 
    let dull = '';   
    $('.declarant').hide();
    switch (this.value) {
        case 'FL':
            $('#declarantFL').show();
            //getRef('declarant', this.value, 'listFL', 'dFLName', 'True', ['name', 'dulNum', 'dateBirth', 'ID']);
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data){
                    localStorage.setItem("listFL", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key,value) {
                      if (value.dulNum) 
                        {dull = value.dulNum.substring(0,4)+ " " +value.dulNum.substring(4,10);} 
                      else 
                        {dull = "-";}
                      listFL.push({label: value.name + " | " +dull+ " | " + value.dateBirth+ " | " + value.ID, value: value.name});
                    }); 

                    $( "#dFLName" ).autocomplete({
                      source: listFL
                    });
                }
            }); 
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "agent", decType: this.value },
                success: function(data){
                    localStorage.setItem("listAgents", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key,value) {
                      listAgents.push({label: value.FIO + " | " +value.dulNum.substring(0,4)+ " " +value.dulNum.substring(4,10)+ " | " + value.tel+ " | " + value.ID, value: value.FIO});
                    }); 

                    $( "#dFLAgentName" ).autocomplete({
                      source: listAgents
                    });
                }
            });         

            break;
        case 'UL':
            $('#declarantUL').show();
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data){
                    localStorage.setItem("listUL", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key,value) {
                      listUL.push({label: value.name + " | " +value.INN+ " | " + value.OGRN+ " | " + value.ID, value: value.name});
                    }); 

                    $( "#dULName" ).autocomplete({
                      source: listUL
                    });
                }
            });    
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "agent", decType: this.value },
                success: function(data){
                    localStorage.setItem("listAgents", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key,value) {
                      listAgents.push({label: value.FIO + " | " +value.dulNum.substring(0,4)+ " " +value.dulNum.substring(4,10)+ " | " + value.tel+ " | " + value.ID, value: value.FIO});
                    }); 

                    $( "#dULAgentName" ).autocomplete({
                      source: listAgents
                    });
                }
            });                      
            break;
        case 'OGV':
            $('#declarantOGV').show();
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data){
                    localStorage.setItem("listOGV", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key,value) {
                      listOGV.push({label: value.name + " | " + value.ID, value: value.name});
                    }); 

                    $( "#dOGVName" ).autocomplete({
                      source: listOGV
                    });
                }
            });            
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
    let decInfo = '';
    let param = '';
    switch (decType) {
        case 'FL':
            decInfo = $('#reqFL').serialize();
            break;
        case 'UL':
            decInfo = $('#reqUL').serialize();
            break;
        case 'OGV':
            decInfo = $('#reqOGV').serialize();
            break;
    }

param = 'decType=' + decType + '&' + decInfo +'&'+ $('#reqInfo').serialize();

$.ajax({
    url: 'data/new-request.php',
    method: 'GET',
    data: param,
    success: function(data){
        data = $.parseJSON(data);
        window.location.replace("new-request.php?toast="+data.numLog+"&ID="+data.ID);
    }
});




});

$("#clearForms").click(function() {
    $('form').trigger("reset");
});