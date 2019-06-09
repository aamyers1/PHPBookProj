<!--
File Name: login.php
File Author: Alissa Myers
Purpose: User login
-->
<?php
session_start();

$name = $_POST['username'];
$password = $_POST['password'];

include 'database.php';
$pdo =Database::connect();

$sql = 'SELECT * FROM readers WHERE reader_username = "' . $name . '"';
foreach($pdo->query($sql) as $row) {
	if($row['reader_password'] == $password) {
		$loginApproved = true;
		$_SESSION['user'] = $row['username'];
		$_SESSION['userid'] = $row['id'];	

	}

}

		header('Location:home.php');

?>