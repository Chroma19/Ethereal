<?php
session_start();
require_once "includes/functions.php";

$title = "Popis tečaja";

$con = spajanje();
if($_SESSION['role'] !== "1"){
	die('<div class="alert" style="background:yellow;"> 
    <a href="index.php" class="close" data-dismiss="alert" aria-label="close">
    &times;
    </a>
    <strong>Nemate ovlasti za pristup ovoj stranici!</strong>
    
    </div>');}
else{

$sql = "SELECT * FROM tecaj;";

$result = mysqli_query($con, $sql);


	

if(isset($_GET['obrisi']) and isset($_GET['id']) ){
	drop("tecaj");
	header("Location:courses.php");
	
}
require_once "includes/header.php";


if (mysqli_num_rows($result)>0){
	echo '
	<table id = "table" class="table table-hover">
		<thead>
			<tr>
				<th>smjer</th>
				<th>Broj sati</th>
				<th>Cijena</th>
				<th></th>
			</tr>
		</thead>
		<tbody>';

	while($course = mysqli_fetch_assoc($result)){
		echo "
			<tr class = 'clickable-row-course' id = '".$course["id"]."'>
				<td>".$course['smjer']."</td>
				<td>".$course['broj_sati']."</td>
				<td>".$course['cijena']." kn</td>
				
					<a href='courses.php?obrisi=true&id=".$course['id']."' onclick='return confirm(\"Jeste li sigurni da želite obrisati tečaj?\")'>
                        <button class = 'btn btn-ghost submit' value = 'obrisi' name='obrisi' id='obrisi'>Obriši</button>
                    </a>
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
						
						
						
						
					















