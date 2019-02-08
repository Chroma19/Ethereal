<?php

// test function for printing arrays
function ispisi_polje($array){
	echo"<pre>";
	print_r($array);
	echo"</pre>";
}
		
// set cookie before being reassigned Session ID via server which happens only after page refresh
function setcookiealive($key, $value, $duration){
	$_COOKIE[$key] = $value;
	setcookie($key, $value, $duration);
}

// Connect to DB
function spajanje(){
	
	
	$db_host="127.0.0.1";	
	$db_user= "root";		
	$db_password = "";		
	$db_name = "skola";	

	// @ symbol used as escape parameter
	@$con = mysqli_connect($db_host, $db_user, $db_password, $db_name);

			// if mysqli_connect returns false/if DB login fails: 
			if(!$con){
				
				$greska = mysqli_connect_error(); 

				die("Spajanje na bazu nije uspjelo! Prekid rada skripte.".$greska);
			}
			
			// if DB login is successful:
			else{
				
				$poruka = mysqli_get_host_info($con);
				
				mysqli_set_charset($con, 'utf8');

				return $con;
			}
}
		
	// Filter and secure any inputted text prior to sending it to DB for any reason
	// SQL injection and XSS prevention
	function ocisti_tekst($string){
		
		global $con;
		
		$string = trim($string);

		$string = htmlspecialchars($string);

		$string = mysqli_real_escape_string($con, $string);

		return $string;
	}

	// drop selected id from DB table called $table_name_str
	function drop($table_name_str){

		global $con;

		$id = $_GET['id'];

		$query = "DELETE FROM $table_name_str WHERE id = $id";

		$delete = mysqli_query($con, $query);

		if($delete){
			return true;
		}

		else{
			return false;
		}
	}

	/*
	    Check the status of current user 
	    If logged in - see if they are logged in as admin, staff or student
	    If not logged in prohibit access to certain pages
	*/   

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
				if (in_array(basename(__FILE__, ".php"), $adminPages)){
					return false;
				}
				else{
					return 2;
				}
				break;

			// If the user is either not logged in or if he is logged in as a student:
			default:
				// If the current script is staff-only:
				if(in_array(basename(__FILE__, ".php"), $staffPages)){
					return false;
				}
				else{
					return false;
				}
		}
	}

	// Check if there is a previously saved cookie on the machine
	function cookieCheck(){

	// If the user has not sent a login request
		if(!isset ($_SESSION['login'])){
			// Check if there are any previously saved cookies
			// Containing username (and only username due to security reasons)
			if(isset($_COOKIE['username'])){
				$_SESSION['login'] = true;
				$_SESSION['username'] = $_COOKIE['username'];
				$_SESSION['userid'] = $_COOKIE['userid'];
				$_SESSION['role'] = $_COOKIE['role'];
			}

			// If there are no cookies with user credentials
			// "Log out"
			else{
				$_SESSION['login'] = false;
			}

		}	
	} 
	?>
						
					
						
						
						
			
