let numService = 0;

$.when($.ready).then(function() {
    localStorage.setItem("listFL", "");
    localStorage.setItem("listAgents", "");
    localStorage.setItem("listUL", "");
    localStorage.setItem("listOGV", "");

    let today = new Date();
    $('#reqDate').val(today.getFullYear() + "-" + ('0' + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2));

    //Enable tooltips everywhere
    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    $(".address").suggestions({
        token: "34152e12e60fe6b7ef2a2682e1fe675021cedd05",
        type: "ADDRESS",
        onSelect: showAddr
    });

    $("#dFLWhoDUL").suggestions({
        token: "34152e12e60fe6b7ef2a2682e1fe675021cedd05",
        type: "fms_unit"
    });

    $("#dULINN").suggestions({
        token: "34152e12e60fe6b7ef2a2682e1fe675021cedd05",
        type: "PARTY",
        onSelect: showUL
    });

});

function join(arr /*, separator */) {
  var separator = arguments.length > 1 ? arguments[1] : ", ";
  return arr.filter(function(n){return n}).join(separator);
}

function showAddr(suggestion) {
    let fullAddress = suggestion.unrestricted_value.replace(' г ', ' г. ').replace(' д ', ' д. ').replace(' ул ', ' ул. ').replace(' кв ', ' кв. ');
    $(this).val(fullAddress);  
    if ($(this).attr('id').substring(0, 10) == 'svcInfoObj') {
        let id = $(this).attr('id').split('-')[2];
        let addr = suggestion.data; //добавить еще код региона и код района
        $(`#svcInfoObj-address-postcode-${id}`).val(addr.postal_code);
        $(`#svcInfoObj-address-region-${id}`).val(join([addr.region, addr.region_type], " "));
        $(`#svcInfoObj-address-region-code-${id}`).val(addr.region_kladr_id);
        $(`#svcInfoObj-address-area-${id}`).val(join([addr.area_type, addr.area], " "));
        $(`#svcInfoObj-address-area-code-${id}`).val(addr.area_kladr_id);
        $(`#svcInfoObj-address-local-${id}`).val(join([join([addr.city_type, addr.city], " "),join([addr.settlement_type, addr.settlement], " ")]));
        $(`#svcInfoObj-address-street-${id}`).val(join([addr.street_type, addr.street], " "));
        $(`#svcInfoObj-address-house-${id}`).val(join([join([addr.house_type, addr.house], " "),join([addr.block_type, addr.block], " ")]));
        $(`#svcInfoObj-address-flat-${id}`).val(join([addr.flat_type, addr.flat], " "));
    }
}

function showUL(suggestion) {
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
    //emails и phones нету в бесплатном тарифе
}

$('#services input[type=checkbox]').change(function() {
    $('#services input[type=checkbox]').each(function() {
        $(this).prop('required', false);
    });
});

$('#delivery input[type=checkbox]').change(function() {
    $('#delivery input[type=checkbox]').each(function() {
        $(this).prop('required', false);
    });
});

function validate() {
    let check = true;
    let i = 0;
    $("form:visible").each(function() {
        $('#' + $(this).attr('id')).addClass('was-validated');
        if ($(this)[0].checkValidity() === false) {
            check = false;
        }
    });
    users = $(".dropdown-item").toArray().reverse();
    $.each(users, function(key,value) {
        if ($('#userName').html() == value.innerHTML)
            i++;
    });
    if (i == 0) {
        check = false;
        showNotifyModal('Укажите пользователя системы!', 'Ошибка');
    }
    if ($("select[id*='svcSelect-']").length == 0) {
        check = false;
        showNotifyModal('Выберите хотя бы одну услугу!', 'Ошибка');  
    }
    if (!check) {
        $('html, body').animate({
            scrollTop: $(".invalid-feedback:visible:first").offset().top - 100
        }, 50);
    }
    return check;
}

$("#dFLName").on("autocompleteselect", function(event, ui) {
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
});

