<?php
session_start();
require_once "includes/functions.php";

$title = "Popis korisnika";

$con = spajanje();

$isAdmin = checkStatus();

if($isAdmin !== 1){
	header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}
	
else{
		
$sql = "SELECT users.id, users.ime, users.prezime, roles.status  
FROM users
INNER JOIN roles ON roles.id = users.id_status_fk ;";

$result = mysqli_query($con, $sql);


require_once "includes/header.php";


if (mysqli_num_rows($result)>0){
	echo '
	<table id = "table" class="table table-hover">
		<thead>
			<tr>
				<th>Ime</th>
				<th>Prezime</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>';

	while($user = mysqli_fetch_assoc($result)){
		echo "
			<tr class = 'clickable-row-users' id=".$user['id'].">
				<td>".$user['ime']."</td>
				<td>".$user['prezime']."</td>
				<td>".$user['status']."</td>
			</tr>";
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
						
						
						
						
					















