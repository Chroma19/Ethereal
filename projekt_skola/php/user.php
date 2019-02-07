<?php
error_reporting(0);

session_start();

require_once "includes/functions.php";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check if logged in user is an admin
$isAdmin = checkStatus();

// If not redirect to homepage
if($isAdmin !== 1){

	header("refresh:2;url=index.php");

	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
	
}

// If yes allow data manipulation
else{
	// If clicked on 'obrisi' button delete the selected user from the DB
	if(isset($_POST['obrisi']) and isset($_GET['id']) ){

		drop("users");

		// Empty the $_POST array to prevent form resending
		$_POST=array();

		header("Location:users.php");

		// Terminate script 
		exit();	
	}

	// If clicked on 'spremi' button update the DB table with renewed data
	if(!empty($_POST['spremi'])){
		
		// Get data from the form via POST method
		$ime = $_POST['ime'];
		$prezime = $_POST['prezime'];
		$adresa = $_POST['adresa'];
		$oib = $_POST['oib'];
		$email = $_POST['email'];
		$telefon = $_POST['telefon'];
		$adresa = $_POST['adresa'];
		$status = $_POST['status'];
		

		// Create an SQL update query for selected user
		// NOTE: curly braces *{}* are used as an escape symbol due to possible complications with 'id' being a number format
		$sql = "UPDATE users
				SET
					ime = '$ime',
					prezime = '$prezime',
					adresa = '$adresa',
					oib = '$oib',
					email = '$email',
					telefon = '$telefon',
					adresa = '$adresa',
					id_status_fk = '$status' 
				WHERE
					id = {$_GET['id']}
				";
		
		$rez = mysqli_query($con, $sql);
		
		// If mysqli_query returns true (if user update goes through)
		if($rez){
			echo    
				'<div class="alert" style="background:#0090bc; color:white;"> 
					<a href="#" class="close" data-dismiss="alert" aria-label="close">
						&times;
					</a>
					<strong>Korisnik uspješno ažuriran!</strong>
				</div>';
		}

		// If user update does not go through throw error 
		else{
			echo mysqli_error($con);
		}
		
}

// If no user has been selected via GET id parameter
if(!isset($_GET['id'])){
	die("Nije predan id parametar!");
}

// Set title of page to user's name
$id=$_GET['id'];

$get_name = "SELECT users.ime, users.prezime FROM users WHERE users.id = $id;";

$res = mysqli_query($con, $get_name);

$name = mysqli_fetch_assoc($res);

$name = implode(" ", $name);

$title = $name;

// Select all data from DB about selected user
$sql = "SELECT * 
		FROM users 
		WHERE id = $id;";


$result = mysqli_query($con, $sql);

	// If DB returns a unique user with selected id create an associative array for that user 
	if (mysqli_num_rows($result) == 1){
		$user = mysqli_fetch_assoc($result);
	}

	// If there is no such user create an empty variable for safety measures
	else {

		$user = null;

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
<form class="form-horizontal" action ="" method = "post">
	<div class="col-sm-6">

	<h4>Podaci o korisniku</h4>

		<div class="form-group">
			<label for="id_polaznik" class="col-sm-2 control-label">ID</label>
			<div class="col-sm-10">
			<input type="text" class="form-control" placeholder="id_polaznik" value="<?php if(isset($user['id'])) echo  $user['id'];?>" disabled="disabled">
			<input type="text" id="id_polaznik" name="id_polaznik" placeholder="id_polaznik" value="<?php if(isset($user['id'])) echo $user['id'] ?>" hidden="hidden">
			</div>
		</div>
	
	
		<div class="form-group">
			<label for ="ime" class="col-sm-2 control-label">Ime</label>
			<div class="col-sm-10">
				<input type="text" id="ime" name="ime" class ="form-control" value="<?=$user['ime'];?>"/>
			</div>
		</div>
	
		<div class="form-group">
			<label for ="prezime" class="col-sm-2 control-label">Prezime</label>
			<div class="col-sm-10">
				<input type="text" id="prezime" name="prezime" class ="form-control" value="<?=$user['prezime'];?>"/>
			</div>
		</div>
	
		<div class="form-group">
			<label for ="adresa" class="col-sm-2 control-label">Adresa</label>
			<div class="col-sm-10">
				<input type="text" id="adresa" name="adresa" class ="form-control" value="<?=$user['adresa'];?>"/>
			</div>
		</div>
	
		<div class="form-group">
			<label for ="oib" class="col-sm-2 control-label">OIB</label>
			<div class="col-sm-10">
				<input type="text" id="oib" name="oib" class ="form-control" value="<?=$user['oib'];?>"/>
			</div>
		</div>
	
		<div class="form-group">
			<label for ="email" class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<input type="email" id="email" name="email" class ="form-control" value="<?=$user['email'];?>"/>
			</div>
		</div>
	
		<div class="form-group">
			<label for ="telefon" class="col-sm-2 control-label">Telefon</label>
			<div class="col-sm-10">
				<input type="text" id="telefon" name="telefon" class ="form-control" value="<?=$user['telefon'];?>"/>
			</div>
		</div>

		<div class="form-group">
			<label for ="status" class="col-sm-2 control-label">Status</label>
			<div class="col-sm-10">
				<select id="status" name="status" class ="form-control">
					<option selected disabled value="" >Odaberite status</option>

						<?php
						
						$sql = "SELECT * FROM roles;";

						$res = mysqli_query($con, $sql);

						if(mysqli_num_rows($res)>0){
							while($role = mysqli_fetch_assoc($res)){
								// Prevent errors popping up as a select menu item
								error_reporting(0);

								echo '<option value="'.$role['id'].'"';
								
								// If user's status from DB matches current session user echo it as selected
								if($role['id'] == $user['id_status_fk'])
									echo "selected";
							
								echo '>';
								echo $role['status'];
								echo '</option>';
							}
						}
						?>

					</select>
				</div>
			</div>
	</div>	


	<!-- JavaScript function for toggling results -->
	<div class="col-sm-6" id = "load_div">
		<label for ="results" class="col-sm-12 control-label">
			<h4>
				<span onclick = "toggleResults();" id = "loadMore">Rezultati ispita</span>
			</h4>
		</label>

		
            <div class="col-sm-12 results">

			<?php
			/*
			  Fetch all available test results for selected user
			  Note: if there are no results currently in the DB print out
			  "Nema dostupnih rezultata!" 
			*/
			$id = $_GET['id'];

            $sql = "SELECT results.id, results.id_ispit_fk, results.result, lessons.lesson_name, tecaj.smjer FROM results
                    INNER JOIN ispit ON results.id_ispit_fk = ispit.id
                    INNER JOIN lessons ON ispit.id_lesson_fk = lessons.id
                    INNER JOIN tecaj ON ispit.id_tecaj_fk = tecaj.id
                    WHERE id_osobe_fk = $id";

			$result = mysqli_query($con,$sql);
			
			// If there is at least one test result in the DB print it out in the div
			// and enable toggling it via JS function
            if(mysqli_num_rows($result) > 0){
                while($ispit = mysqli_fetch_assoc($result)){
                        echo "<pre>".$ispit['smjer']." ".$ispit['lesson_name']." => ".$ispit['result'].'</pre>';
				}
			}
			
			// If no results are available in the DB:
            else{
                echo "<div>Nema dostupnih rezultata!</div>";
			}
		?>
			
		</div>
	</div>
	<div class="col-sm-12">
		<div class="col-sm-offset-2 col-sm-3">
			<input type ="submit" id="spremi" name = "spremi" class ="form-control btn btn-ghost submit" value="Spremi" />
		</div>
	

	
		<div class="col-sm-offset-3 col-sm-2">
			<button type = "submit" id = "obrisi" name = "obrisi" class ="form-control btn btn-ghost submit"
			onclick = 'return confirm("Jeste li sigurni da želite obrisati korisnika?")' value = "obrisi">Obriši</button>
		</div>
	</div>
</form>



<?php
//--------------------------------
require "includes/footer.php";
							
?>