$("#dFLAgentName").on("autocompleteselect", function(event, ui) {
    let listAgents = [];
    agID = ui.item.label.split(" | ")[3];
    listAgents = $.parseJSON(localStorage.getItem("listAgents"));
    index = listAgents.findIndex(x => x.ID === agID);
    $('#dFLAgentPhone').val(listAgents[index].tel);
    $('#dFLAgentAddress').val(listAgents[index].address);
    $('#dFLAgentNumDUL').val(listAgents[index].dulNum);
    $('#dFLAgentDateDUL').val(listAgents[index].dulDate);
    $('#dFLAgentWhoDUL').val(listAgents[index].dulOrg);
});

// собственые подсказки из базы по юрлицам
$("#dULName").on("autocompleteselect", function(event, ui) {
    decID = ui.item.label.split(" | ")[3];
    listUL = $.parseJSON(localStorage.getItem("listUL"));
    index = listUL.findIndex(x => x.ID === decID);
    $('#dULINN').val(listUL[index].INN);
    $('#dULOGRN').val(listUL[index].OGRN);
    $('#dULAddress').val(listUL[index].address);
    $('#dULEmail').val(listUL[index].email);
    $('#dULPhone').val(listUL[index].tel);
});

$("#dULAgentName").on("autocompleteselect", function(event, ui) {
    let listAgents = [];
    agID = ui.item.label.split(" | ")[3];
    listAgents = $.parseJSON(localStorage.getItem("listAgents"));
    index = listAgents.findIndex(x => x.ID === agID);
    $('#dULAgentPhone').val(listAgents[index].tel);
    $('#dULAgentAddress').val(listAgents[index].address);
    $('#dULNumDUL').val(listAgents[index].dulNum);
    $('#dULDateDUL').val(listAgents[index].dulDate);
    $('#dULWhoDUL').val(listAgents[index].dulOrg);
});

$('#agentFLSwitch').change(function() {
    if ($(this).prop('checked')) {
        $('#agentFLForm').show();
        $('.decDataGroup').hide();
        $('.decData').prop('required', false);
        $('.decData').prop('disabled', true);
    } else {
        $('#agentFLForm').hide();
        $('.decDataGroup').show();
        $('.decData').prop('required', true);
        $('.decData').prop('disabled', false);
    }
})

$('#services').on('change', 'input[id^="like"]', function() {
    let id = $(this).attr('id').substring(4).split("-");
    let val = ($(this).prop('checked')) ? $(`#dFL${id[0]}`).val() : '';
    $(`#svcInfoObj-${id[0].toLowerCase()}-${id[1]}`).val(val);
    (id[0] == 'Name') ? likeName(id[1], val) : $(`#svcInfoObj-address-${id[1]}`).focus();
})

function likeName(id, checked) {
    if (checked) {
        dFLBD = $('#dFLBD').val();
        dFLNumDUL = $('#dFLNumDUL').val();
        dFLDateDUL = $('#dFLDateDUL').val();
        dFLWhoDUL = $('#dFLWhoDUL').val();
    } else {
        dFLBD = '';
        dFLNumDUL = '';
        dFLDateDUL = '';
        dFLWhoDUL = '';        
    }
    $(`#svcInfoObj-name-${id}`).focusout();
    $(`#svcInfoObj-bday-${id}`).val(dFLBD);
    $(`#svcInfoObj-dulNum-${id}`).val(dFLNumDUL);
    $(`#svcInfoObj-dulDate-${id}`).val(dFLDateDUL);
    $(`#svcInfoObj-dulOrg-${id}`).val(dFLWhoDUL);
}

function splitName(arr) {
    let newArr = [];
    let middle = [];
    $.each(arr, function(key,value) {
      switch (key) {
        case 0:
        newArr.push(value);
        break;
        case 1:
        newArr.push(value);
        break;
        default:
        middle.push(value);
      }
    });     
    newArr.push(middle.join(' '));
    return newArr;
}

$('#services').on('focusout', 'input[id^="svcInfoObj-name-"]', function() {
    let id = $(this).attr('id').split("-")[2];
    let full = $(this).val().split(" ");
    $(`#svcInfoObj-lastName-${id}`).val(splitName(full)[0]);
    $(`#svcInfoObj-firstName-${id}`).val(splitName(full)[1]);
    $(`#svcInfoObj-middleName-${id}`).val(splitName(full)[2]);
})

