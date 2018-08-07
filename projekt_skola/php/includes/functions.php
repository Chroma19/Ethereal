<?php
	
$poruka = '';
$greska ="";
		function ispisi_polje($array){
			echo"<pre>";
			print_r($array);
			echo"</pre>";
		}
		
		function setcookiealive($key, $value, $duration){
			$_COOKIE[$key] = $value;
			setcookie($key, $value, $duration);
		}
		function spajanje(){
			
			
			$db_host="127.0.0.1";	
			$db_user= "root";		
			$db_password = "";		
			$db_name = "skola";	

			
			@$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);

					if(!$con){
						
						
						$greska = 'Spajanje na bazu nije uspjelo! <br>';
						
						$greska.=mysqli_connect_error(); 
						die("Spajanje na bazu nije uspjelo! Prekid rada skripte.".$greska);
					}
					else{
						
						$poruka = "Spajanje na bazu je uspješno. <br>";
						
						$poruka.= mysqli_get_host_info($con);
						
						mysqli_set_charset($con, 'utf8');
						return $con;
}
		}
		
		function login_check(){
			if(!isset($_SESSION['login'])){
				
				if(isset($_COOKIE['username'])){
					$_SESSION['login'] = true;
					$_SESSION['username'] = $_COOKIE['username'];
				}
				else{
					header("Location : index.php/?prijava");
					exit("Prvo se prijavite!");
				}
			}
			
		}
		
		function ocisti_tekst($string){
			global $con;
			$string = trim($string);
			$string = htmlspecialchars($string);
			$string = mysqli_real_escape_string($con, $string);
			return $string;
			
		}
	function drop($table_name_str){
	global $con;
	$id = $_GET['id'];
	$query = "DELETE FROM $table_name_str WHERE id = $id";
	$delete = mysqli_query($con, $query);
}



?>
						
					
						
						
						
			
