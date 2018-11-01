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

$(function () {
    menuSliding();
    utils();
    carousel();
    demo();
});

/* for demo purpose only - can be deleted */

function demo() {

    if ($('#style-switch').length > 0) {
        var stylesheet = $('link#theme-stylesheet');
        $("<link id='new-stylesheet' rel='stylesheet'>").insertAfter(stylesheet);
        var alternateColour = $('link#new-stylesheet');

        if ($.cookie("theme_csspath")) {
            alternateColour.attr("href", $.cookie("theme_csspath"));
        }

        $("#colour").change(function () {

            if ($(this).val() !== '') {

                var theme_csspath = '../css/style.' + $(this).val() + '.css';

                alternateColour.attr("href", theme_csspath);

                $.cookie("theme_csspath", theme_csspath, {
                    expires: 365,
                    path: document.URL.substr(0, document.URL.lastIndexOf('/'))
                });

            }

            return false;
        });
    }

}

/* =========================================
 *  carousel
 *  =======================================*/

function carousel() {

    $('.carousel').carousel({
        interval: 1000 * 10
    });
}


/* menu sliding */

function menuSliding() {


    $('.dropdown').on('show.bs.dropdown', function (e) {

        if ($(window).width() > 750) {
            $(this).find('.dropdown-menu').first().stop(true, true).slideDown();

        } else {
            $(this).find('.dropdown-menu').first().stop(true, true).show();
        }
    }

    );
    $('.dropdown').on('hide.bs.dropdown', function (e) {
        if ($(window).width() > 750) {
            $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
        } else {
            $(this).find('.dropdown-menu').first().stop(true, true).hide();
        }
    });

}

/* animations */

function animations() {
    delayTime = 0;
    $('[data-animate]').css({
        opacity: '0'
    });
    $('[data-animate]').waypoint(function (direction) {
        delayTime += 150;
        $(this).delay(delayTime).queue(function (next) {
            $(this).toggleClass('animated');
            $(this).toggleClass($(this).data('animate'));
            delayTime = 0;
            next();
            //$(this).removeClass('animated');
            //$(this).toggleClass($(this).data('animate'));
        });
    }, {
            offset: '90%',
            triggerOnce: true
        });

    $('[data-animate-hover]').hover(function () {
        $(this).css({
            opacity: 1
        });
        $(this).addClass('animated');
        $(this).removeClass($(this).data('animate'));
        $(this).addClass($(this).data('animate-hover'));
    }, function () {
        $(this).removeClass('animated');
        $(this).removeClass($(this).data('animate-hover'));
    });

}

function animationsSlider() {

    var delayTimeSlider = 400;

    $('.owl-item:not(.active) [data-animate-always]').each(function () {

        $(this).removeClass('animated');
        $(this).removeClass($(this).data('animate-always'));
        $(this).stop(true, true, true).css({
            opacity: 0
        });

    });

    $('.owl-item.active [data-animate-always]').each(function () {
        delayTimeSlider += 500;

        $(this).delay(delayTimeSlider).queue(function (next) {
            $(this).addClass('animated');
            $(this).addClass($(this).data('animate-always'));

            console.log($(this).data('animate-always'));

        });
    });



}

/* counters */

function counters() {

    $('.counter').counterUp({
        delay: 10,
        time: 1000
    });

}

function utils() {

    /* tooltips */

    $('[data-toggle="tooltip"]').tooltip();

    /* click on the box activates the radio */

    $('#checkout').on('click', '.box.shipping-method, .box.payment-method', function (e) {
        var radio = $(this).find(':radio');
        radio.prop('checked', true);
    });
    /* click on the box activates the link in it */

    $('.box.clickable').on('click', function (e) {

        window.location = $(this).find('a').attr('href');
    });
    /* external links in new window*/

    $('.external').on('click', function (e) {

        e.preventDefault();
        window.open($(this).attr("href"));
    });
    /* animated scrolling */

    $('.scroll-to, .scroll-to-top').click(function (event) {

        var full_url = this.href;
        var parts = full_url.split("#");
        if (parts.length > 1) {

            scrollTo(full_url);
            event.preventDefault();
        }
    });

    function scrollTo(full_url) {
        var parts = full_url.split("#");
        var trgt = parts[1];
        var target_offset = $("#" + trgt).offset();
        var target_top = target_offset.top - 100;
        if (target_top < 0) {
            target_top = 0;
        }

        $('html, body').animate({
            scrollTop: target_top
        }, 1000);
    }
}


$.fn.alignElementsSameHeight = function () {
    $('.same-height-row').each(function () {

        var maxHeight = 0;
        var children = $(this).find('.same-height');
        children.height('auto');
        if ($(window).width() > 768) {
            children.each(function () {
                if ($(this).innerHeight() > maxHeight) {
                    maxHeight = $(this).innerHeight();
                }
            });
            children.innerHeight(maxHeight);
        }

        maxHeight = 0;
        children = $(this).find('.same-height-always');
        children.height('auto');
        children.each(function () {
            if ($(this).height() > maxHeight) {
                maxHeight = $(this).innerHeight();
            }
        });
        children.innerHeight(maxHeight);

    });
}

$(window).on('load', (function () {

    windowWidth = $(window).width();

    $(this).alignElementsSameHeight();

}));
$(window).resize(function () {

    newWindowWidth = $(window).width();

    if (windowWidth !== newWindowWidth) {
        setTimeout(function () {
            $(this).alignElementsSameHeight();
        }, 205);
        windowWidth = newWindowWidth;
    }

});

(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD
		define(['jquery'], factory);
	} else if (typeof exports === 'object') {
		// CommonJS
		factory(require('jquery'));
	} else {
		// Browser globals
		factory(jQuery);
	}
}(function ($) {

	var pluses = /\+/g;

	function encode(s) {
		return config.raw ? s : encodeURIComponent(s);
	}

	function decode(s) {
		return config.raw ? s : decodeURIComponent(s);
	}

	function stringifyCookieValue(value) {
		return encode(config.json ? JSON.stringify(value) : String(value));
	}

	function parseCookieValue(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape...
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}

		try {
			// Replace server-side written pluses with spaces.
			// If we can't decode the cookie, ignore it, it's unusable.
			// If we can't parse the cookie, ignore it, it's unusable.
			s = decodeURIComponent(s.replace(pluses, ' '));
			return config.json ? JSON.parse(s) : s;
		} catch(e) {}
	}

	function read(s, converter) {
		var value = config.raw ? s : parseCookieValue(s);
		return $.isFunction(converter) ? converter(value) : value;
	}

	var config = $.cookie = function (key, value, options) {

		// Write

		if (value !== undefined && !$.isFunction(value)) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setTime(+t + days * 864e+5);
			}

			return (document.cookie = [
				encode(key), '=', stringifyCookieValue(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// Read

		var result = key ? undefined : {};

		// To prevent the for loop in the first place assign an empty array
		// in case there are no cookies at all. Also prevents odd result when
		// calling $.cookie().
		var cookies = document.cookie ? document.cookie.split('; ') : [];

		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = parts.join('=');

			if (key && key === name) {
				// If second argument (value) is a function it's a converter...
				result = read(cookie, value);
				break;
			}

			// Prevent storing a cookie that we couldn't decode.
			if (!key && (cookie = read(cookie)) !== undefined) {
				result[name] = cookie;
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) === undefined) {
			return false;
		}

		// Must not alter options, thus extending a fresh object...
		$.cookie(key, '', $.extend({}, options, { expires: -1 }));
		return !$.cookie(key);
	};

}));
