<?php

session_start();
require_once "includes/functions.php";
$title = "Popis ispita";
$con = spajanje();

if($_SESSION['login'] !== true){
    header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}

else{
	// If logged in as a student
	if($_SESSION['role'] == "3"){
		$username = $_SESSION['username'];
		$sql = "SELECT id, ime, prezime FROM users WHERE username = '$username' AND id_status_fk = '3';";
		$res = mysqli_query($con, $sql);
		$res = mysqli_fetch_assoc($res);
		$id = $res['id'];
		$userid = $_SESSION['userid'];

		$sql = "SELECT
					ispit.id,
					ispit.autor,
					ispit.naziv,
					lessons.naziv,
					tecaj.naziv
				FROM
					ispit
				INNER JOIN upisi ON upisi.id_smjer_fk = ispit.id_tecaj_fK
				INNER JOIN lessons ON lessons.id = ispit.id_lesson_fk
				INNER JOIN tecaj ON tecaj.id = ispit.id_tecaj_fk
				WHERE
					upisi.id_users_fk = $userid;
				";

		$res = mysqli_query($con, $sql);
			
		require_once "includes/header.php";

		if(mysqli_num_rows($res) > 0){
			echo '<table id="table" class="table table-hover">
				<thead>
					<tr>
						<th>Smjer</th>
						<th>Lekcija</th>
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
						<td>".$res_ispiti['autor']."</td>
					</tr>";
			}
			echo "</tbody></table>";
		}

	}
	else{
		if(isset($_GET['obrisi']) and isset($_GET['id']) ){
			drop("ispit");
			$_POST=array();
			header("Location:exam_list.php");
			exit();	
		}

		$sql = "SELECT
		ispit.id,
		ispit.autor,
		ispit.naziv,
		lessons.lesson_name,
		tecaj.smjer
	FROM
		ispit
	INNER JOIN upisi ON upisi.id_smjer_fk = ispit.id_tecaj_fK
	INNER JOIN lessons ON lessons.id = ispit.id_lesson_fk
	INNER JOIN tecaj ON tecaj.id = ispit.id_tecaj_fk";

	$res = mysqli_query($con, $sql);

	require_once "includes/header.php";


		if(mysqli_num_rows($res) > 0){
			echo '<table id="table" class="table table-hover">
				<thead>
					<tr>
					<th>Naziv ispita</th>
					<th>Smjer</th>
					<th>Lekcija</th>
					<th>Autor ispita</th>
					<th></th>
					</tr>
				</thead>
			<tbody>'
			;
			
			while($res_ispiti = mysqli_fetch_assoc($res)){
				echo "
					<tr id=".$res_ispiti['id']." class = 'clickable-row-exam'>
						<td>".$res_ispiti['naziv']."</td>
						<td>".$res_ispiti['smjer']."</td>
						<td>".$res_ispiti['lesson_name']."</td>
						<td>".$res_ispiti['autor']."</td>
						<td><a href='exam_list.php?obrisi=true&id=".$res_ispiti['id']."'>
								<i class='fa fa-trash fa-2x' aria-hidden='true'></i>
							</a>
						</td>
						";
			}

			echo "</tr></tbody></table>";
		}
		else {
			echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
		}
	}
}   
require_once "includes/footer.php";
?>