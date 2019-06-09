<!DOCTYPE HTML>
<!--
File Name: create_reader.php
File Author: Alissa Myers
Purpose: User signup form
-->
<!--
	Solid State by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->


<?php
// from: https://www.youtube.com/watch?v=lGYixKGiY7Y

session_start();
//connect to database
require 'database.php';


	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$usernameError = null;
		$emailError = null;
		$passwordError = null;
		$password2Error = null;

		
		// keep track post values
		$name= $_POST['reader_name'];
		$username = $_POST['reader_username'];
		$email = $_POST['reader_email'];
		$password = $_POST['reader_password'];
		$password2 = $_POST['password2'];
		$date = $_POST['reader_join_date'];
		
		$date =  date('Y-m-d H:i:s');
		// validate input
		$valid = true;
		if (empty($name)) {
			$titleError = 'Please enter a name';
			$valid = false;
		}
		
		if (empty($username)) {
			$ratingError = 'Please enter a username';
			$valid = false;
		}
		
		
		if (empty($email)) {
			$commentsError = 'Please enter an email';
			$valid = false;
		}
		
		if(empty($password)) {
			$passwordError = 'Please enter a password';
			$valid = false;
		}
		
		if(empty($password2)) {
			$password2Error = 'Please confirm password';
			$valid = false;
		}
		
		if ($password != $password2) {
			$password2Error = 'Confirm password does not match password';
			$valid = false;
		}
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO readers(reader_name,reader_email,reader_username,reader_password,reader_join_date) values(?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$email,$username,$password,$date));
			Database::disconnect();
			header("Location: home.php");
		}
	}
	
?>
<html>
	<head>
		<title>Sign Up</title>
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
								<h2>Create New Account</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
														 
						<form class="form-horizontal" action="create_reader.php" method="post">
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">Name</label>
					    <div class="controls">
					      	<input name="reader_name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($usernameError)?'error':'';?>">
					    <label class="control-label">Username</label>
					    <div class="controls">
					      	<input name="reader_username" type="text" placeholder="Username" value="<?php echo !empty($username)?$username:'';?>">
					      	<?php if (!empty($usernameError)): ?>
					      		<span class="help-inline"><?php echo $usernameError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email</label>
					    <div class="controls">
					      	<input name="reader_email" type="text"  placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="reader_password" type="password"  placeholder="Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passowrdError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($password2Error)?'error':'';?>">
					    <label class="control-label">Confirm Password</label>
					    <div class="controls">
					      	<input name="password2" type="password"  placeholder="Password" value="<?php echo !empty($password2)?$password2:'';?>">
					      	<?php if (!empty($password2Error)): ?>
					      		<span class="help-inline"><?php echo $password2Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						<br>
						  <button type="submit" class="button special">Create</button>
						  <a class="button" href="home.php">Back</a>
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