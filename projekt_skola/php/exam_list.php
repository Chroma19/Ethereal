<?php

session_start();
require_once "includes/functions.php";
$title = "Popis ispita";
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
		

		if($_SESSION['role'] == "3"){

			$username = $_SESSION['username'];
			$sql = "SELECT id, ime, prezime FROM users WHERE username = '$username' AND id_status_fk = '3';";
			$res = mysqli_query($con, $sql);
			$res_asoc = mysqli_fetch_assoc($res);
			$id = $res_asoc['id'];
			

			$sql = "SELECT 
						ispit.id,
						ispit.datum_ispita,
						ispit.autor,
						lessons.lesson_name,
						tecaj.smjer
					FROM
						ispit
					INNER JOIN lessons ON ispit.id_lesson_fk = lessons.id
					INNER JOIN tecaj ON ispit.id_tecaj_fk = tecaj.id
					INNER JOIN upisi ON upisi.id_smjer_fk = ispit.id_tecaj_fK
					WHERE
						upisi.id_users_fk = '$id' AND ispit.datum_ispita > NOW();
			";

			$res = mysqli_query($con, $sql);
			
			require_once "includes/header.php";

			if(mysqli_num_rows($res)>0){
				echo '<table id="table" class="table table-hover">
					<thead>
						<tr>
							<th>Smjer</th>
							<th>Lekcija</th>
							<th>Vrijeme pisanja</th>
							<th>Profesor</th>
						</tr>
					</thead>
				<tbody>'
				;
				
				while($res_ispiti = mysqli_fetch_assoc($res)){
					echo "
						<tr class = 'clickable-row-exam' id=".$res_ispiti['id'].">
							<td>".$res_ispiti['smjer']."</td>
							<td>".$res_ispiti['lesson_name']."</td>
							<td>".$res_ispiti['datum_ispita']."</td>
							<td>".$res_ispiti['autor']."</td>
						</tr>";
				}
				echo "</tbody></table>";
			}

		}
		else{

			if(isset($_POST['obrisi']) and isset($_GET['id']) ){
				drop("ispit");
				$_POST=array();
				header("Location:exam_list.php");
				exit();	
			}

		$sql = "SELECT ispit.id, ispit.datum_ispita, ispit.autor, tecaj.smjer, lessons.lesson_name FROM tecaj
		INNER JOIN ispit ON ispit.id_tecaj_fk = tecaj.id 
		INNER JOIN lessons ON lessons.id = ispit.id_lesson_fk WHERE ispit.datum_ispita>NOW();";

		$res = mysqli_query($con, $sql);

		require_once "includes/header.php";


		if(mysqli_num_rows($res)>0){
			echo '<table id="table" class="table table-hover">
				<thead>
					<tr>
					<th>Smjer</th>
					<th>Lekcija</th>
					<th>Datum</th>
					<th>Profesor</th>
					</tr>
				</thead>
			<tbody>'
			;
			
			while($res_ispiti = mysqli_fetch_assoc($res)){
				echo "
					<tr class = 'clickable-row-exam' id=".$res_ispiti['id'].">
						<td>".$res_ispiti['smjer']."</td>
						<td>".$res_ispiti['lesson_name']."</td>
						<td>".$res_ispiti['datum_ispita']."</td>
						<td>".$res_ispiti['autor']."</td>
						</tr>";
			}
			echo "</tbody></table>";
		}
		else {
			echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
		}
	}
}   
require_once "includes/footer.php";
?>