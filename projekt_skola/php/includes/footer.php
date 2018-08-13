    </div>
    <div id="bottom"></div>
<footer class = "footer"> 
      <div class="footer__copyright">
        <div class="container">
          <div class="row">
            <div class="col-md-4">
              <p>&copy;2018 Ethereal. Sva prava pridržana.</p>
            </div>
            <div class="col-md-4">
              <p style = "text-align:center"><a href="#site" class = "js-scroll-trigger">Povratak na vrh</p>
            </div>
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <p class="credit"><a href="https://bootstrapious.com/free-templates" class="external">Template by Bootstrapious templates</a></p>
            </div>
          </div>
        </div>
      </div>
    </footer>
    
   
    <button type="button" style = "position:absolute; top:67px;" data-toggle="collapse" data-target="#style-switch" id="style-switch-button" class="btn btn-primary btn-sm"><span class="fa fa-cog fa-2x"></span></button>
    <div id="style-switch" class="collapse collapse-div">
      <h4 class="text-uppercase">Odaberi temu</h4>
      <form class="margin-bottom">
        <select name="colour" id="colour" class="form-control">
          <option selected disabled value="">Odaberite temu</option>
          <option value="default">Ružičasta</option>
          <option value="blue">Plava</option>
          <option value="green">Zelena</option>
          <option value="red">Crvena</option>
          <option value="sea">Morsko plava</option>
          <option value="violet">Ljubičasta</option>
        </select>
      </form>
      <p class="text-muted text-small">Mijenjanje teme ne utječe na rad stranice.</p>
    </div>

    <a href="#bottom" class = "js-scroll-trigger">
        <button id = "scroll-to-bottom" type = "button" class = "btn-primary btn btn-sm">
            <i class="fa fa-chevron-circle-down fa-2x"></i>
        </button>
    </a> 

    <!-- skripte-->
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src = "//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://blackrockdigital.github.io/startbootstrap-agency/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src = "../js/bundle.js"></script>
    <script src="../js/jquery.cookie.js"> </script>
    <script src="../js/lightbox.js"></script>
    <script src="../js/front.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
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
                
                //za svaku grupu (input check/radio + tekst) kreiram div
                let div = document.createElement("p");
                div.classList.add("form_parag");
            
                

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
                //dodajem u div inpute - prvo chb/radio pa onda text            
                div.appendChild(label);
                div.appendChild(txt_input);

                //na kraju dodajem div u formu
                forma.appendChild(div);
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

  
    </script>
        
	
	
  </body>
</html>
<?php mysqli_close($con);?>
