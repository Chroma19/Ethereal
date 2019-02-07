<?php

session_start();

require_once "includes/functions.php";

$title = "Popis grupa";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check user's status
$status = checkStatus();

// If user is neither a professor or an admin redirect to homepage
if($status !== 1 && $status !== 2){

	header("refresh:2;url=index.php");

	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
	
}

/* 
   If user is an admin or a professor list out all groups 
   Note: an admin can see all available groups, a professor can only see
   the ones he teaches
*/
else{

	// Declaring currentUser variable for SQL queries
	$currentUser = $_SESSION['userid'];

	// If logged in as admin view all available groups:

	if($status == 1){
	$sql = "SELECT grupa.id, grupa.naziv, users.ime, users.prezime, tecaj.smjer  
			FROM grupa
			INNER JOIN users ON users.id = grupa.id_predavac_fk
			INNER JOIN tecaj ON tecaj.id = grupa.id_tecaj_fk 
			WHERE users.id_status_fk = 2;";
	}

	// If logged in as professor view only groups you teach:
	else{
		$sql = "SELECT grupa.id, grupa.naziv, users.ime, users.prezime, tecaj.smjer  
			FROM grupa
			INNER JOIN users ON users.id = grupa.id_predavac_fk
			INNER JOIN tecaj ON tecaj.id = grupa.id_tecaj_fk 
			WHERE users.id_status_fk = 2
			AND grupa.id_predavac_fk = $currentUser;";
	}

	$result = mysqli_query($con, $sql);

	// If button 'obrisi' is clicked and there is a GET id parameter delete the selected group 
	if(isset($_GET['obrisi']) and isset($_GET['id']) ){

		drop("grupa");

		header("Location:groups.php");
		
	}

	require_once "includes/header.php";

		// If the query returns more than one result create a table with group data
		if (mysqli_num_rows($result) > 0){
			echo '
			<table id = "table" class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Naziv</th>
						<th>Predavač</th>
						<th>Tečaj</th>
						<th></th>
					</tr>
				</thead>
				<tbody>';

		// Loop through array of array and fill the table rows with DB data
		while($group = mysqli_fetch_assoc($result)){
			echo "
				<tr class = 'clickable-row-group' id ='".$group['id']."'>
					<td>".$group['id']."</td>
					<td>".$group['naziv']."</td>
					<td>".$group['ime']." ".$group['prezime']."</td>
					<td>".$group['smjer']."</td>				
					<td>
						<a class = 'NOUNDERLINE' href='groups.php?obrisi=true&id=".$group['id']."' onclick='return confirm(\"Jeste li sigurni da zelite obrisati grupu?\")'>
							<i class='fa fa-trash fa-2x' aria-hidden='true'></i>
						</a>
					</td>
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
						
						
						
						
					















