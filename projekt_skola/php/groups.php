<?php
session_start();
require_once "includes/functions.php";

$title = "Popis grupa";

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

$sql = "SELECT grupa.id, grupa.naziv, grupa.datum_pocetka, grupa.datum_zavrsetka, grupa.max_polaznika, users.ime, users.prezime, tecaj.smjer  
FROM grupa
INNER JOIN users ON users.id = grupa.id_predavac_fk
INNER JOIN tecaj ON tecaj.id = grupa.id_tecaj_fk ;";

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
				<th>Datum početka</th>
				<th>Datum završetka</th>
                <th>Predavač</th>
				<th>Maksimalan broj polaznika</th>
                <th>Tečaj</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>';

	while($group = mysqli_fetch_assoc($result)){
		echo "
			<tr>
				<td>".$group['id']."</td>
				<td>".$group['naziv']."</td>
				<td>".$group['datum_pocetka']."</td>
				<td>".$group['datum_zavrsetka']."</td>
				<td>".$group['ime']." ".$group['prezime']."</td>
				<td>".$group['max_polaznika']."</td>
				<td>".$group['smjer']."</td>
				
				<td>
					<a href='user.php?id=".$group["id"]."'><button class = 'btn btn-ghost submit' value = 'uredi' name='uredi' id='uredi''>Uredi</button></a>
				</td>
				<td>
					<a href='users.php?obrisi=true&id=".$group['id']."' onclick='return confirm(\"Jeste li sigurni da zelite obrisati grupu?\")'>
                        <button class = 'btn btn-ghost submit' value = 'obrisi' name='obrisi' id='obrisi'>Obriši</button>
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
						
						
						
						
					















