<?php

session_start();
require_once "includes/functions.php";
$title = "Popis ispita";
$con = spajanje();
if($_SESSION['role'] !== "1" and $_SESSION['role'] !=="2"){
    die('<div class="alert" style="background:yellow;"> 
        <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
        &times;
        </a>
        <strong>Nemate ovlasti za pristup ovoj stranici!</strong>
        </div><br>');
}
else{

$sql = "SELECT ispit.id, ispit.datum_ispita, tecaj.smjer, lessons.lesson_name FROM tecaj
 INNER JOIN ispit ON ispit.id_tecaj_fk = tecaj.id 
 INNER JOIN lessons ON lessons.id = ispit.id_lesson_fk WHERE ispit.datum_ispita>NOW();";

$res = mysqli_query($con, $sql);

require_once "includes/header.php";


if(mysqli_num_rows($res)>0){
	echo '<table id="table" class="table table-hover">
		<thead>
			<tr>
				<th>ID</th>
				<th>Smjer</th>
				<th>Lekcija</th>
                <th>Vrijeme pisanja</th>
                <th></th>
			</tr>
		</thead>
	<tbody>'
	;
	
    while($res_ispiti = mysqli_fetch_assoc($res)){
        echo "
			<tr>
				<td>".$res_ispiti['id']."</td>
				<td>".$res_ispiti['smjer']."</td>
				<td>".$res_ispiti['lesson_name']."</td>
				<td>".$res_ispiti['datum_ispita']."</td>
				<td>
					<a href='exam_write.php?id=".$res_ispiti["id"]."'><button class = 'btn btn-primary'>Otvori ispit</button></a>
				</td>
			</tr>";
	}
	echo "</tbody></table>";
}

else {
	echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
}
}     
require_once "includes/footer.php";
?>