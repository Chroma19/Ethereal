$(document).ready(function () {
    $('#noJS').hide();
    $('#site').show();
    $('input.timepicker').timepicker({});
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
});


// Smooth scrolling using jQuery easing
$('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function () {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
            $('html, body').animate({
                scrollTop: (target.offset().top - 54)
            }, 1000, "easeInOutExpo");
            return false;
        }
    }
});

// Closes responsive menu when a scroll trigger link is clicked
$('.js-scroll-trigger').click(function () {
    $('.navbar-collapse').collapse('hide');
});

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


// MD5 integration

// function M(d) { for (var _, m = "0123456789ABCDEF", f = "", r = 0; r < d.length; r++)_ = d.charCodeAt(r), f += m.charAt(_ >>> 4 & 15) + m.charAt(15 & _); return f } function X(d) { for (var _ = Array(d.length >> 2), m = 0; m < _.length; m++)_[m] = 0; for (m = 0; m < 8 * d.length; m += 8)_[m >> 5] |= (255 & d.charCodeAt(m / 8)) << m % 32; return _ } function V(d) { for (var _ = "", m = 0; m < 32 * d.length; m += 8)_ += String.fromCharCode(d[m >> 5] >>> m % 32 & 255); return _ } function Y(d, _) { d[_ >> 5] |= 128 << _ % 32, d[14 + (_ + 64 >>> 9 << 4)] = _; for (var m = 1732584193, f = -271733879, r = -1732584194, i = 271733878, n = 0; n < d.length; n += 16) { var h = m, g = f, t = r, e = i; f = md5_ii(f = md5_ii(f = md5_ii(f = md5_ii(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_hh(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_gg(f = md5_ff(f = md5_ff(f = md5_ff(f = md5_ff(f, r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 0], 7, -680876936), f, r, d[n + 1], 12, -389564586), m, f, d[n + 2], 17, 606105819), i, m, d[n + 3], 22, -1044525330), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 4], 7, -176418897), f, r, d[n + 5], 12, 1200080426), m, f, d[n + 6], 17, -1473231341), i, m, d[n + 7], 22, -45705983), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 8], 7, 1770035416), f, r, d[n + 9], 12, -1958414417), m, f, d[n + 10], 17, -42063), i, m, d[n + 11], 22, -1990404162), r = md5_ff(r, i = md5_ff(i, m = md5_ff(m, f, r, i, d[n + 12], 7, 1804603682), f, r, d[n + 13], 12, -40341101), m, f, d[n + 14], 17, -1502002290), i, m, d[n + 15], 22, 1236535329), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 1], 5, -165796510), f, r, d[n + 6], 9, -1069501632), m, f, d[n + 11], 14, 643717713), i, m, d[n + 0], 20, -373897302), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 5], 5, -701558691), f, r, d[n + 10], 9, 38016083), m, f, d[n + 15], 14, -660478335), i, m, d[n + 4], 20, -405537848), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 9], 5, 568446438), f, r, d[n + 14], 9, -1019803690), m, f, d[n + 3], 14, -187363961), i, m, d[n + 8], 20, 1163531501), r = md5_gg(r, i = md5_gg(i, m = md5_gg(m, f, r, i, d[n + 13], 5, -1444681467), f, r, d[n + 2], 9, -51403784), m, f, d[n + 7], 14, 1735328473), i, m, d[n + 12], 20, -1926607734), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 5], 4, -378558), f, r, d[n + 8], 11, -2022574463), m, f, d[n + 11], 16, 1839030562), i, m, d[n + 14], 23, -35309556), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 1], 4, -1530992060), f, r, d[n + 4], 11, 1272893353), m, f, d[n + 7], 16, -155497632), i, m, d[n + 10], 23, -1094730640), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 13], 4, 681279174), f, r, d[n + 0], 11, -358537222), m, f, d[n + 3], 16, -722521979), i, m, d[n + 6], 23, 76029189), r = md5_hh(r, i = md5_hh(i, m = md5_hh(m, f, r, i, d[n + 9], 4, -640364487), f, r, d[n + 12], 11, -421815835), m, f, d[n + 15], 16, 530742520), i, m, d[n + 2], 23, -995338651), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 0], 6, -198630844), f, r, d[n + 7], 10, 1126891415), m, f, d[n + 14], 15, -1416354905), i, m, d[n + 5], 21, -57434055), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 12], 6, 1700485571), f, r, d[n + 3], 10, -1894986606), m, f, d[n + 10], 15, -1051523), i, m, d[n + 1], 21, -2054922799), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 8], 6, 1873313359), f, r, d[n + 15], 10, -30611744), m, f, d[n + 6], 15, -1560198380), i, m, d[n + 13], 21, 1309151649), r = md5_ii(r, i = md5_ii(i, m = md5_ii(m, f, r, i, d[n + 4], 6, -145523070), f, r, d[n + 11], 10, -1120210379), m, f, d[n + 2], 15, 718787259), i, m, d[n + 9], 21, -343485551), m = safe_add(m, h), f = safe_add(f, g), r = safe_add(r, t), i = safe_add(i, e) } return Array(m, f, r, i) } function md5_cmn(d, _, m, f, r, i) { return safe_add(bit_rol(safe_add(safe_add(_, d), safe_add(f, i)), r), m) } function md5_ff(d, _, m, f, r, i, n) { return md5_cmn(_ & m | ~_ & f, d, _, r, i, n) } function md5_gg(d, _, m, f, r, i, n) { return md5_cmn(_ & f | m & ~f, d, _, r, i, n) } function md5_hh(d, _, m, f, r, i, n) { return md5_cmn(_ ^ m ^ f, d, _, r, i, n) } function md5_ii(d, _, m, f, r, i, n) { return md5_cmn(m ^ (_ | ~f), d, _, r, i, n) } function safe_add(d, _) { var m = (65535 & d) + (65535 & _); return (d >> 16) + (_ >> 16) + (m >> 16) << 16 | 65535 & m } function bit_rol(d, _) { return d << _ | d >>> 32 - _ } function MD5(d) { return result = M(V(Y(X(d), 8 * d.length))), result.toLowerCase() }

// function pass_check(id_ispit) {
//     let code = MD5(prompt("Unesite šifru ispita: "));
//     let id = id_ispit;

//     $.post("ajax/pass_check.php?id=" + id, { sifra: code }, function (data) {
//         if (data == "true") {
//             window.location.assign("exam_write.php?id=" + id);
//         }
//         else {
//             window.location.assign("exam_list.php");
//         }
//     });
// }

function ispitPrijava(id_ispit) {
    $.post("ajax/prijava_ispit.php", { prijava: id_ispit }, function (data) {
        alert(data);
    });
}
