<!DOCTYPE HTML>
<!--
File Name: delete_reader.php
File Author: Alissa Myers
Purpose: Allows a user to delete their own account
-->
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->

<?php
	require 'database.php';
	session_start();
	if (Empty($_SESSION['userid'])) {
		Database::login();
		exit();
	}
	
		if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( !empty($_POST)) {
		// keep track post values
		$id = $_POST['id'];
		
		// delete data
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "DELETE FROM readers  WHERE id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$sql = "DELETE FROM ratings WHERE reader_id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		Database::disconnect();
		header("Location: logout_reader.php");
		
	} 
?>

<html>
	<head>
		<title>Delete Your Account</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css" />
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
	</head>
	<body>

		<!-- Page Wrapper -->
			<div id="page-wrapper">

				<?php 
					Database::mainMenu();
					?>

				<!-- Wrapper -->
					<section id="wrapper">
						<header>
							<div class="inner">
								<h2>Delete Account</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">

		
		    		
	    			<form class="form-horizontal" action="delete_reader.php" method="post">
	    			  <input type="hidden" name="id" value="<?php echo $_SESSION['userid'];?>"/>
					  <p class="alert alert-error">Are you sure you want to delete this reader?</p>
					  <p>Warning! This action cannot be undone!</p>
					  <div class="form-actions">
						  <button type="submit" class="button special">Yes</button>
						  <a class="button" href="profile.php">No</a>
						</div>
					</form>
								</div>
							</div>

					</section>

				

			</div>

		<!-- Scripts -->
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="assets/js/main.js"></script>

	</body>
</html>