$('#services').on('focusout', 'input[id^="svcInfoObj-area"]', function() {
    $(this).val($(this).val().replace(/,/g, "."));
})

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
            checkItem('delivery', 'foot');
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data) {
                    localStorage.setItem("listFL", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key, value) {
                        if (value.dulNum) { dull = value.dulNum.substring(0, 4) + " " + value.dulNum.substring(4, 10); } else { dull = "-"; }
                        listFL.push({ label: value.name + " | " + dull + " | " + value.dateBirth + " | " + value.ID, value: value.name });
                    });

                    $("#dFLName").autocomplete({
                        source: listFL
                    });
                }
            });
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "agent", decType: this.value },
                success: function(data) {
                    localStorage.setItem("listAgents", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key, value) {
                        listAgents.push({ label: value.FIO + " | " + value.dulNum.substring(0, 4) + " " + value.dulNum.substring(4, 10) + " | " + value.tel + " | " + value.ID, value: value.FIO });
                    });

                    $("#dFLAgentName").autocomplete({
                        source: listAgents
                    });
                }
            });

            break;
        case 'UL':
            $('#declarantUL').show();
            checkItem('delivery', 'foot');
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data) {
                    localStorage.setItem("listUL", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key, value) {
                        listUL.push({ label: value.name + " | " + value.INN + " | " + value.OGRN + " | " + value.ID, value: value.name });
                    });

                    $("#dULName").autocomplete({
                        source: listUL
                    });
                }
            });
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "agent", decType: this.value },
                success: function(data) {
                    localStorage.setItem("listAgents", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key, value) {
                        listAgents.push({ label: value.FIO + " | " + value.dulNum.substring(0, 4) + " " + value.dulNum.substring(4, 10) + " | " + value.tel + " | " + value.ID, value: value.FIO });
                    });

                    $("#dULAgentName").autocomplete({
                        source: listAgents
                    });
                }
            });
            break;
        case 'OGV':
            $('#declarantOGV').show();
            checkItem('delivery', 'smev');
            let today = new Date();
            $('#dOGVSenderDate').val(today.getFullYear() + "-" + ('0' + (today.getMonth() + 1)).slice(-2) + "-" + ('0' + today.getDate()).slice(-2));
            $.ajax({
                url: 'data/getRef.php',
                method: 'GET',
                data: { ref: "declarant", decType: this.value },
                success: function(data) {
                    localStorage.setItem("listOGV", data);
                    let obj = $.parseJSON(data);
                    $.each(obj, function(key, value) {
                        listOGV.push({ label: value.name + " | " + value.ID, value: value.name });
                    });

                    $("#dOGVName").autocomplete({
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
    if (!validate()) {
        return false;
    }
    let decType = $('#declarantType').val();
    let decInfo = '';
    let param = '';
    switch (decType) {
        case 'FL':
            decInfo = $('#reqFL').serialize();
            if ($('#agentFLSwitch').prop('checked')) {
                decInfo = decInfo + '&' + $('#agentFLForm').serialize();
            }
            break;
        case 'UL':
            decInfo = $('#reqUL').serialize();
            break;
        case 'OGV':
            $('#dOGVName').val($.trim($('#dOGVName').val()));
            decInfo = $('#reqOGV').serialize();
            break;
    }

    param = 'decType=' + decType + '&' + decInfo + '&' + $('#reqInfo').serialize();

    $.ajax({
        url: 'data/new-request.php',
        method: 'GET',
        data: param,
        success: function(data) {
            if (data.split(" ")[0] == 'Error') {
                showNotifyModal('<p>Возникла ошибка при создании запроса. <br>Обратитесь в отдел ИТ.</p><p>Текст ошибки: </p>'+data, 'Ошибка');
            } else {
                data = $.parseJSON(data);
                logger('Запрос создан', data.numLog);
                window.open("/tpl/printRequest.php?numLog=" + data.numLog, "_blank");
                window.location.replace("new-request.php?toast=" + data.numLog + "&ID=" + data.ID + "&decType=" + decType);
            }
        }
    });

});

$("#clearForms").click(function() {
    $('form').trigger("reset");
});

function checkItem(group, item) {
    $('#' + group + ' input[type=checkbox]').prop('checked', false);
    $('input[name="' + item + '"]').prop('checked', true);
}

$("#addService").click(function() {
    let currentNumService = ++numService;
    let selectService = `        <div id="svcInfo-${currentNumService}">
                                  <h5 class="display-6 display-small">Услуга №${currentNumService}</h5>
                                  <div class="row g-1 mb-3">
                                    <div class="col-md">
                                      <div class="form-floating">
                                        <select class="form-select" id="svcSelect-${currentNumService}" name="svcSelect-${currentNumService}" aria-label="Floating label select" value="" required>
                                          <option value="" selected>---</option>
                                          <option value="svc1" data-stype="Копия">Технический паспорт ОКС/помещения</option>
                                          <option value="svc2" data-stype="Копия">Поэтажный/ситуационный план</option>
                                          <option value="svc3" data-stype="Копия">Экспликация поэтажного плана/ОКС/помещения</option>
                                          <option value="svc4" data-stype="Копия">УТД, содержащая сведения об инвентаризационной, восстановительной, балансовой или иной стоимости ОКС/помещения</option>
                                          <option value="svc5" data-stype="Копия">Проектно-разрешительная документация, техническое или экспертное заключение, или иная документация, содржащаяся в архиве</option>
                                          <option value="svc6" data-stype="Копия">Правоустанавливающий документ, хранящийся в материалах инвентарного дела</option>
                                          <option value="svc7" data-stype="Справка">Выписка из реестровой книги о праве собственности на ОКС/помещение</option>
                                          <option value="svc8" data-stype="Копия">Справка, содержащая сведения об инвентаризационной стоимости ОКС</option>
                                          <option value="svc9" data-stype="Копия">Справка, содержащая сведения об инвентаризационной стоимости помещения</option>
                                          <option value="svc10" data-stype="Справка">Справка, содержащая сведения о наличии (отсутствии) права собствености на объекты недвижимости (один правообладатель)</option>
                                          <option value="svc11" data-stype="Копия">Справка, содержащая сведения о характеристиках объекта государственного учета</option>
                                        </select>
                                        <label for="svcSelect-${currentNumService}">Выберите услугу</label>
                                        <div class="invalid-feedback">
                                          Выберите услугу
                                        </div>                                        
                                      </div>
                                    </div>
                                  </div>
                                  <div id="svcInfoObj-${currentNumService}"></div>
                                </div>`;
    $("#services").append(selectService);
});

$("#rmService").click(function() {
    $("div[id^='svcInfo-']").last().remove();
    --numService;
});

$('#services').on('change', 'select[id^="svcSelect-"]', function() {
    let id = $(this).attr('id').split("-")[1];
    let obj = '';
    let like = ($('#declarantType').val() == "FL") ? '' : 'd-none';
    switch ($(this).find('option:selected').data('stype')) {
        case 'Копия':
            obj = `        <div class="row g-1 mb-3">
                              <div class="col-md">
                                <div class="form-floating">
                                  <input type="text" class="form-control address" id="svcInfoObj-address-${id}" name="svcInfoObj-address-${id}" placeholder="Адрес объекта недвижимости" value="" required>
                                  <label for="svcInfoObj-address-${id}">Адрес объекта недвижимости</label>
                                </div>
                              </div>  
                            </div>
                            <div class="row g-3 mb-3 ${like}">
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="likeAddress-${id}" id="likeAddress-${id}">
                                <label class="form-check-label" for="likeAddress-${id}">Адрес совпадает с адресом места жительства заявителя</label>
                              </div>                
                            </div>            
                            <div class="row g-1 mb-3">
                              <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-postcode-${id}" name="svcInfoObj-address-postcode-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-address-postcode-${id}">Индекс</label>
                                </div>
                              </div>   
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-region-${id}" name="svcInfoObj-address-region-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-region-${id}">Регион</label>
                                </div>
                                <div class="form-floating d-none">
                                  <input type="text" class="form-control" id="svcInfoObj-address-region-code-${id}" name="svcInfoObj-address-region-code-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-region-code-${id}">Регион</label>
                                </div>                                
                              </div>
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-area-${id}" name="svcInfoObj-address-area-${id}" placeholder="Район" value="">
                                  <label for="svcInfoObj-address-area-${id}">Район</label>
                                </div>
                                <div class="form-floating d-none">
                                  <input type="text" class="form-control" id="svcInfoObj-address-area-code-${id}" name="svcInfoObj-address-area-code-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-area-code-${id}">Регион</label>
                                </div>                                
                              </div>                              
                              <div class="col-md-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-local-${id}" name="svcInfoObj-address-local-${id}" placeholder="Населенный пункт" value="">
                                  <label for="svcInfoObj-address-local-${id}">Населенный пункт</label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-street-${id}" name="svcInfoObj-address-street-${id}" placeholder="Улица" value="">
                                  <label for="svcInfoObj-address-street-${id}">Улица</label>
                                </div>
                              </div> 
                             <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-house-${id}" name="svcInfoObj-address-house-${id}" placeholder="Дом" value="">
                                  <label for="svcInfoObj-address-house-${id}">Дом</label>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-flat-${id}" name="svcInfoObj-address-flat-${id}" placeholder="Квартира" value="">
                                  <label for="svcInfoObj-address-flat-${id}">Квартира</label>
                                </div>
                              </div>                   
                            </div>
                            <div class="row g-1 mb-3">
                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-location-${id}" name="svcInfoObj-address-location-${id}" placeholder="Местоположение" value="">
                                  <label for="svcInfoObj-address-location-${id}">Местоположение объекта недвижимости</label>
                                </div>
                              </div>
                            </div>
                            <div class="row g-1 mb-3">
                              <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-inum-${id}" name="svcInfoObj-inum-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-inum-${id}">Инв. номер</label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-knum-${id}" name="svcInfoObj-knum-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-knum-${id}">Кадастровый номер</label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-area-${id}" name="svcInfoObj-area-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-area-${id}">Площадь, кв.м.</label>
                                </div>
                              </div>                                                                                            
                            </div>
                            <div class="row g-1 mb-3">
                                <div class="form-floating">
                                  <textarea class="form-control" placeholder="Дополнительная информация" id="svcInfoObj-addInfo-${id}" name="svcInfoObj-addInfo-${id}" style="height: 200px"></textarea>
                                  <label for="svcInfoObj-addInfo-${id}">Дополнительная информация</label>
                                </div>                            
                            </div>`;
            break;
        case 'Справка':
            obj = `         <div class="row g-3 mb-3">
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="isHuman-${id}" id="isHuman-${id}" checked>
                                <label class="form-check-label" for="isHuman-${id}">Запрос по собственнику</label>
                              </div>                
                            </div>
                            <div id="svcInfoObj-control-${id}">
                                <div class="row g-1 mb-3">
                                  <div class="col-md">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-name-${id}" name="svcInfoObj-name-${id}" placeholder="ФИО собственника" value="" required>
                                      <label for="svcInfoObj-name-${id}">ФИО собственника</label>
                                    </div>
                                  </div>  
                                </div>   
                                <div class="row g-3 mb-3 ${like}">
                                  <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="likeName-${id}" id="likeName-${id}">
                                    <label class="form-check-label" for="likeName-${id}">Данные совпадает с данными заявителя</label>
                                  </div>                
                                </div>
                                <div class="row g-3 mb-3">
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-lastName-${id}" name="svcInfoObj-lastName-${id}" placeholder="Фамилия" value="" required>
                                      <label for="svcInfoObj-lastName-${id}">Фамилия</label>
                                    </div>
                                  </div>   
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-firstName-${id}" name="svcInfoObj-firstName-${id}" placeholder="Имя" value="" required>
                                      <label for="svcInfoObj-firstName-${id}">Имя</label>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-middleName-${id}" name="svcInfoObj-middleName-${id}" placeholder="Отчество" value="">
                                      <label for="svcInfoObj-middleName-${id}">Отчество</label>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="date" class="form-control" id="svcInfoObj-bday-${id}" name="svcInfoObj-bday-${id}" placeholder="Дата рождения" value="">
                                      <label for="svcInfoObj-bday-${id}">Дата рождения</label>
                                    </div>
                                  </div>                                   
                                </div>
                                <div class="row g-3 mb-3">
                                  <div class="col-md-2">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-dulNum-${id}" name="svcInfoObj-dulNum-${id}" placeholder="Серия и номер ДУЛ" value="">
                                      <label for="svcInfoObj-dulNum-${id}">Номер ДУЛ</label>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-2">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-dulDate-${id}" name="svcInfoObj-dulDate-${id}" placeholder="Дата выдачи ДУЛ" value="">
                                      <label for="svcInfoObj-dulDate-${id}">Дата ДУЛ</label>
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-dulOrg-${id}" name="svcInfoObj-dulOrg-${id}" placeholder="Кем выдан ДУЛ" value="">
                                      <label for="svcInfoObj-dulOrg-${id}">Выдан ДУЛ</label>
                                    </div>
                                  </div>
                                </div>                                
                            </div>`;
            break;
    }    
    $(`#svcInfoObj-${id}`).html(obj);

    $(".address").suggestions({
        token: "34152e12e60fe6b7ef2a2682e1fe675021cedd05",
        type: "ADDRESS",
        onSelect: showAddr
    });    
});

$('#services').on('change', 'input[id^="isHuman-"]', function() {
    let id = $(this).attr('id').split("-")[1];
    let like = ($('#declarantType').val() == "FL") ? '' : 'd-none';
    if ($(this).prop('checked')) {
        controls = `              <div class="row g-1 mb-3">
                                  <div class="col-md">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-name-${id}" name="svcInfoObj-name-${id}" placeholder="ФИО собственника" value="" required>
                                      <label for="svcInfoObj-name-${id}">ФИО собственника</label>
                                    </div>
                                  </div>  
                                </div>   
                                <div class="row g-3 mb-3 ${like}">
                                  <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="likeName-${id}" id="likeName-${id}">
                                    <label class="form-check-label" for="likeName-${id}">ФИО совпадает с ФИО заявителя</label>
                                  </div>                
                                </div>
                                <div class="row g-3 mb-3">
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-lastName-${id}" name="svcInfoObj-lastName-${id}" placeholder="Фамилия" value="" required>
                                      <label for="svcInfoObj-lastName-${id}">Фамилия</label>
                                    </div>
                                  </div>   
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-firstName-${id}" name="svcInfoObj-firstName-${id}" placeholder="Имя" value="" required>
                                      <label for="svcInfoObj-firstName-${id}">Имя</label>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-middleName-${id}" name="svcInfoObj-middleName-${id}" placeholder="Отчество" value="">
                                      <label for="svcInfoObj-middleName-${id}">Отчество</label>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <div class="form-floating">
                                      <input type="date" class="form-control" id="svcInfoObj-bday-${id}" name="svcInfoObj-bday-${id}" placeholder="Дата рождения" value="">
                                      <label for="svcInfoObj-bday-${id}">Дата рождения</label>
                                    </div>
                                  </div>                                   
                                </div>
                                <div class="row g-3 mb-3">
                                  <div class="col-md-2">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-dulNum-${id}" name="svcInfoObj-dulNum-${id}" placeholder="Серия и номер ДУЛ" value="">
                                      <label for="svcInfoObj-dulNum-${id}">Номер ДУЛ</label>
                                    </div>
                                  </div>                                  
                                  <div class="col-md-2">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-dulDate-${id}" name="svcInfoObj-dulDate-${id}" placeholder="Дата выдачи ДУЛ" value="">
                                      <label for="svcInfoObj-dulDate-${id}">Дата ДУЛ</label>
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                    <div class="form-floating">
                                      <input type="text" class="form-control" id="svcInfoObj-dulOrg-${id}" name="svcInfoObj-dulOrg-${id}" placeholder="Кем выдан ДУЛ" value="">
                                      <label for="svcInfoObj-dulOrg-${id}">Выдан ДУЛ</label>
                                    </div>
                                  </div>
                                </div>`;
    } else {
        controls = `        <div class="row g-1 mb-3">
                              <div class="col-md">
                                <div class="form-floating">
                                  <input type="text" class="form-control address" id="svcInfoObj-address-${id}" name="svcInfoObj-address-${id}" placeholder="Адрес объекта недвижимости" value="" required>
                                  <label for="svcInfoObj-address-${id}">Адрес объекта недвижимости</label>
                                </div>
                              </div>  
                            </div>
                            <div class="row g-3 mb-3 ${like}">
                              <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="likeAddress-${id}" id="likeAddress-${id}">
                                <label class="form-check-label" for="likeAddress-${id}">Адрес совпадает с адресом места жительства заявителя</label>
                              </div>                
                            </div>            
                            <div class="row g-1 mb-3">
                              <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-postcode-${id}" name="svcInfoObj-address-postcode-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-address-postcode-${id}">Индекс</label>
                                </div>
                              </div>   
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-region-${id}" name="svcInfoObj-address-region-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-region-${id}">Регион</label>
                                </div>
                                <div class="form-floating d-none">
                                  <input type="text" class="form-control" id="svcInfoObj-address-region-code-${id}" name="svcInfoObj-address-region-code-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-region-code-${id}">Регион</label>
                                </div>                                
                              </div>
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-area-${id}" name="svcInfoObj-address-area-${id}" placeholder="Район" value="">
                                  <label for="svcInfoObj-address-area-${id}">Район</label>
                                </div>
                                <div class="form-floating d-none">
                                  <input type="text" class="form-control" id="svcInfoObj-address-area-code-${id}" name="svcInfoObj-address-area-code-${id}" placeholder="Регион" value="">
                                  <label for="svcInfoObj-address-area-code-${id}">Регион</label>
                                </div>                                
                              </div>                              
                              <div class="col-md-3">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-local-${id}" name="svcInfoObj-address-local-${id}" placeholder="Населенный пункт" value="">
                                  <label for="svcInfoObj-address-local-${id}">Населенный пункт</label>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-street-${id}" name="svcInfoObj-address-street-${id}" placeholder="Улица" value="">
                                  <label for="svcInfoObj-address-street-${id}">Улица</label>
                                </div>
                              </div> 
                             <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-house-${id}" name="svcInfoObj-address-house-${id}" placeholder="Дом" value="">
                                  <label for="svcInfoObj-address-house-${id}">Дом</label>
                                </div>
                              </div>
                              <div class="col-md-1">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-flat-${id}" name="svcInfoObj-address-flat-${id}" placeholder="Квартира" value="">
                                  <label for="svcInfoObj-address-flat-${id}">Квартира</label>
                                </div>
                              </div>                   
                            </div>
                            <div class="row g-1 mb-3">
                              <div class="col-md-12">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-address-location-${id}" name="svcInfoObj-address-location-${id}" placeholder="Местоположение" value="">
                                  <label for="svcInfoObj-address-location-${id}">Местоположение объекта недвижимости</label>
                                </div>
                              </div>
                            </div>
                            <div class="row g-1 mb-3">
                              <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-inum-${id}" name="svcInfoObj-inum-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-inum-${id}">Инв. номер</label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-knum-${id}" name="svcInfoObj-knum-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-knum-${id}">Кадастровый номер</label>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control" id="svcInfoObj-area-${id}" name="svcInfoObj-area-${id}" placeholder="Индекс" value="">
                                  <label for="svcInfoObj-area-${id}">Площадь, кв.м.</label>
                                </div>
                              </div>                                                                                            
                            </div>
                            <div class="row g-1 mb-3">
                                <div class="form-floating">
                                  <textarea class="form-control" placeholder="Дополнительная информация" id="svcInfoObj-addInfo-${id}" name="svcInfoObj-addInfo-${id}" style="height: 200px"></textarea>
                                  <label for="svcInfoObj-addInfo-${id}">Дополнительная информация</label>
                                </div>                            
                            </div>`;
    }
    $(`#svcInfoObj-control-${id}`).html(controls);
})