<?php

session_start();

require_once "includes/functions.php";

$title = "Popis korisnika";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check if current user has admin privileges
$isAdmin = checkStatus();

// If not redirect to homepage
if($isAdmin !== 1){

	header("refresh:2;url=index.php");

	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");

}
	
// If yes print all users from the DB with minimal information
else{
		
	$sql = "SELECT users.id, users.ime, users.prezime, roles.status  

	FROM users

	INNER JOIN roles ON roles.id = users.id_status_fk ;";

	$result = mysqli_query($con, $sql);


	require_once "includes/header.php";

	//if query returns any results create a table with users' data 
	if (mysqli_num_rows($result) > 0){
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

		// Loop through array of arrays creating table rows filled with user data
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
						
						
						
						
					















