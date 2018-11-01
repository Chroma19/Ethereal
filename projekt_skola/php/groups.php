<?php
session_start();
require_once "includes/functions.php";

$title = "Popis grupa";

$con = spajanje();

$status = checkStatus();

//Professor are only eligible to see those groups/classes which they teach
// Solution: something similar to group.php comment


if($status !== 1 && $status !== 2){
	header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}

else{

$sql = "SELECT grupa.id, grupa.naziv, users.ime, users.prezime, tecaj.smjer  
FROM grupa
INNER JOIN users ON users.id = grupa.id_predavac_fk
INNER JOIN tecaj ON tecaj.id = grupa.id_tecaj_fk 
WHERE users.id_status_fk = 2;";

$result = mysqli_query($con, $sql);


	

if(isset($_GET['obrisi']) and isset($_GET['id']) ){
	drop("grupa");
	header("Location:groups.php");
	
}

require_once "includes/header.php";


if (mysqli_num_rows($result)>0){
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
						
						
						
						
					















