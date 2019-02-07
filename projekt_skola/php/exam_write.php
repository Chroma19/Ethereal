<?php

session_start();

require_once "includes/functions.php";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

$id=$_GET['id'];
global $id;

if($_SESSION['login'] !== true){

	header("refresh:2;url=index.php");
	
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");

}
else {

	$sql = "SELECT naziv from ispit";

	$res = mysqli_fetch_assoc(mysqli_query($con, $sql));

	$title = $res['naziv'];

}

// Fetching questions in an array and transforming to string for sql query
$sql_pitanja = 
"SELECT ispit.pitanja_string 
 FROM ispit
 WHERE ispit.id = {$_GET['id']}";

$pitanja_string = mysqli_query($con,$sql_pitanja);

$pitanja_array = mysqli_fetch_assoc($pitanja_string);

$pitanja_array = implode(",", $pitanja_array);

$pitanja_array = explode(",", $pitanja_array);

// used in SQL query (WHERE IN...)
$pitanja_string = implode(",", $pitanja_array);


// Create the questions array into separate variables with different keys and values
foreach ($pitanja_array as $k => $pitanje_id){
	global $pitanje_id;
}

	// If button 'predaj' is clicked and at least one question has been answered
	if(isset($_POST['predaj']) and !empty($_POST[$pitanje_id])){

		// Fetch question IDs and solutions from DB for exam grading
		$sql = "SELECT id, rjesenje
					FROM baza_pitanja
					WHERE id IN ($pitanja_string);";

			$pitanja = mysqli_query($con, $sql);

			// If at least one question has been returned from the DB 
			// Create an array for all fetched questions
			if(mysqli_num_rows($pitanja) > 0){

				$all_q = array();

				// Defining empty scoring variable
				global $bodovi;
				$bodovi = 0;

				// Looping through questions from the query
				while($pitanje = mysqli_fetch_assoc($pitanja)){

					/*
					 * Creating a 2D array containing all questions and their IDs
					 * Which will later be used for comparing solutions and grading
					 * The exam. Because of the while loop each question gets individually checked.
					 * tocno_rj is an array containing the question Solution, renamed for easier 
					 * reading.  
					 */

					$all_q[$pitanje['id']] = $pitanje;

					$tocno_rj = $all_q[$pitanje['id']];
					
					/*
					 * Starting a for loop which increases the question index number
				     * In order to "read" all the question and compare answers to
					 * correct solutions previously fetched from the DB. Pitanje_id
					 * gets pulled from the previous foreach loop declaring it as 
					 * a global variable.
					*/
					for($question_index = 0; $question_index<=$pitanje_id; $question_index++){
						global $question_index;
					}


					// Declaring a maximum score variable necessary for final percentage calculations
					// Presumably each question is worth one point for ease of use. Can be altered
					// Via code if necessary
					global $max_bodovi;
					$max_bodovi = count($pitanja_array);

					// Offered solution at the question index is looping for each _POST
					// Element containing a question answer
					$ponudeno_rj[$question_index] = implode("," , $_POST[$pitanje['id']]);


					// If the _POST answer matches the DB solution up the total points by 1
					if($ponudeno_rj[$question_index] == $tocno_rj['rjesenje']){
						$bodovi++;
					}

				}

					// Defining a total score for the exam
					global $total;
					$total = round($bodovi/$max_bodovi*100, 2) ."%";
				}


			// If there are no questions fetched for the exam throw error
			else{
				echo mysqli_error($con);
			}

	    // Defining userId for SQL insertion
		$user = $_SESSION['userid'];

		$send = "INSERT INTO results (id_osobe_fk, id_ispit_fk, result)
				 VALUES (".$user.", ".$id.", '$total');";
		
		$res = mysqli_query($con, $send);

		header("refresh:3;url=index.php");

		// Echo success message
		echo 
			'<div class="alert" style="background:#0090bc; color:white;"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">
					&times;
				</a>
				<strong>Ispit predan!</strong>
			</div>';
		
		// Terminate script
		exit();
	}	
	require_once "includes/header.php";

?>

<form class="form-horizontal" action ="" method = "post">
	
    <?php 
    // Catching questions in string format
	
	echo "<div class = 'form-group exam'><ol>";

		$sql = 'SELECT type FROM tip_pitanja';

		$type = mysqli_query($con, $sql);
		
		// Fetch question types and declare them as global for further HTML creation
		if(mysqli_num_rows($type) > 0){

			while($type_id = mysqli_fetch_assoc($type)){

				global $type_id;

			}
		}

	/*
	 *Finding question types for all questions contained in the exam.
	 *The following script creates inputs based on the question type
	 *descriptions, aka checkbox will create an <input type="checkbox">
	 *etc. Checkbox and Radio types have for loops which create as many
	 *inputs as there are answers. The correct answer is not visible in
	 *any of the HTML attributes or elements due to possible exploits and cheating.
	 */ 
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
					$tmp.= '<div><input name = "'.$pitanje_id.'[]" class = "col-sm-7 form-control" type="text" placeholder = "Upišite točan odgovor!" id = "odgovori'.$pitanje_id.'" value = "">';
					$tmp.= '<label for="odgovori'.$pitanje_id.'" class = "control-label">'.ucfirst($odgovori[0]).'</label></div>';
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


<!-- Limiting checkboxes to only 2 possible answers (Multiple choice - Multiple answers question type) -->
<script>
var limit = 2;
$('input.single-checkbox').on('change', function(evt) {
    if($(this).siblings(':checked').length >= limit) {
        this.checked = false;
    }
});
</script>
							
