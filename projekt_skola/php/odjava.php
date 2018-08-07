<?php
	session_start();
	
	setcookie('username', $_SESSION['username'], time()-1);
	session_destroy();
	
	header('Location: index.php');
?>