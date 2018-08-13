<?php
        
    session_start();
    $title = "Upis novog korisnika";
    require_once "includes/functions.php";
    $con = spajanje();
    if($_SESSION['role'] !== "1"){
        die("Nemate ovlasti za pristupanje ovoj stranici! Za povratak na početnu kliknite <a href='index.php'><b>ovdje</b></a>");
    }
    else{
    if(!empty($_POST['posalji'])){
        
        $ime = ocisti_tekst($_POST['ime']);
        $prezime = ocisti_tekst($_POST['prezime']);
        $username = ocisti_tekst($_POST['username']);
        $password = ocisti_tekst(md5($_POST['password']));
        $oib = ocisti_tekst($_POST['oib']);
        $email = ocisti_tekst($_POST['email']);
        $telefon = ocisti_tekst($_POST['telefon']);
        $adresa = ocisti_tekst($_POST['adresa']);
        $id_mjesto_fk = ocisti_tekst($_POST['id_mjesto_fk']);
        $datum_rodjenja = ocisti_tekst($_POST['datum_rodjenja']);
        $id_status_fk = ocisti_tekst($_POST['id_status_fk']); 

        $sql = "INSERT INTO
               `users` 
                (`ime`,`prezime`,`username`,`password`,`oib`,`email`,`telefon`,`adresa`,`id_mjesto_fk`,`datum_rodjenja`,`id_status_fk`)
                VALUES (
                    '$ime',
                    '$prezime',
                    '$username',
                    '$password',
                    '$oib',
                    '$email',
                    '$telefon',
                    '$adresa',
                    '$id_mjesto_fk',
                    '$datum_rodjenja',
                    '$id_status_fk'
                 );";
        $res = mysqli_query($con,$sql);

        if($res){
            $id = mysqli_insert_id($con);
            header("Location:user.php?id=$id");
            
        }
        else{
            echo "korisnik nije upisan " .mysqli_error($con);
        }
    }
    }
    
    require_once ("includes/header.php"); 
?>


    <form class = "form-horizontal" action="" method = "post">

        <div class="form-group">
		    <label for ="ime" class="col-sm-2 control-label">Ime</label>
		        <div class = "col-sm-7">
			        <input type="text" id="ime" name="ime" class ="form-control" value="" required/>
		        </div>
	    </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="prezime">Unesite prezime:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='prezime' id='prezime'  value = "" required> 
                </div>
        </div>
        
        <div class="form-group">
            <label class="col-sm-2 control-label" for="username">Unesite korisničko ime:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='username' id='username'  value = "" required>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="password">Unesite lozinku (min 8 znakova):</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="password" name='password' id='password'  value = "" required>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="password_check">Potvrdite lozinku</label>
                <div id = "div_pc" class = "col-sm-7">
                    <input class ="form-control" type="password" name='password_check' id='password_check' value = "" required>
                </div>
        </div>


        <div class="form-group">
            <label class="col-sm-2 control-label" for="oib">Unesite OIB:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='oib' id='oib' pattern="[0-9]{11}" value = "" required>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">Unesite email:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="email" name='email' id='email' value = "" required>
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="telefon">Unesite broj mobitela:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text"  required placeholder = "npr. 095/123-4567" name='telefon' id='telefon' value = "">
                </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="adresa">Unesite adresu:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="text" name='adresa' id='adresa' value = "" required>
                </div>
        </div>

        <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_mjesto_fk">Odaberite mjesto:</label>
            <div class = "col-sm-7">
                <select class ="form-control" name='id_mjesto_fk' id='id_mjesto_fk' value = "" required>
                <option value="NULL" selected disabled>--</option>

                <?php 
                
                $sql = "SELECT * FROM mjesto";
                $res_mjesto = mysqli_query ($con, $sql);

                if(mysqli_num_rows($res_mjesto)>0){
                    while($mjesto = mysqli_fetch_assoc($res_mjesto)){
                            echo '<option value="'.$mjesto['id'].'">';
                            echo $mjesto['naziv'];
                            echo '</option>'; 
                    }
                }

                ?>

                </select>
            </div>
        </div>
        

        <div class="form-group"> 
            <label class="col-sm-2 control-label" for="datum_rodjenja">Odaberite datum rodjenja:</label>
                <div class = "col-sm-7">
                    <input class ="form-control" type="date" name='datum_rodjenja' id='datum_rodjenja' value = "" required>
                </div>
        </div>



        <!-- select -->
        <div class="form-group">
          <label class="col-sm-2 control-label" for="id_status_fk">Odaberite ulogu:</label>
            <div class = "col-sm-7">
                <select class ="form-control" type="text" name='id_status_fk' id='id_status_fk' required>
                
                <option value="NULL" selected disabled>--</option>

                <?php 
                
                $sql = "SELECT * FROM roles";
                $res_roles = mysqli_query ($con, $sql);

                if(mysqli_num_rows($res_roles)>0){
                    while($roles = mysqli_fetch_assoc($res_roles)){
                            echo '<option value="'.$roles['id'].'">';
                            echo ucfirst($roles['status']);
                            echo '</option>'; 
                    }
                }

                ?>

                </select>
            </div>
        </div>

        <div class="form-group">
          <div class="col-sm-2 col-sm-offset-5">
            <input onclick = "pas_val(); check(); "  class ="form-control btn btn-ghost" id="posalji" value = "Dodaj korisnika" name="posalji" type="submit">
          </div>
        </div>
    </form>   


    <script>

            var password = document.getElementById("password");
            var confirm_password = document.getElementById("password_check");

            function validatePassword(){
            if(password.value != confirm_password.value) {
                confirm_password.style = "border-color:red";
                confirm_password.setCustomValidity("Lozinke se ne podudaraju!");
            } else {
                confirm_password.removeAttribute("style");
                confirm_password.setCustomValidity('');
            }
            }

        password.onchange = validatePassword;
        confirm_password.onkeyup = validatePassword;


        function pas_val(){
            if (password.value.length<8){
                password.style = "border-color:red";
                password.setCustomValidity("Lozinka je prekratka!")
            }
            else {
                password.removeAttribute("style");
                password.setCustomValidity("");
            }
        }
        

            
    </script>


<?php require_once("includes/footer.php");?>