let reqInfoModal = new bootstrap.Modal($('#reqInfoModal'), {});
let notifyModal = new bootstrap.Modal($('#notify'), {});
let fakeUsers = getAvatarList();
let fakeUser = fakeUsers[Math.floor(Math.random()*fakeUsers.length)];

$.when($.ready).then(function() {
    $('.preloader, .overlay').fadeOut(300);
    session();
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
                minLength: 4,
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

function showNotifyModal(text, title) {
    $('#notifyText').html(text);
    $('#notifyTitle').html(title);
    notifyModal.show();
}

function addModalInfo(num) {
    $("#decTabInfo").html(`<img src="/img/preload.gif" alt="mdo" width="64" height="64" class="rounded-circle mx-auto d-block">`);
    $.ajax({
        url: 'data/getCardInfo.php',
        type: 'GET',
        data: { numLog: num },
        success: function(data) {
            let reqData = $.parseJSON(data);
            $("#decTabInfo").html(reqData.decTbl);
            $("#reqInfoNum").html(reqData.request.num);
            $("#reqInfoDate").html(reqData.request.date);
            $("#reqInfoStatus").html(reqData.request.status);
            //request
            $("#history").html(reqData.history);
            $("#servicesInfo").html(reqData.svcTbl);
            $("#reqTabInfoComment").html(reqData.request.comment);
            $("#reqTabInfoDelivery").html(reqData.request.delivery);
            $("#reqTabInfoAttach").html(reqData.request.attachList);
            $("#reqTabInfoFiles").html(reqData.request.fileList);
            //reply 
            $("#repTabInfoDate").html(reqData.request.reply.date);
            $("#repTabInfoNum").html(reqData.request.reply.num);
            $("#servicesInfoReplyBody").html(reqData.svcTblReply)
            reqData.svcTblReply ? $("#servicesInfoReply").removeClass('d-none') : $("#servicesInfoReply").addClass('d-none');
        }
    });
}

$("#modalPrintReq").click(function() {
    window.open('/tpl/printRequest.php?numLog=' + $('#reqInfoNum').html(), '_blank');
});

$("#modalGetReply").click(function() {
    window.open('/tpl/getReply.php?numLog=' + $('#reqInfoNum').html(), "_blank");
});
//modalPrintReq

function session() {   
    if (typeof $.cookie('uid') === 'undefined') {
        $.cookie('uid', Date.now(), { expires: 365, path: '/' });
        $.cookie('userIcon', fakeUser["img"], { expires: 365, path: '/' });
        $.cookie('userName', fakeUser["name"], { expires: 365, path: '/' });
        setUser(fakeUser);
     } else {
        user = getProfile('');
        (user) ? setUser(user) : setUser({name: $.cookie('userName'), img: $.cookie('userIcon'), ID: 0});       
    }
}

function setUser(user) {
    $('#userName').html(user["name"]);
    $('#userImg').attr('src', user["img"]);  
    $(`#performer option:contains("${user["name"]}")`).prop('selected', true);
    $(`#performerInWork option:contains("${user["name"]}")`).prop('selected', true);
    $.cookie('id', user["ID"], { expires: 365, path: '/' });
}

function getAvatarList() {
    data = $.ajax({
        url: `data/getAvatars.php`,
        type: 'GET',
        async: false,
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(data.responseText)
}

function getProfile(user) {
    data = $.ajax({
        url: `data/getProfiles.php`,
        type: 'GET',
        async: false,
        data: { img: $.cookie('userIcon'), uid: $.cookie('uid'), user: user },
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(data.responseText)
}

$(".dropdown-item").click(function() {
    setUser(getProfile($(this).html()));
});

function logger(event, request) {
    $.ajax({
        url: 'data/addLog.php',
        type: 'GET',
        data: { uid: $.cookie('id'), event: event, request: request },
    });    
}