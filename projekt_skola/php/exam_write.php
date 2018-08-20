<?php
session_start();
require_once "includes/functions.php";

$con = spajanje();
if(!isset($_SESSION['role'])){
    die('<div class="alert" style="background:yellow;"> 
        <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
        &times;
        </a>
        <strong>Nemate ovlasti za pristup ovoj stranici!</strong>
        </div><br>');
}
else{

$id=$_GET['id'];
$sql = "SELECT ispit.id, tecaj.smjer, lessons.lesson_name FROM tecaj
		INNER JOIN ispit ON ispit.id_tecaj_fk = tecaj.id
		INNER JOIN lessons ON lessons.id = ispit.id_lesson_fk
		WHERE ispit.id = $id;";

$res = mysqli_fetch_assoc(mysqli_query($con, $sql));

$title = "Ispit: ".$res['smjer']."_".$res['lesson_name'];
}

if(!empty($_POST['predaj'])){
	// $_SESSION['odgovori'] = $_POST['odgovori'];
	ispisi_polje($_POST['odgovori']);
}

require_once "includes/header.php";

?>

<form class="form-horizontal" action ="" method = "post">
	
    <?php 
    // Catching questions in string format
	$sql = "SELECT ispit.pitanja_string 
			FROM ispit
			WHERE ispit.id = {$_GET['id']}";
	$pitanja_string = mysqli_query($con,$sql);
	$pitanja_string = mysqli_fetch_assoc($pitanja_string);
	$pitanja_array = implode(",", $pitanja_string);
	$pitanja_array = explode(",", $pitanja_array);


	echo "<div class = 'form-group exam'><ol>";
		$sql = 'SELECT type FROM tip_pitanja';
		$type = mysqli_query($con, $sql);
		if(mysqli_num_rows($type)>0){
			while($type_id = mysqli_fetch_assoc($type)){
				// ispisi_polje ($type_id);
				global $type_id;
			}
		}
	foreach($pitanja_array as $key => $pitanje_id){
		$sql = "SELECT * FROM baza_pitanja WHERE id = '$pitanje_id'";
		$pitanje = mysqli_query($con,$sql);
		$pitanje = mysqli_fetch_assoc($pitanje);

		$tmp = "";
		$tmp .= '<li class = "col-sm-12" id="pitanje['.$pitanje_id.']">'.ucfirst($pitanje['pitanje']);

		$odgovori = $pitanje['ponudeni_odgovori'];
		$odgovori = explode(",", $odgovori);
		// Creating inputs
		switch($pitanje['id_tip_pitanja_fk']){
			case "1":
				// Checkbox
				for($i=0; $i<count($odgovori);$i++){
						$tmp.= '<div><input class = "checkbox" type="checkbox" value = "" name = "odgovor'.$i.'" id = "odgovor'.$i.'">';
						$tmp.= '<label for="odgovori[]" class = "control-label">'.ucfirst($odgovori[$i]).'</label></div>';
					}
				$tmp.= '<p class = "text-muted"><small>Dva su odgovora točna</small></p>';
				break;
				
			case "2":
				// Radio
				for($i=0; $i<count($odgovori);$i++){
						$tmp.= '<div><input class = "radio" type="radio" value = "" name = "odgovor'.$i.'" id = "odgovor'.$i.'">';
						$tmp.= '<label for="odgovori[]" class = "control-label">'.ucfirst($odgovori[$i]).'</label></div>';
					}
				$tmp.= '<p class = "text-muted"><small>Jedan je odgovor točan</small></p>';
				break;

			default:
				// Text
					$tmp.= '<div><input class = "col-sm-7 form-control" type="text" placeholder = "Upišite točan odgovor!" value = "" name = "odgovor" id = "odgovor">';
					$tmp.= '<label for="odgovor" class = "control-label">'.ucfirst($odgovori[0]).'</label></div>';
	}
		$tmp .= '';
		echo $tmp;
	}
		
	echo "</ol></div>";
	
    
    ?>
	
	<div class="form-group">
		<div class="col-sm-offset-5 col-sm-2">
			<input type ="submit" id="predaj" name = "predaj" class ="form-control btn btn-ghost submit" value="Predaj ispit" />
		</div>
	</div>
	
</form>

<?php
require "includes/footer.php";
?>
							
