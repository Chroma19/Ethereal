<?php
session_start();

require_once "includes/functions.php";

$title = "Popis tečaja";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check user's status
$isAdmin = checkStatus();

// If logged user is not an admin redirect to homepage
if($isAdmin !== 1){

	header("refresh:2;url=index.php");

	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
	
}

// If user is an admin print out all courses and allow data manipulation
else{

$sql = "SELECT * FROM tecaj;";

$result = mysqli_query($con, $sql);

// If button 'obrisi' is clicked and a GET id parameter is set 
// Drop a course with the selected id from the DB
if(isset($_GET['obrisi']) and isset($_GET['id']) ){

	drop("tecaj");

	header("Location:courses.php");
	
}


require_once "includes/header.php";

	// If the query returns more than one result create a table with group data
	if (mysqli_num_rows($result) > 0){
		echo '
		<table id = "table" class="table table-hover">
			<thead>
				<tr>
					<th>Smjer</th>
					<th></th>
				</tr>
			</thead>
			<tbody>';

	// Loop through array of array and fill the table rows with DB data
	while($course = mysqli_fetch_assoc($result)){
		echo "
			<tr class = 'clickable-row-course' id = '".$course["id"]."'>
				<td>".$course['smjer']."</td>
				<td>
					<a href='courses.php?obrisi=true&id=".$course['id']."' onclick='return confirm(\"Jeste li sigurni da želite obrisati tečaj?\")'>
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
						
						
						
						
					















