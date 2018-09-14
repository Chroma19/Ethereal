<?php
session_start();
require_once "includes/functions.php";
$con = spajanje();
if($_SESSION['login'] !== true){
	die('<div class="alert" style="background:yellow;"> 
	<a href="index.php" class="close" data-dismiss="alert" aria-label="close">
	&times;
	</a>
	<strong>Nemate ovlasti za pristup ovoj stranici!</strong>
	
	</div>');
}
else{

if(!isset($_GET['id'])){
	die("Nije predan id parametar!");
}

// Getting user name and surname
$id=$_GET['id'];
global $id;
$get_name = "SELECT users.ime, users.prezime FROM users WHERE users.id = $id;";
$res = mysqli_query($con, $get_name);
$name = mysqli_fetch_assoc($res);
$name = implode(" ", $name);
$title = $name;

$sql = "SELECT users.ime,users.prezime,users.oib,users.telefon,users.adresa,users.email, mjesto.naziv 
		FROM users
        INNER JOIN mjesto ON users.id_mjesto_fk = mjesto.id 
		WHERE users.id = $id;";


$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result)==1){
	$user = mysqli_fetch_assoc($result);
}
else {
	$user = null;
	die('<div class="alert" style="background:yellow;"> 
        <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
        &times;
        </a>
        <strong>Nije odabran niti jedan korisnik!</strong>
        
        </div>');
}
}
require_once "includes/header.php";
?>
<form class="form-horizontal" action ="" method = "get">

	<div class="form-group">
		<label for ="ime" class="col-sm-2 control-label">Ime</label>
		<div class="col-sm-5">
			<input type="text" disabled id="ime" name="ime" class ="form-control transparent" value="<?=$user['ime'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="prezime" class="col-sm-2 control-label">Prezime</label>
		<div class="col-sm-5">
			<input type="text" disabled id="prezime" name="prezime" class ="form-control transparent" value="<?=$user['prezime'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="adresa" class="col-sm-2 control-label">Adresa</label>
		<div class="col-sm-5">
			<input type="text" disabled id="adresa" name="adresa" class ="form-control transparent" value="<?=$user['adresa'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="oib" class="col-sm-2 control-label">OIB</label>
		<div class="col-sm-5">
			<input type="text" disabled id="oib" name="oib" class ="form-control transparent" value="<?=$user['oib'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="email" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-5">
			<input type="email" disabled id="email" name="email" class ="form-control transparent" value="<?=$user['email'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="telefon" class="col-sm-2 control-label">Telefon</label>
		<div class="col-sm-5">
			<input type="text" disabled id="telefon" name="telefon" class ="form-control transparent" value="<?=$user['telefon'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="mjesto" class="col-sm-2 control-label">Mjesto</label>
            <div class="col-sm-5">
                <input type="text" disabled id="mjesto" name="mjesto" class ="form-control transparent" value="<?=$user['naziv'];?>"/>
            </div>
	</div>
	
    <div class="form-group">
		<label for ="mjesto" class="col-sm-2 control-label">Rezultati ispita</label>
            <div class="col-sm-5">
            <?php
            $sql = "SELECT results.id, results.id_ispit_fk, results.result, lessons.lesson_name, tecaj.smjer FROM results
                    INNER JOIN ispit ON results.id_ispit_fk = ispit.id
                    INNER JOIN lessons ON ispit.id_lesson_fk = lessons.id
                    INNER JOIN tecaj ON ispit.id_tecaj_fk = tecaj.id
                    WHERE id_osobe_fk = $id";

            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result)>0){
                while($ispit = mysqli_fetch_assoc($result)){
                        echo "<pre><p>".$ispit['smjer']." ".$ispit['lesson_name']."</p>";
                        echo '<input type="text" disabled id = "'.$ispit['id'].'" class="form-control transparent" name = "'.$ispit['id'].'" value = "'.$ispit['result'].'"/></pre>';
                }
            }

            else{
                echo "Nema dostupnih rezultata!";
            }
            ?>
            </div>
	</div>

	</div>
</form>



<?php

//--------------------------------
require "includes/footer.php";
							
?>