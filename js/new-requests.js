$.when($.ready).then(function() {
    localStorage.setItem("listFL", "");
    localStorage.setItem("listAgents", "");
    localStorage.setItem("listUL", "");
    localStorage.setItem("listOGV", "");

    let today = new Date();
    $('#reqDate').val(today.getFullYear() + "-" + ('0' + (today.getMonth()+1)).slice(-2)  + "-" + ('0' + today.getDate()).slice(-2));

    //Enable tooltips everywhere
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    $(".address").suggestions({
        token: "34152e12e60fe6b7ef2a2682e1fe675021cedd05",
        type: "ADDRESS",
        onSelect: function(suggestion) {
            //console.log(suggestion);
        }
    });

    $("#dULINN").suggestions({
        token: "34152e12e60fe6b7ef2a2682e1fe675021cedd05",
        type: "PARTY",
        onSelect: function(suggestion) {
          let data = suggestion.data;
          if (!data)
            return;
        $("#dULName").val(data.name.short_with_opf);
        $("#dULINN").val(data.inn);
        $("#dULOGRN").val(data.ogrn);
        if (data.address)
        $("#dULAddress").val(data.address.value);
        $("#dULEmail").val('');
        $("#dULPhone").val('')
/* нету в бесплатном тарифе dadata
        if (data.emails) {
            $("#dULEmail").val(data.emails[0].value);    
        }
        if (data.phones)
        $("#dULPhone").val(data.phones[0].value);
*/ 
        }
       
    });    

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

// собственые подсказки из базы по юрлицам
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

$('#likeAddress').change(function() {
    if ($(this).prop('checked')) {
        $('#reqObjAddress').val($('#dFLAddress').val());
    } else {
        $('#reqObjAddress').val('');
    }
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
    $('#likeAddress').prop('checked', false);
    $('#likeAddress').parents().eq(1).addClass('d-none');
    $('.declarant').hide();
    switch (this.value) {
        case 'FL':
            $('#declarantFL').show();
            $('input[name="delivery"][value="При личном обращении в КГБУ «КГКО»"]').prop('checked', true);
            $('#likeAddress').parents().eq(1).removeClass('d-none');
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
            $('input[name="delivery"][value="При личном обращении в КГБУ «КГКО»"]').prop('checked', true);
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
            $('input[name="delivery"][value="СМЭВ"]').prop('checked', true);
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
        if (decType != 'OGV') {
            window.open("/tpl/form"+decType+".php?numLog="+data.numLog, "_blank"); 
        }
        window.location.replace("new-request.php?toast="+data.numLog+"&ID="+data.ID+"&decType="+decType);
    }
});




});

$("#clearForms").click(function() {
    $('form').trigger("reset");
});