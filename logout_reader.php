<!--
File Name: logout.php
File Author: Alissa Myers
Purpose: Logs the current user out by destroying their session
-->
<?php
	session_start();
	session_destroy();
	header("Location:home.php");
?>