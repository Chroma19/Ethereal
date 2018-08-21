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

$sql_pitanja = "SELECT ispit.pitanja_string 
FROM ispit
WHERE ispit.id = {$_GET['id']}";
$pitanja_string = mysqli_query($con,$sql_pitanja);
$pitanja_array = mysqli_fetch_assoc($pitanja_string);
$pitanja_array = implode(",", $pitanja_array);
$pitanja_array = explode(",", $pitanja_array);
// Needed for later sql queries
$pitanja_string = implode(",", $pitanja_array);



foreach ($pitanja_array as $k => $pitanje_id){
	global $pitanje_id;
}
	if(isset($_POST['predaj']) and !empty($_POST['odgovori'.$pitanje_id])){
		for ($a=0;$a<count($pitanja_array);$a++){
			$odgovor[$a] =  $_POST['odgovori'.$pitanja_array[$a]];
			$odgovor[$a] = implode(",", $odgovor[$a]);
			$odgovor[$a] = explode(",", $odgovor[$a]);
			$_SESSION['odgovor'.$a] = $odgovor[$a];
		}

		$sql = "SELECT id, id_tip_pitanja_fk, rjesenje
					FROM baza_pitanja
					WHERE id IN ($pitanja_string);";

			$pitanja = mysqli_query($con, $sql);
			if(mysqli_num_rows($pitanja)>0){
				$all_q = array();
				while($pitanje = mysqli_fetch_assoc($pitanja)){
					for($a=0; $a<count($pitanja_array); $a++){
							$all_q[$a] = $pitanje;
						}
					ispisi_polje($pitanje);
				}
				ispisi_polje($all_q);
			}
			else{
				echo mysqli_error($con);
			}
		
		
		

	}	

require_once "includes/header.php";

?>

<form class="form-horizontal" action ="" method = "post">
	
    <?php 
    // Catching questions in string format
	


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
				$tmp.= '<div>';
				
				for($i=0; $i<count($odgovori);$i++){
					$tmp.= '<input name = "odgovori'.$pitanje_id.'[]" class = "checkbox single-checkbox" type="checkbox" value = "'.$i.'" id = "odgovori'.$i.$pitanje_id.'">';
					$tmp.= '<label for = "odgovori'.$i.$pitanje_id.'">'.ucfirst($odgovori[$i]).'</label>
								<br>';
					}
				$tmp.= '</div><p class = "text-muted"><small>Dva su odgovora točna</small></p>';
				break;
				
			case "2":
				// Radio
				$tmp.= '<div>';
				for($i=0; $i<count($odgovori);$i++){
						$tmp.= '<input name = "odgovori'.$pitanje_id.'[]" class = "radio" type="radio" value = "'.$i.'" id = "odgovori'.$i.$pitanje_id.'">';
						$tmp.= '<label for = "odgovori'.$i.$pitanje_id.'">'.ucfirst($odgovori[$i]).'</label>
						<br>';
					}
				$tmp.= '</div><p class = "text-muted"><small>Jedan je odgovor točan</small></p>';
				break;

			default:
				// Text
					$tmp.= '<div><input name = "odgovori'.$pitanje_id.'[]" class = "col-sm-7 form-control" type="text" placeholder = "Upišite točan odgovor!" value = "">';
					$tmp.= '<label for="odgovori[]" class = "control-label">'.ucfirst($odgovori[0]).'</label></div>';
	}
		$tmp .= '</li>';
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
<script>
var limit = 2;
$('input.single-checkbox').on('change', function(evt) {
    if($(this).siblings(':checked').length >= limit) {
        this.checked = false;
    }
});
</script>
							
