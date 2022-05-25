let notifyToast = bootstrap.Toast.getOrCreateInstance($('#notifyToast'));
let removeAlertModal = new bootstrap.Modal($('#removeAlert'), {});
let uploadTable = $('#uploadTable').bootstrapTable({
    pagination: true,
    search: true,
});
let now = new Date();
let quarterCount = Math.floor((now.getMonth() / 3));
let quarterBeginFull = new Date(now.getFullYear(), quarterCount * 3, 1);
let today = now.getFullYear() + "-" + ('0' + (now.getMonth() + 1)).slice(-2) + "-" + ('0' + now.getDate()).slice(-2);
let weekAgo = getDateWeekAgo();
//let monthAgo = now.getFullYear() + "-" + (now.getMonth() == 0 ? '12': '0' + now.getMonth()).slice(-2) + "-" + ('0' + now.getDate()).slice(-2);
let monthBegin = now.getFullYear() + "-" + ('0' + (now.getMonth() + 1)).slice(-2) + "-01";
let quarterBegin = quarterBeginFull.getFullYear() + "-" + ('0' + (quarterBeginFull.getMonth() + 1)).slice(-2) + "-" + ('0' + quarterBeginFull.getDate()).slice(-2);
let yearBegin = now.getFullYear() + "-01-01";

let firstchart = new Chart(document.getElementById('first-chart'), {
    type: 'line',
    data: {},
    options: {},
    plugins: []
});

let secondchart = new Chart(document.getElementById('second-chart'), {
    type: 'bar',
    data: {},
    options: {},
    plugins: []
});

let thirdchart = new Chart(document.getElementById('third-chart'), {
    type: 'bar',
    data: {},
    options: {},
    plugins: []
});

$.when($.ready).then(function() {
    $("[id$='-date-to']").val(today);
    $("[id$='-date-from']").val(weekAgo);
    $("#logDate").val(today);

    uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
    loadCards();
    loadFirstChart(firstchart, weekAgo, today);
    loadSecondChart(secondchart, weekAgo, today);
    loadThirdChart(thirdchart, weekAgo, today);

});

function getDateWeekAgo() {
    let needDate;
    let countDays = [31,28,31,30,31,30,31,31,30,31,30,31];
    if ((now.getDate() - 7) < 0) {
        needDate = now.getFullYear() + "-" + ('0' + now.getMonth()).slice(-2) + "-" + ('0' + (countDays[now.getMonth()-1] + (now.getDate() - 7))).slice(-2);
        return needDate
    } else {
        needDate = now.getFullYear() + "-" + ('0' + (now.getMonth() + 1)).slice(-2) + "-" + ('0' + (now.getDate() - 7)).slice(-2);
        return needDate;
    }
}

$('input[name$="-chart-btnradio"]').click(function() {
    //console.log($(this).attr('id').split('-')[0] + ' ' + $(this).attr('id').split('btnradio')[1]);
    chart = $(this).attr('id').split('-')[0];
    period = $(this).attr('id').split('btnradio')[1];
    switch (period) {
      case "1":
        from = weekAgo;
        break;
      case "2":
        from = monthBegin;
        break;
      case "3":
        from = quarterBegin;
        break;
      case "4":
        from = yearBegin;
        break;      
    }    
    switch (chart) {
      case "first":
        loadFirstChart(firstchart, from, today);
        break;
      case "second":
        loadSecondChart(secondchart, from, today);
        break;
      case "third":
        loadThirdChart(thirdchart, from, today);
        break;
    }
});

$('button[id$="-filter"]').click(function() {
    chart = $(this).attr('id').split('-')[0];
    from = $("#" + $(this).attr('id').split('-')[0] + "-chart-date-from").val();
    to = $("#" + $(this).attr('id').split('-')[0] + "-chart-date-to").val();
    switch (chart) {
      case "first":
        loadFirstChart(firstchart, from, to);
        break;
      case "second":
        loadSecondChart(secondchart, from, to);
        break;
      case "third":
        loadThirdChart(thirdchart, from, to);
        break;
    }
});

