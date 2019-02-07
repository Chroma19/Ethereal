<?php
error_reporting(0);

session_start();

require_once "includes/functions.php";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// If the user is not logged in at all - redirect to homepage
if($_SESSION['login'] !== true){
	header("refresh:2;url=index.php");
	die("Morate se prvo prijaviti!");
}

// If the logged in user (except for admins) is trying to view any profile other than his own - block access
$userId = $_SESSION['userid'];

if($_GET['id'] !== $userId && $_SESSION['role'] != 1){

	header("refresh:2;url=index.php");

	die("Nemate pristup traženoj stranici!");
	
}

// If no user is select via menus or $_GET ID parameter
else{

	if(!isset($_GET['id'])){
		die("Nije predan id parametar!");
	}

	// Getting user's name and surname for page title
	$id = $_GET['id'];

	global $id;

	$get_name = "SELECT users.ime, users.prezime FROM users WHERE users.id = $id;";

	$res = mysqli_query($con, $get_name);

	$name = mysqli_fetch_assoc($res);

	// Create a string from the returned DB array 
	$name = implode(" ", $name);

	// Set page title in header.php file 
	$title = $name;


	// Get all necessary data about the user from the DB
	$sql = "SELECT users.ime,users.prezime,users.oib,users.telefon,users.adresa,users.email
			FROM users
			WHERE users.id = $id;";


	$result = mysqli_query($con, $sql);

		// If the $_GET ID parameter matches an ID value in the DB
		if (mysqli_num_rows($result) == 1){
			$user = mysqli_fetch_assoc($result);
		}

		// If there is no user with the wanted ID in the DB
		else {
			// Create an empty variable instead of an associative DB array - safety purposes
			$user = null;
			header("refresh:2;url=index.php");
			die('<div class="alert" style="background:yellow;"> 
				<a href="index.php" class="close" data-dismiss="alert" aria-label="close">
					&times;
				</a>
				<strong>Nije odabran niti jedan korisnik!</strong>
				</div>');
		}
}

require_once "includes/header.php";
?>

<!-- Creating <div> elements and filling them with DB info -->

<form class="form-horizontal" action ="" method = "get">

	<div class="col-sm-6">

	<h4>Moji podaci</h4>

		<div class="form-group">
			<label for ="ime" class="col-sm-2 control-label">Ime</label>
			<div class="col-sm-10">
				<input type="text" readonly id="ime" name="ime" class ="form-control disabled" value="<?=$user['ime'];?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label for ="prezime" class="col-sm-2 control-label">Prezime</label>
			<div class="col-sm-10">
				<input type="text" readonly id="prezime" name="prezime" class ="form-control disabled" value="<?=$user['prezime'];?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label for ="adresa" class="col-sm-2 control-label">Adresa</label>
			<div class="col-sm-10">
				<input type="text" readonly id="adresa" name="adresa" class ="form-control disabled" value="<?=$user['adresa'];?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label for ="oib" class="col-sm-2 control-label">OIB</label>
			<div class="col-sm-10">
				<input type="text" readonly id="oib" name="oib" class ="form-control disabled" value="<?=$user['oib'];?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label for ="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="email" readonly id="email" name="email" class ="form-control disabled" value="<?=$user['email'];?>"/>
			</div>
		</div>
		
		<div class="form-group">
			<label for ="telefon" class="col-sm-2 control-label">Telefon</label>
			<div class="col-sm-10">
				<input type="text" readonly id="telefon" name="telefon" class ="form-control disabled" value="<?=$user['telefon'];?>"/>
			</div>
		</div>
		
		<div hidden = "hidden" class="form-group">
			<label for ="" class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<input type="text" readonly hidden = "hidden" id="" name="" class ="form-control disabled" value=""/>
				</div>
		</div>

		</div>
		
		<div class="col-sm-6" id = "load_div">
			<label for ="results" class="col-sm-12 control-label">
				<h4>
					<span onclick = "toggleResults();" id = "loadMore">Prikaži rezultate ispita</span>
				</h4>
			</label>

			
				<div class="col-sm-12 results">

				<?php

				// Fetch all available exam results for the selected user and join them into a readable string
				$id = $_GET['id'];
				$sql = "SELECT results.id, results.id_ispit_fk, results.result, lessons.lesson_name, tecaj.smjer FROM results
						INNER JOIN ispit ON results.id_ispit_fk = ispit.id
						INNER JOIN lessons ON ispit.id_lesson_fk = lessons.id
						INNER JOIN tecaj ON ispit.id_tecaj_fk = tecaj.id
						WHERE id_osobe_fk = $id";

				$result = mysqli_query($con,$sql);

				// If the user has any available results
				if(mysqli_num_rows($result)>0){

					// Print out all individual exam results in <pre> frames
					while($ispit = mysqli_fetch_assoc($result)){
							echo "<pre>".$ispit['smjer']." ".$ispit['lesson_name']." => ".$ispit['result'].'</pre>';
					}

				}
				
				// If there are no available results for the user
				else{
					echo "<div>Nema dostupnih rezultata!</div>";
				}

				?>
				
			</div>
		</div>

	</div>
</form>



<?php

//--------------------------------
require_once "includes/footer.php";
							
?>