<?php
session_start();
require_once "includes/functions.php";

login_check();

$title = "Popis korisnika";

$con = spajanje();
if($_SESSION['role'] !== "1"){
	die("Nemate ovlasti za pristupanje ovoj stranici! Za povratak na početnu kliknite <a href='index.php'><b>ovdje</b></a>");
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
				<th>ID</th>
				<th>Ime</th>
				<th>Prezime</th>
				<th>OIB</th>
				<th>E-mail</th>
                <th>Broj telefona</th>
                <th>Mjesto prebivališta</th>
                <th>Adresa</th>
				<th>Status</th>
				<th style = "display : none"></th>
				<th style = "display : none"></th>
			</tr>
		</thead>
		<tbody>';

	while($user = mysqli_fetch_assoc($result)){
		echo "
			<tr>
				<td>".$user['id']."</td>
				<td>".$user['ime']."</td>
				<td>".$user['prezime']."</td>
				<td>".$user['oib']."</td>
				<td>".$user['email']."</td>
				<td>".$user['telefon']."</td>
				<td>".$user['naziv']."</td>
				<td>".$user['adresa']."</td>
				<td>".$user['status']."</td>
				
				<td>
					<a href='user.php?id=".$user["id"]."'><button class = 'btn btn-primary' value = 'uredi' name='uredi' id='uredi''>Uredi</button></a>
				</td>
				<td>
					<a href='users.php?obrisi=true&id=".$user['id']."' onclick='return confirm(\"Jeste li sigurni da zelite obrisati korisnika?\")'>
                        <button class = 'btn btn-primary' value = 'obrisi' name='obrisi' id='obrisi'>Obriši</button>
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
						
						
						
						
					















