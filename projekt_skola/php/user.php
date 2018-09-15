<?php
session_start();
require_once "includes/functions.php";
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

if(isset($_POST['obrisi']) and isset($_GET['id']) ){
	drop("users");
	$_POST=array();
	header("Location:users.php");
	exit();	
}

if(!empty($_POST['spremi'])){
	
	$ime= $_POST['ime'];
	$prezime= $_POST['prezime'];
	$adresa= $_POST['adresa'];
	$oib= $_POST['oib'];
	$email= $_POST['email'];
	$telefon= $_POST['telefon'];
	$adresa = $_POST['adresa'];
	$status = $_POST['status'];
	if(!empty($_POST['mjesto']))
		$mjesto = $_POST['mjesto'];
	else{
		$mjesto = "NULL";
	}
	

	$sql = "UPDATE users
			SET
				ime = '$ime',
				prezime = '$prezime',
				adresa = '$adresa',
				oib = '$oib',
				email = '$email',
				telefon = '$telefon',
				adresa = '$adresa',
				id_mjesto_fk = '$mjesto',
				id_status_fk = '$status' 
			WHERE
				id = {$_GET['id']}
			";
	
	$rez = mysqli_query($con, $sql);
	
	if($rez){
		echo    '<div class="alert" style="background:#0090bc; color:white;"> 
		<a href="#" class="close" data-dismiss="alert" aria-label="close">
		&times;
		</a>
		<strong>Korisnik uspješno ažuriran!</strong>
		</div>';
	}
	else{
		echo mysqli_error($con);
	}
	
}

if(!isset($_GET['id'])){
	die("Nije predan id parametar!");
}
$id=$_GET['id'];
$get_name = "SELECT users.ime, users.prezime FROM users WHERE users.id = $id;";
$res = mysqli_query($con, $get_name);
$name = mysqli_fetch_assoc($res);
$name = implode(" ", $name);
$title = $name;

$sql = "SELECT * 
		FROM users 
		WHERE id = $id;";


$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result)==1){
	$user = mysqli_fetch_assoc($result);
}
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
	
	<div class="form-group">
		<label for="id_polaznik" class="col-sm-2 control-label">ID</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" placeholder="id_polaznik" value="<?php if(isset($user['id'])) echo  $user['id'];?>" disabled="disabled">
		  <input type="text" id="id_polaznik" name="id_polaznik" placeholder="id_polaznik" value="<?php if(isset($user['id'])) echo $user['id'] ?>" hidden="hidden">
		</div>
	</div>
	
	
	<div class="form-group">
		<label for ="ime" class="col-sm-2 control-label">Ime</label>
		<div class="col-sm-5">
			<input type="text" id="ime" name="ime" class ="form-control" value="<?=$user['ime'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="prezime" class="col-sm-2 control-label">Prezime</label>
		<div class="col-sm-5">
			<input type="text" id="prezime" name="prezime" class ="form-control" value="<?=$user['prezime'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="adresa" class="col-sm-2 control-label">Adresa</label>
		<div class="col-sm-5">
			<input type="text" id="adresa" name="adresa" class ="form-control" value="<?=$user['adresa'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="oib" class="col-sm-2 control-label">OIB</label>
		<div class="col-sm-5">
			<input type="text" id="oib" name="oib" class ="form-control" value="<?=$user['oib'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="email" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-5">
			<input type="email" id="email" name="email" class ="form-control" value="<?=$user['email'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="telefon" class="col-sm-2 control-label">Telefon</label>
		<div class="col-sm-5">
			<input type="text" id="telefon" name="telefon" class ="form-control" value="<?=$user['telefon'];?>"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for ="mjesto" class="col-sm-2 control-label">Mjesto</label>
		<div class="col-sm-5">
			<select id="mjesto" name="mjesto" class ="form-control">
				<option selected disabled value="" >Odaberite mjesto</option>
			<?php 
			
				$sql = "SELECT * FROM mjesto;";
				$res_mjesto = mysqli_query($con, $sql);
				
				if(mysqli_num_rows($res_mjesto)>0){
					while($mjesto = mysqli_fetch_assoc($res_mjesto)){
						error_reporting(0);

						echo '<option value="'.$mjesto['id'].'"';
						
						if($mjesto['id'] == $user['id_mjesto_fk'])
							echo "selected";
					
						echo '>';
						echo $mjesto['naziv'];
						echo '</option>';
					}
				}
				
			?>
			</select>
		</div>
	</div>
	

	<div class="form-group">
		<label for ="status" class="col-sm-2 control-label">Status</label>
		<div class="col-sm-5">
			<select id="status" name="status" class ="form-control">
				<option selected disabled value="" >Odaberite status</option>
	<?php
	
	$sql = "SELECT * FROM ROLES;";

	$res = mysqli_query($con, $sql);

	if(mysqli_num_rows($res)>0){
		while($role = mysqli_fetch_assoc($res)){
			error_reporting(0);

			echo '<option value="'.$role['id'].'"';
			
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
	

	<div class="form-group">
		<div class="col-sm-offset-1 col-sm-3">
			<input type ="submit" id="spremi" name = "spremi" class ="form-control btn btn-ghost submit" value="Spremi" />
		</div>
	

	
		<div class="col-sm-offset-1 col-sm-3">
			<button type ="submit" id="obrisi" name = "obrisi" class ="form-control btn btn-ghost submit"
			onclick='return confirm("Jeste li sigurni da želite obrisati korisnika?")' value="obrisi">Obriši</button>
		</div>
	</div>
</form>



<?php

//--------------------------------
require "includes/footer.php";
							
?>