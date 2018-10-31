<?php
session_start();

require_once "includes/functions.php";

$con = spajanje();

$status = checkStatus();

if($status !== 2 && $status !== 1){
	header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}

else{
	if(!empty($_POST['spremi'])){
		
		$smjer= $_POST['smjer'];
		

		$sql = "UPDATE tecaj
				SET
				smjer = '$smjer'
				WHERE
					id = {$_GET['id']}
				";
		
		$rez = mysqli_query($con, $sql);
		
		if($rez){
		echo    '<div class="alert" style="background:#0090bc; color:white;"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">
				&times;
				</a>
				<strong>Tečaj uspješno ažuriran!</strong>
				</div>';
				
		}

		else{
			echo mysqli_error($con);
		}
		
	}

	if(!isset($_GET['id'])){
		die("Nije predan id parametar!");
	}

	// Setting value of $id for SQL query
	$id = $_GET['id'];

	$name_query = "SELECT smjer FROM tecaj WHERE tecaj.id = $id;";
	$res = mysqli_query($con, $name_query);
	$name = mysqli_fetch_assoc($res);
	$name = implode(" ", $name);
	$title = $name;

	$sql = "SELECT * 
			FROM tecaj 
			WHERE id = $id;";


	$result = mysqli_query($con, $sql);

	if (mysqli_num_rows($result) == 1){
		$course = mysqli_fetch_assoc($result);
	}

	else {
		$course = null;
		die('<div class="alert" style="background:yellow;"> 
			<a href="index.php" class="close" data-dismiss="alert" aria-label="close">
			&times;
			</a>
			<strong>Nije odabran niti jedan tečaj!</strong>
			
			</div>');
	}
}
require_once "includes/header.php";
?>
<form class="form-horizontal" action ="" method = "post">
	
	<div class="form-group">
		<label for="id_tecaj" class="col-sm-2 control-label">ID</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" placeholder="id_tecaj" value="<?php if(isset($course['id'])) echo  $course['id'];?>" disabled="disabled">
		  <input type="text" id="id_tecaj" name="id_tecaj" placeholder="id_tecaj" value="<?php if(isset($course['id'])) echo $course['id'] ?>" hidden="hidden">
		</div>
	</div>
	
	
	<div class="form-group">
		<label for ="smjer" class="col-sm-2 control-label">Smjer:</label>
		<div class="col-sm-5">
			<input type="text" id="smjer" name="smjer" class ="form-control" value="<?=$course['smjer'];?>"/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-3">
			<input type ="submit" id="spremi" name = "spremi" class ="submit form-control btn btn-primary" value="Spremi" />
		</div>
	</div>
	
</form>



<?php

//--------------------------------
require "includes/footer.php";
							
?>