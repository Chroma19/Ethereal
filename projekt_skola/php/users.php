<?php
session_start();
require_once "includes/functions.php";

$title = "Popis korisnika";

$con = spajanje();
if($_SESSION['role'] !== "1"){
	die('<div class="alert" style="background:yellow;"> 
	<a href="index.php" class="close" data-dismiss="alert" aria-label="close">
	&times;
	</a>
	<strong>Nemate ovlasti za pristup ovoj stranici!</strong>
	
	</div>');
}
else{

$sql = "SELECT users.id, users.ime, users.prezime, users.oib, users.email, users.telefon, users.adresa, mjesto.naziv, roles.status  
FROM mjesto
INNER JOIN users ON mjesto.id = users.id_mjesto_fk
INNER JOIN roles ON roles.id = users.id_status_fk ;";

$result = mysqli_query($con, $sql);


	

if(isset($_GET['obrisi']) and isset($_GET['id']) ){
	drop("users");
	header("Location:users.php");
	
}

require_once "includes/header.php";


if (mysqli_num_rows($result)>0){
	echo '
	<table id = "table" class="table table-hover">
		<thead>
			<tr>
				<th>Ime</th>
				<th>Prezime</th>
				<th>Status</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';

	while($user = mysqli_fetch_assoc($result)){
		echo "
		<a href='user.php?id=".$user["id"]."'><tr>
				<td>".$user['ime']."</td>
				<td>".$user['prezime']."</td>
				<td>".$user['status']."</td>
				<td>
					<a href='users.php?obrisi=true&id=".$user['id']."' onclick='return confirm(\"Jeste li sigurni da zelite obrisati korisnika?\")'>
                        <button class = 'btn btn-primary' value = 'obrisi' name='obrisi' id='obrisi'>Obriši</button>
                    </a>
				</td>
			</tr></a>";
	}
	echo "</tbody></table>";
}
else {
	echo "<p>U bazi nema rezultata za ovaj upit: $sql </p>";
}
}
//--------------------------------
require "includes/footer.php";
//--------------------------------
							
?>
						
						
						
						
					















