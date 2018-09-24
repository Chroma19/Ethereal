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
		
	if(!isset($_POST['prijava_rok'])){

	}

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
						ispit.naziv
					FROM
						ispit
					INNER JOIN upisi ON upisi.id_smjer_fk = ispit.id_tecaj_fK
					WHERE
						upisi.id_users_fk = 6 AND ispit.datum_ispita > NOW();
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

		$sql = "SELECT ispit.id,ispit.naziv, ispit.datum_ispita, ispit.autor FROM ispit WHERE ispit.datum_ispita>NOW();";

		$res = mysqli_query($con, $sql);

		require_once "includes/header.php";


		if(mysqli_num_rows($res)>0){
			echo '<table id="table" class="table table-hover">
				<thead>
					<tr>
					<th>Naziv ispita</th>
					<th>Datum</th>
					<th>Profesor</th>
					<th></th>
					<th></th>
					</tr>
				</thead>
			<tbody>'
			;
			
			while($res_ispiti = mysqli_fetch_assoc($res)){
				echo "
					<tr id=".$res_ispiti['id']." class = 'clickable-row-exam'>
						<td>".$res_ispiti['naziv']."</td>
						<td>".$res_ispiti['datum_ispita']."</td>
						<td>".$res_ispiti['autor']."</td>
						<td><input onclick = 'return ispitPrijava(this.id);' id=".$res_ispiti['id']." class = 'btn btn-ghost submit' type = 'button' value = 'Prijavi rok' name = 'prijava_rok'></td>
						<td><input type='submit' class = 'btn btn-ghost submit' value = 'Piši ispit'></td>
						";
			}

			// onclick = 'pass_check(this.id);' dodaj nekako krv ti jebem
			echo "</tr></tbody></table>";
		}
		else {
			echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
		}
	}
}   
require_once "includes/footer.php";
?>