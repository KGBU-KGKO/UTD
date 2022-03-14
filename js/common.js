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
                list.push({ label: value.numLog + " | " + value.dateReq.split(' ')[0] + " | " + value.status + " | " + value.name + " | " + value.realEstate + " | " + value.performer, value: value.numLog+'|'+value.type });
            });

            $("#gSearch").autocomplete({
                source: list,
                position: {
			        my : "center top",
			        at: "center bottom"
			    }
            });
        }
    });
}

$("#gSearch").on("autocompleteselect", function(event, ui) {
	$(this).val(ui.item.value.split('|')[0]);
    addModalInfo(ui.item.value.split('|')[0], ui.item.value.split('|')[1]);
    reqInfoModal.show();    
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