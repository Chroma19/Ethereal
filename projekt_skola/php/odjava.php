<?php
	session_start();
	
	// Set cookie's duration to a negative time period in order to delete it
	setcookie('username', $_SESSION['username'], time()-1);
	session_destroy();
	
	header('Location: index.php');
?>