function getDataChart(chart, from, to) {
    dataChart = $.ajax({
        url: 'data/getDataDashboard.php',
        type: 'GET',
        data: { info: chart, from: from, to: to },
        async: false,
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(dataChart.responseText);
}

function loadCards() {
    $.ajax({
        url: 'data/getDataDashboard.php',
        type: 'GET',
        data: { info: "cards" },
        success: function(data) {
            data = $.parseJSON(data);
            $("#reqAll").html(data["reqRecieved"]);
            $("#reqToday").html("+" + data["reqRecievedToday"] + " сегодня");
            $("#inWork").html(data["reqInWork"]);
            $("#exp").html(data["percentOfExp"]);
            $("#time").html(data["timeAverage"]);
        }
    });
}

function loadFirstChart(chart, from, to) {
    info = getDataChart("first", from, to);

    datasets = [{
            label: 'ФЛ',
            backgroundColor: '#198754',
            borderColor: '#198754',
            data: info["data"]["FL"],
            fill: false,
        },
        {
            label: 'ЮЛ',
            backgroundColor: '#ffc107',
            borderColor: '#ffc107',
            data: info["data"]["UL"],
            fill: false,
        },
        {
            label: 'ОГВ',
            backgroundColor: '#dc3545',
            borderColor: '#dc3545',
            data: info["data"]["OGV"],
            fill: false,
        }
    ];


    chart.data.labels = info["labels"];
    chart.data.datasets = datasets;
    chart.update();
}

function loadSecondChart(chart, from, to) {
    info = getDataChart("second", from, to);

    datasets = [{
        label: 'Запросов',
        data: info["data"],
        backgroundColor: "#198754",
    }];

    chart.data.labels = info["labels"];
    chart.data.datasets = datasets;
    chart.update();
}

function loadThirdChart(chart, from, to) {
    info = getDataChart("third", from, to);

    datasets = [{
        label: 'Исполнено',
        data: info["data"],
        backgroundColor: "#36A2EB",
    }];

    chart.data.labels = info["labels"];
    chart.data.datasets = datasets;
    chart.update();
}

function getDataTable(dataStatus) {
    dataTbl = $.ajax({
        url: 'data/showRequests.php',
        type: 'GET',
        async: false,
        data: { status: dataStatus },
        success: function(data) {
            return data;
        }
    });
    return $.parseJSON(dataTbl.responseText)
}

function notify(status, text) {
    $('#notifyToastBody').html(text);
    $('#notifyToast').addClass('bg-' + status);
    notifyToast.show();
}

function numFormatter(value) {
    return '<a href="#">' + value + '</a>';
}

function typeFormatter(value) {
    return value.type;
}

function decFormatter(value) {
    return value.name;
}

function objFormatter(value) {
    arr = value.split('; ');
    res = [];
    $.each(arr, function(index, value) {
         if ($.inArray(value, res) == -1)
             res.push(value);

    });
    return res.join('; ');
}


function customSort(sortName, sortOrder, data) {
    var order = sortOrder === 'desc' ? -1 : 1
    data.sort(function(a, b) {
        var aa = +((a[sortName] + '').replace(/[^\d]/g, ''))
        var bb = +((b[sortName] + '').replace(/[^\d]/g, ''))
        if (aa < bb) {
            return order * -1
        }
        if (aa > bb) {
            return order
        }
        return 0
    })
}

$("#uploadTable").on('click', 'tr', function() {
    $('#numReq').removeClass('is-invalid');
    $('#numReq').val($(this).find('td').eq(0).text());
});

$("#uploadTable").on('click', 'a', function() {
    window.open('/tpl/printRequest.php?numLog=' + $(this).html(), '_blank');
});

$("input[name=reqFiles]").change(function() {
    $('#reqFiles').removeClass('is-invalid');
    let names = [];
    let text = '';
    for (var i = 0; i < $(this).get(0).files.length; ++i) {
        names.push($(this).get(0).files[i].name);
    }
    $.each(names, function(index, value) {
        text = text + value + '<br>';
    });
    $("#nameFiles").html(text);
});


$("#upload").click(function() {
    if ($('#numReq').val() == '') {
        $('#numReq').addClass('is-invalid');
        return;
    }

    if ($('#reqFiles').val() == '') {
        $('#reqFiles').addClass('is-invalid');
        return;
    }

    // upload files
    let num = $('#numReq').val();
    let isPaid = $('#isPaid').prop('checked');
    let data = new FormData();
    $.each($('#reqFiles')[0].files, function(i, file) {
        data.append('file[]', file);
    });
    data.append('num', num);
    data.append('isPaid', isPaid);

    $.ajax({
        url: 'data/upload.php',
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        success: function(data) {
            if (data.split(" ")[0] == 'Ошибка') {
                $('#formFiles').trigger('reset');
                $('#nameFiles').html('');
                uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
                notify('danger', data);
            } else {
                (isPaid) ? logger('Файлы загружены и запрос оплачен', $('#numReq').val()) : logger('Файлы загружены', $('#numReq').val());
                $('#formFiles').trigger('reset');
                $('#nameFiles').html('');
                uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
                notify('success', data);
            }
        }
    });

});

$("#remove").click(function() {
    $('#numReq').removeClass('is-invalid');
    if ($('#numReq').val() == '') {
        $('#numReq').addClass('is-invalid');
        return;
    }
    $('#numForDelete').html($('#numReq').val());
    removeAlertModal.show();
});

$("#deleteReq").click(function() {
    $.ajax({
        url: 'data/changeStatus.php',
        type: 'GET',
        data: { status: "Удалён-Свободен", num: $('#numForDelete').html() },
        success: function(data) {
            if (data == 'done') {
                logger('Удалён', $('#numForDelete').html());
                $('#formFiles').trigger('reset');
                removeAlertModal.hide();
                uploadTable.bootstrapTable('load', getDataTable("Ожидает загрузки"));
            } else {
                notify('danger', `Ошибка: ${data}`);
            }
        }
    });
});

$("#printIn").click(function() {
    logDate = $("#logDate").val();
    logNum = $("#logNum").val();
    logType = $("#logType option:selected").val();
    logType == "in" ? logNum = "02-22/" + logNum : logNum = "02-23/" + logNum;
    window.open(`/tpl/formLog.php?logDateStart=${logDate}&logNumStart=${logNum}&logType=${logType}`, '_blank');
});