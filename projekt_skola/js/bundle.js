function blockFill(){
    var tecaj=document.getElementById("id_tecaj_fk").value;
    if(tecaj=="NULL"){
        $("article").hide();
    }
}
$(document).on("change","#id_tecaj_fk",function(){
    $("article").show();
});


$(document).ready(function(){
    $('#noJS').hide();
    $('#site').show();
    $('input.timepicker').timepicker({});
});
$(document).ready( function () {
$('#table').DataTable();
} );

// Smooth scrolling using jQuery easing
$('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
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
$('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
});

function traziLekcija(id_tecaj_fk){
        $.post("ajax/trazilica_lekcija.php", {odabrani_tecaj:id_tecaj_fk}, function(data){
            //ovaj kod izvrsavamo nakon sto nam je dosao rezultat iz baze
            if(data.length > 0){
                $("#id_lesson_fk").html(data);
                
                var id_lesson_fk = $("#id_lesson_fk option:selected").val();
                traziPitanja(id_lesson_fk);
            }
        });
    }
    function traziPitanja(id_lesson_fk){
    $.post("ajax/trazilica_pitanje.php", {odabrana_lekcija:id_lesson_fk}, function(data){
        if(data.length > 0){
            $("#pitanje").html(data);
        }
    });
}
function createInputs(){
    var option = document.getElementById("id_tip_pitanja");
    var forma = document.getElementById("solution");
    
    //uklanjam sve paragrafe u kojima su inputi. svim paragrafima sam dao class 'form_parag'
    var elements = document.getElementsByClassName("form_parag");
    while(elements.length > 0){
        elements[0].parentNode.removeChild(elements[0]);
    }
    
    if (option.value == 1 || option.value == 2){
        
        for(let i = 0; i<=3; i++){
            
            //za svaku grupu (input check/radio + tekst) kreiram p
            let p = document.createElement("p");
            p.classList.add("form_parag");
        
            

            //kreiram input text
            let txt_input = document.createElement("input");
            txt_input.id = "txt"+i;
            txt_input.name = "ponudeni_odgovori[]";
            txt_input.type = "text";
            txt_input.required = "required";
            txt_input.placeholder = "Upišite odgovor!";
            txt_input.classList.add("form-control");
            

            //kreiram radio ili checkbox - ovisi što je odabrano u onom selectu
            let rjesenje_input = document.createElement("input");
            rjesenje_input.id = "correct"+i;
            rjesenje_input.name = "rjesenje[]";
            rjesenje_input.value = i;
            rjesenje_input.classList.add("form-control");
            rjesenje_input.type = option.options[option.selectedIndex].id;

            let label = document.createElement("label");
            label.classList.add("checkbox");
            label.classList.add("control-label");
            label.style = "margin-right:15px; margin-bottom:13px";
            label.appendChild(rjesenje_input);
            //dodajem u p inpute - prvo chb/radio pa onda text            
            p.appendChild(label);
            p.appendChild(txt_input);

            //na kraju dodajem p u formu
            forma.appendChild(p);
        }
    }
    
    else {
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

function check(){
var telefon = document.getElementById("telefon");
var oib = document.getElementById("oib");

    if(isNaN(telefon.value ) || telefon.value.length < 9){
        telefon.style = "border-color:red";   
        telefon.setCustomValidity("Molimo upišite broj u pravilnom formatu!") 
    }
    else{
        telefon.removeAttribute("style");
        telefon.setCustomValidity("");
    }

    if(isNaN(oib.value) || oib.value.length<11){
        oib.style = "border-color:red"; 
        oib.setCustomValidity("Molimo upišite OIB u pravilnom formatu!")  
    }
    else{
        oib.removeAttribute("style");
        oib.setCustomValidity("");
    }
}  


let site = document.getElementById("site");
site.className = "home";

let btn = document.getElementById("btn-adjust");
btn.removeAttribute("class");
btn.classList.add("btn");
btn.classList.add("navbar-btn");
btn.classList.add("btn-white");
btn.classList.add("pull-left");

let container = document.getElementById("top-container");
container.removeAttribute("id");
container.removeAttribute("class");