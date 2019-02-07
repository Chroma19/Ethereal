<?php

session_start();

require_once "includes/functions.php";

// Connect to DB
$con = spajanje();

// Check for cookies
cookieCheck();

// Check user's status
$status = checkStatus();

/**** 
 * 
 * If logged in as admin -> print out info about group, e.g. professor, course etc.
 * 
 * If logged in as professor -> print out name of group, course and students which belong to said group
 * 
****/

// If not logged in as either redirect to homepage
if($status !== 2 && $status !== 1){

	header("refresh:2;url=index.php");

	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");

}

// If status is 1 or 2 allow data manipulation 
else{
	// If button 'spremi' is clicked prepare and send off an SQL update query
	if(!empty($_POST['spremi'])){
		
		$naziv = $_POST['naziv'];
		$id_predavac_fk  = $_POST['id_predavac_fk'];
		$id_tecaj_fk = $_POST['id_tecaj_fk'];
		
		//Curly braces used as escape symbols due to complications with id being a number char
		$sql = "UPDATE grupa
				SET
				naziv = '$naziv',
				id_predavac_fk = '$id_predavac_fk',
				id_tecaj_fk = '$id_tecaj_fk'
				WHERE 
					id = {$_GET['id']}
				";
		
		$rez = mysqli_query($con, $sql);
		
		// If query returns true echo success message
		if($rez){
			echo    
				'<div class="alert" style="background:#0090bc; color:white;"> 
					<a href="#" class="close" data-dismiss="alert" aria-label="close">
						&times;
					</a>
					<strong>Grupa uspješno ažurirana!</strong>
				</div>';	
		}

		// If query returns false throw error
		else{
			echo mysqli_error($con);
		}
		
	}


	// If no group was selected via GET id parameter throw error
	if(!isset($_GET['id'])){
		die("Nije predan id parametar!");
	}

	// Create <title> for page
	$id = $_GET['id'];

	$get_name = "SELECT naziv FROM grupa WHERE grupa.id = $id;";

	$res = mysqli_query($con, $get_name);

	$name = mysqli_fetch_assoc($res);

	$name = implode(" ", $name);

	$title = $name;



	$sql = "SELECT * 
			FROM grupa 
			WHERE id = $id;";


	$result = mysqli_query($con, $sql);


	// If query returns a unique group create an associative array for it
	if (mysqli_num_rows($result) == 1){
		$group = mysqli_fetch_assoc($result);
	}

	// Else create an empty variable for security reasons
	else {
		$group = null;
		die('<div class="alert" style="background:yellow;"> 
				<a href="index.php" class="close" data-dismiss="alert" aria-label="close">
					&times;
				</a>
				<strong>Nije odabrana niti jedna grupa!</strong>
			</div>');
	}

}


require_once "includes/header.php";
?>



<form class="form-horizontal" action ="" method = "post">
	
	<div class="form-group">
		<label for="id_group" class="col-sm-2 control-label">ID</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" placeholder="id_group" value="<?php if(isset($group['id'])) echo  $group['id'];?>" disabled="disabled">
		  <input type="text" id="id_group" name="id_group" placeholder="id_group" value="<?php if(isset($group['id'])) echo $group['id'] ?>" hidden="hidden">
		</div>
	</div>
	
	
	<div class="form-group">
		<label for ="naziv" class="col-sm-2 control-label">Naziv</label>
		<div class="col-sm-5">
			<input type="text" id="naziv" name="naziv" class ="form-control" value="<?=$group['naziv'];?>"/>
		</div>
	</div>
    
    <div class="form-group">
		<label for ="id_predavac_fk" class="col-sm-2 control-label">Predavac</label>
		<div class="col-sm-5">
			<select id="id_predavac_fk" name="id_predavac_fk" class ="form-control" required>
				<option selected disabled value="" >Odaberite predavača</option>
			<?php 
			
				//Select all professors from the DB
				$sql = "SELECT * FROM users WHERE id_status_fk = '2';";

				$res_tutor = mysqli_query($con, $sql);
				
				// If query returns more than one professor echo them all as <select> menu items
				if(mysqli_num_rows($res_tutor) > 0){
					while($tutor = mysqli_fetch_assoc($res_tutor)){
						// Prevent errors from popping up as menu items
						error_reporting(0);

						echo '<option value="'.$tutor['id'].'"';
						
						// If id of professor equates to group teacher echo "selected" attribute
						if($tutor['id'] == $group['id_predavac_fk'])
							echo " selected";
					
						echo '>';
						echo $tutor['ime']." ".$tutor['prezime'];
						echo '</option>'; 
					}
				}
				
			?>
			</select>
		</div>
	</div>
        
    <div class="form-group">
		<label for ="id_tecaj_fk" class="col-sm-2 control-label">Tečaj</label>
		<div class="col-sm-5">
			<select id="id_tecaj_fk" name="id_tecaj_fk" class ="form-control" required>
				<option selected disabled value="" >Odaberite tečaj</option>
			<?php 
			
				$sql = "SELECT * FROM tecaj;";

				$res_tecaj = mysqli_query($con, $sql);
				
				// If query returns more than one course echo them all as <select> menu items
				if(mysqli_num_rows($res_tecaj)>0){
					while($tecaj = mysqli_fetch_assoc($res_tecaj)){
						// Prevent errors from popping up as menu items
						error_reporting(0);

						echo '<option value="'.$tecaj['id'].'"';
						
						// If id of course equates to group course echo "selected" attribute
						if($tecaj['id'] == $group['id_tecaj_fk'])
							echo "selected";
					
						echo '>';
						echo $tecaj['smjer'];
						echo '</option>';
					}
				}
				
			?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			<input type ="submit" id="spremi" name = "spremi" class ="submit form-control btn btn-primary" value="Spremi" />
		</div>
	</div>
	
</form>



<?php

require_once "includes/footer.php";
							
?>