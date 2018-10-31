<?php
session_start();

require_once "includes/functions.php";

$con = spajanje();

$status = checkStatus();

/**** 
 * 
 * If logged in as admin -> print out info about group, e.g. professor, course etc.
 * 
 * If logged in as professor -> print out name of group, course and students which belong to said group
 * 
****/


if($status !== 2 && $status !== 1){
	header("refresh:2;url=index.php");
	die("Nemate ovlasti za pristup ovoj stranici! Prebacujem na index.php...");
}

else{
	if(!empty($_POST['spremi'])){
		
		$naziv= $_POST['naziv'];
		$id_predavac_fk  = $_POST['id_predavac_fk'];
		$id_tecaj_fk = $_POST['id_tecaj_fk'];
		

		$sql = "UPDATE grupa
				SET
				naziv = '$naziv',
				id_predavac_fk = '$id_predavac_fk',
				id_tecaj_fk = '$id_tecaj_fk'
				WHERE 
					id = {$_GET['id']}
				";
		
		$rez = mysqli_query($con, $sql);
		
		if($rez){
		echo    '<div class="alert" style="background:#0090bc; color:white;"> 
				<a href="#" class="close" data-dismiss="alert" aria-label="close">
				&times;
				</a>
				<strong>Grupa uspješno ažurirana!</strong>
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
$get_name = "SELECT naziv FROM grupa WHERE grupa.id = $id;";
$res = mysqli_query($con, $get_name);
$name = mysqli_fetch_assoc($res);
$name = implode(" ", $name);
$title = $name;

$sql = "SELECT * 
		FROM grupa 
		WHERE id = $id;";


$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result)==1){
	$group = mysqli_fetch_assoc($result);
}
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
			
				$sql = "SELECT * FROM users WHERE id_status_fk = '2';";
				$res_tutor = mysqli_query($con, $sql);
				
				if(mysqli_num_rows($res_tutor)>0){
					while($tutor = mysqli_fetch_assoc($res_tutor)){
						error_reporting(0);

						echo '<option value="'.$tutor['id'].'"';
						
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
				
				if(mysqli_num_rows($res_tecaj)>0){
					while($tecaj = mysqli_fetch_assoc($res_tecaj)){
						error_reporting(0);

						echo '<option value="'.$tecaj['id'].'"';
						
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