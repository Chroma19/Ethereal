$(document).ready(function () {
    $('#noJS').hide();
    $('#site').show();
    $('#table').DataTable();
    $(".clickable-row-users").click(function () {
        window.location.assign("user.php?id=" + $(this).attr('id'));
    });
    $(".clickable-row-exam").click(function () {
        window.location.assign("exam_write.php?id=" + $(this).attr('id'));
    });
    $(".clickable-row-course").click(function () {
        window.location.assign("course.php?id=" + $(this).attr('id'));
    });
    $(".clickable-row-group").click(function () {
        window.location.assign("group.php?id=" + $(this).attr('id'));
    });
});

// AJAX functions
function traziGrupe(id_tecaj_fk) {
    $.post("ajax/trazilica_grupe.php", {
        odabrani_tecaj: id_tecaj_fk
    }, function (data) {
        if (data.length > 0) {
            $("#id_grupa_fk").html(data);
        }
    });
}

function traziLekcija(id_tecaj_fk) {
    $.post("ajax/trazilica_lekcija.php", {
        odabrani_tecaj: id_tecaj_fk
    }, function (data) {
        if (data.length > 0) {
            $("#id_lesson_fk").html(data);
            var id_lesson_fk = $("#id_lesson_fk option:selected").val();
            traziPitanja(id_lesson_fk);
        }
    });
}


function traziPitanja(id_lesson_fk) {
    $.post("ajax/trazilica_pitanje.php", {
        odabrana_lekcija: id_lesson_fk
    }, function (data) {
        if (data.length > 0) {
            $("#pitanje").html(data);
        }
    });
}

function createInputs() {
    var option = document.getElementById("id_tip_pitanja");
    var forma = document.getElementById("solution");

    //uklanjam sve paragrafe u kojima su inputi. svim paragrafima sam dao class 'form_parag'
    var elements = document.getElementsByClassName("form_parag");
    while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
    }

    if (option.value == 1 || option.value == 2) {

        for (let i = 0; i <= 3; i++) {

            //za svaku grupu (input check/radio + tekst) kreiram p
            let p = document.createElement("p");
            p.classList.add("form_parag");



            //kreiram input text
            let txt_input = document.createElement("input");
            txt_input.id = "txt" + i;
            txt_input.name = "ponudeni_odgovori[]";
            txt_input.type = "text";
            txt_input.required = "required";
            txt_input.placeholder = "Upišite odgovor!";
            txt_input.classList.add("form-control");


            //kreiram radio ili checkbox - ovisi što je odabrano u onom selectu
            let rjesenje_input = document.createElement("input");
            rjesenje_input.id = "correct" + i;
            rjesenje_input.name = "rjesenje[]";
            rjesenje_input.value = i;
            rjesenje_input.classList.add("form-control");
            rjesenje_input.type = option.options[option.selectedIndex].id;
            rjesenje_input.style = "-ms-transform: scale(0.5);";
            rjesenje_input.style = "-moz-transform: scale(0.5);";
            rjesenje_input.style = "-webkit-transform: scale(0.5);";
            rjesenje_input.style = "-o-transform: scale(0.5);";
            p.appendChild(rjesenje_input);
            p.appendChild(txt_input);

            //na kraju dodajem p u formu
            forma.appendChild(p);
        }
    } else {
        let div = document.createElement("div");
        div.classList.add("form_parag");
        let rjesenje = document.createElement("input");
        rjesenje.id = "rjesenje[]";
        rjesenje.name = "rjesenje[]";
        rjesenje.type = "text";
        rjesenje.placeholder = "Upišite točan odgovor!";
        rjesenje.classList.add("form_parag");
        rjesenje.classList.add("form-control");
        rjesenje.required = "required";
        div.appendChild(rjesenje);
        forma.appendChild(div);

    }
}
// End of AJAX


function check() {
    var telefon = document.getElementById("telefon");
    var oib = document.getElementById("oib");

    if (isNaN(telefon.value) || telefon.value.length < 9) {
        telefon.style = "border-color:red";
        telefon.setCustomValidity("Molimo upišite broj u pravilnom formatu!");
    } else {
        telefon.removeAttribute("style");
        telefon.setCustomValidity("");
    }

    if (isNaN(oib.value) || oib.value.length < 11) {
        oib.style = "border-color:red";
        oib.setCustomValidity("Molimo upišite OIB u pravilnom formatu!");
    } else {
        oib.removeAttribute("style");
        oib.setCustomValidity("");
    }
}

function checkAll() {

    let password = document.getElementById("sifra");

    if (password.value.length < 8) {
        password.style = "border-color:red";
        password.setCustomValidity("Lozinka je prekratka!");
    } else {
        password.removeAttribute("style");
        password.setCustomValidity("");

        var q = new Date();
        var m = q.getMonth();
        var d = q.getDay();
        var y = q.getFullYear();
        var h = q.getHours();

        var date = q;

        var date_exam = document.getElementById("datum_ispita").value;
        var date_exam = Date.parse(date_exam);
        var date = Date.parse(date);
        var input = document.getElementById("datum_ispita");

        if (date > date_exam) {
            input.style = "border-color:red";
            input.setCustomValidity("Unesite važeći datum i vrijeme!");
        } else {
            input.removeAttribute("style");
            input.setCustomValidity("");

            let dur = document.getElementById("trajanje_ispita");
            if (isNaN(dur.value)) {
                dur.style = "border-color:red";
                dur.setCustomValidity("Unesite važeće trajanje!");
            } else if (dur.value > 300 || dur.value < 15) {
                dur.style = "border-color:red";
                dur.setCustomValidity("Unesite važeće trajanje!");
            } else {
                dur.removeAttribute("style");
                dur.setCustomValidity("");
            }

        }

    }

}


var password = document.getElementById("password");
var confirm_password = document.getElementById("password_check");

function validatePassword() {
    if (password.value != confirm_password.value) {
        confirm_password.style = "border-color:red";
        confirm_password.setCustomValidity("Lozinke se ne podudaraju!");
    } else {
        confirm_password.removeAttribute("style");
        confirm_password.setCustomValidity('');
    }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;


function pas_val() {
    if (password.value.length < 8) {
        password.style = "border-color:red";
        password.setCustomValidity("Lozinka je prekratka!");
    } else {
        password.removeAttribute("style");
        password.setCustomValidity("");
    }
}

function startcheck() {
    var q = new Date();
    var m = q.getMonth();
    var d = q.getDay();
    var y = q.getFullYear();
    var h = q.getHours();

    var date = q;

    var date_group = document.getElementById("datum_pocetka").value;
    var date_group = Date.parse(date_group);
    var date = Date.parse(date);
    var input = document.getElementById("datum_pocetka");

    if (date > date_group) {
        input.style = "border-color:red";
        input.setCustomValidity("Unesite važeći datum i vrijeme!");
    } else {
        input.removeAttribute("style");
        input.setCustomValidity("");
    }
}

function toggleResults() {
    $("#loadMore").click(
        $(".results").toggle(400, 'linear')
    )
};

