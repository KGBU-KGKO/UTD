let reqInfoModal = new bootstrap.Modal($('#reqInfo'), {});

$.when($.ready).then(function() {
	sugg();
});

function sugg() {
	let list = [];
    $.ajax({
        url: 'data/getRef.php',
        method: 'GET',
        data: { ref: "global" },
        success: function(data) {
            let obj = $.parseJSON(data);
            $.each(obj, function(key, value) {
                list.push({ label: value.numLog + " | " + value.dateReq.split(' ')[0] + " | " + value.status + " | " + value.name + " | " + value.realEstate + " | " + value.performer, value: value.numLog });
            });

            $("#gSearch").autocomplete({
                source: list,
                position: {
			        my : "center top",
			        at: "center bottom"
			    },

                select: function(event, ui) {
                    event.preventDefault();
                    $("#gSearch").val(ui.item.value); 
                    if (ui.item.value != '') {
                        addModalInfo(ui.item.value);
                        reqInfoModal.show();    
                    }           
                },                

                response: function(event, ui) { 

                    if (!ui.content.length) { 
                        let noResult = { value:"",label:"Ничего не найдено" }; 
                        ui.content.push(noResult); 
                    }
                }

            });
        }
    });
}

function addModalInfo(num) {
    $.ajax({
        url: 'data/getCardInfo.php',
        type: 'GET',
        data: { numLog: num },
        success: function(data) {
            //console.log(data);
            let reqData = $.parseJSON(data);
            $("#decTabInfo").html(reqData.decTbl);
            $("#reqInfoNum").html(reqData.request.num);
            $("#reqInfoDate").html(reqData.request.date);
            $("#reqInfoStatus").html(reqData.request.status);
            //request
            $("#reqTabInfoObject").html(reqData.request.realEstate);
            $("#reqTabInfoComment").html(reqData.request.comment);
            $("#reqTabInfoServices").html(reqData.request.svc);
            $("#reqTabInfoDelivery").html(reqData.request.delivery);
            $("#reqTabInfoAttach").html(reqData.request.attachList);
            $("#reqTabInfoFiles").html(reqData.request.fileList);
            //reply 
            $("#repTabInfoDate").html(reqData.request.reply.date);
            $("#repTabInfoNum").html(reqData.request.reply.num);
            $("#repTabInfoStatus").html(reqData.request.reply.status);
            $("#repTabInfoReason").html(reqData.request.reply.reason);
        }
    });
}

$("#modalPrintReq").click(function() {
    //window.open('/tpl/form' + $(this).parents().eq(1).find('td').eq(1).text() + '.php?numLog=' + $('#reqInfoNum').val(), '_blank');
});

function session() {    
let session = localStorage.getItem("session");
console.log(session);
// if (result === 'spa') {
//     document.getElementById("welcome").innerHTML = "Hola!";
// } else {
//     document.getElementById("welcome").innerHTML = "Hello!";
// }
}

function addUser(key) {
// if (key === 'en') {
//     document.getElementById("welcome").innerHTML = "Hello!";
//     localStorage.setItem("session", "en");
// } else if (key === 'spa') {
//     document.getElementById("welcome").innerHTML = "Hola!";
//     localStorage.setItem("session", "spa");
// }
}