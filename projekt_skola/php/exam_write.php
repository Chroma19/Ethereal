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
	if(isset($_POST['predaj']) and !empty($_POST[$pitanje_id])){

		$sql = "SELECT id, rjesenje
					FROM baza_pitanja
					WHERE id IN ($pitanja_string);";

			$pitanja = mysqli_query($con, $sql);
			if(mysqli_num_rows($pitanja)>0){
				$all_q = array();
				global $bodovi;
				$bodovi = 0;
				while($pitanje = mysqli_fetch_assoc($pitanja)){
					$all_q[$pitanje['id']] = $pitanje;
					$tocno_rj = $all_q[$pitanje['id']];
					
					for($c = 0; $c<=$pitanje_id; $c++){
						global $c;
					}
					global $max_bodovi;
					$max_bodovi = count($pitanja_array);
						$ponudeno_rj[$c] = implode(",",$_POST[$pitanje['id']]); 
						if($ponudeno_rj[$c] == $tocno_rj['rjesenje']){
							$bodovi++;
						}
					}
					global $total;
					$total = round($bodovi/$max_bodovi*100, 2) ."%";
				}
			else{
				echo mysqli_error($con);
			}
		$user = $_SESSION['userid'];
		$id=$_GET['id'];
		$send = 'INSERT INTO results (id_osobe_fk, id_ispit_fk, result)
				VALUES ("$user",  "$id", "$total");';
		
		$res = 	mysqli_query($con, $send);

		if(!$res){echo mysqli_error($con); }
	}	
ispisi_polje($_SESSION);
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
					$tmp.= '<input name = "'.$pitanje_id.'[]" class = "checkbox single-checkbox" type="checkbox" value = "'.$i.'" id = "odgovori'.$i.$pitanje_id.'">';
					$tmp.= '<label for = "odgovori'.$i.$pitanje_id.'">'.ucfirst($odgovori[$i]).'</label>
								<br>';
					}
				$tmp.= '</div><p class = "text-muted"><small>Dva su odgovora točna</small></p>';
				break;
				
			case "2":
				// Radio
				$tmp.= '<div>';
				for($i=0; $i<count($odgovori);$i++){
						$tmp.= '<input name = "'.$pitanje_id.'[]" class = "radio" type="radio" value = "'.$i.'" id = "odgovori'.$i.$pitanje_id.'">';
						$tmp.= '<label for = "odgovori'.$i.$pitanje_id.'">'.ucfirst($odgovori[$i]).'</label>
						<br>';
					}
				$tmp.= '</div><p class = "text-muted"><small>Jedan je odgovor točan</small></p>';
				break;

			default:
				// Text
					$tmp.= '<div><input name = "'.$pitanje_id.'[]" class = "col-sm-7 form-control" type="text" placeholder = "Upišite točan odgovor!" id = "odgovori'.$i.$pitanje_id.'" value = "">';
					$tmp.= '<label for="odgovori'.$i.$pitanje_id.'" class = "control-label">'.ucfirst($odgovori[0]).'</label></div>';
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
							
