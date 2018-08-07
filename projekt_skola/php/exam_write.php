<?php
session_start();
require_once "includes/functions.php";

$con = spajanje();
$id=$_GET['id'];
$sql = "SELECT ispit.id, tecaj.naziv, lessons.lesson_name FROM tecaj
		INNER JOIN ispit ON ispit.id_tecaj_fk = tecaj.id
		INNER JOIN lessons ON lessons.id = ispit.id_lesson_fk
		WHERE ispit.id = $id;";

$res = mysqli_fetch_assoc(mysqli_query($con, $sql));

$title = "Ispit_".$res['naziv']."_".$res['lesson_name'];

require_once "includes/header.php";



if(!empty($_POST['spremi'])){
	
	$ime= $_POST['ime'];
	$prezime= $_POST['prezime'];
	$adresa= $_POST['adresa'];
	$oib= $_POST['oib'];
	$telefon= $_POST['telefon'];
	$email= $_POST['email'];
	if(!empty($_POST['pbr']))
		$pbr= $_POST['pbr'];
	else
		$pbr = "NULL";
	
	$sql = "UPDATE polaznik
			SET
				ime = '$ime',
				prezime = '$prezime',
				adresa = '$adresa',
				oib = '$oib',
				telefon = '$telefon',
				email = '$email',
				pbr = '$pbr'
			WHERE
				id = {$_GET['id']}
			";
	
	$rez = mysqli_query($con, $sql);
	

	if($rez){
		$poruka.= "Ispit predan";
	}
	else{
		$greska.="Ispit nije predan. ".mysqli_error($con);
	}
}

if(!isset($id)){
	die("Nije predan id parametar!");
}

//kada imamo ID, kreiramo sql upit
$sql = "SELECT * 
		FROM ispit 
		WHERE id = $id;";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result)==1){
	$ispit = mysqli_fetch_assoc($result);
}
else {
	$ispit = null;
	die("Nije pronađen ispit!");
}

?>

<form class="form-horizontal" action ="" method = "post">
	
    <?php 
    

    
    ?>
	
	<div class="form-group">
		<div class="col-sm-offset-6 col-sm-2">
			<input type ="submit" id="spremi" name = "spremi" class ="form-control btn btn-primary" value="Spremi" />
		</div>
	</div>
	
</form>

<?php
require "includes/footer.php";
?>
							
