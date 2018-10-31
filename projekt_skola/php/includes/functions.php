<?php

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

function checkStatus(){
	$role = $_SESSION['role'];

	// Array of pages available only to administrators:
	$adminPages = array("course_add","courses","users","user_add","user");

	// Array of pages available to both administrators and professors:
	$staffPages = array("course","enrol","exam_add","group_add","group","groups","lesson_add","question_add");

	switch($role){
		// If the user is an administrator:
		case("1"):
			return 1;
			break;

		// If the user is a member of the staff: 
		case("2"):
			//If the current script is admin-only: 
			if (in_array(basename(__FILE__, ".php"),$adminPages)){
				return false;
			}
			else{
				return 2;
			}
			break;

		// If the user is either not logged in or if he is logged in as a student:
		default:
			// If the current script is staff-only:
			if(in_array(basename(__FILE__, ".php"),$staffPages)){
				return false;
			}
			else{
				return false;
			}
	}
}

?>
						
					
						
						
						
			
