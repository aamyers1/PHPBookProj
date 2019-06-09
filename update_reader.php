<!DOCTYPE HTML>

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
		$id = $_SESSION['userid'];
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT * FROM readers WHERE id = ?'; 
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$oldPassword = $data['reader_password'];
	Database::disconnect();

	if ( !empty($_POST)) {
		// keep track validation errors
		$passwordError = null;
		$password2Error = null;
		$prevPasswordError = null;
		$emailError = null;
		
		// keep track post values
		$password = $_POST['reader_password'];
		$email = $_POST['reader_email'];
		$prevPassword = $_POST['prevPass'];
		$password2 = $_POST['password2'];
		// validate input
		$valid = true;
		if (empty($prevPassword)) {
			$prevPasswordError = 'Please enter old password';
			$valid = false;
		}
		if($oldPassword != $prevPassword) {
			$prevPasswordError = 'Does not match your current password';
			$valid = false;
		}
		if (empty($password)) {
			$passwordError = 'Please enter new password';
			$valid = false;
		}
		
		if (empty($password2)) {
			$password2Error = 'Please confirm new password';
			$valid = false;
		}
		if ($password != $password2) {
			$password2Error = 'Password confirm does not match original password';
			$valid = false;
		}
		
		if (empty($email)) {
			$emailError = 'Please enter your email';
			$valid = false;
		}
			
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE readers  set reader_email = ?, reader_password = ? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($email, $password, $id));
			Database::disconnect();
			header("Location: profile.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM readers where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$email = $data['reader_email'];
		Database::disconnect();
	}

?>

<html>
	<head>
		<title>Home</title>
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
								<h2>Home</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">

									<form class="form-horizontal" action="update_reader.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					    <label class="control-label">Email</label>
					    <div class="controls">
					      	<input name="reader_email" type="text"  placeholder="Email" value="<?php echo !empty($email)?$email:'';?>">
					      	<?php if (!empty($emailError)): ?>
					      		<span class="help-inline"><?php echo $emailError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($prevPasswordError)?'error':'';?>">
					    <label class="control-label">Previous Password</label>
					    <div class="controls">
					      	<input name="prevPass" type="password" placeholder="Previous Password" value="<?php echo !empty($prevPassword)?$prevPassword:'';?>">
					      	<?php if (!empty($prevPasswordError)): ?>
					      		<span class="help-inline"><?php echo $prevPasswordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">New Password</label>
					    <div class="controls">
					      	<input name="reader_password" type="password"  placeholder="New Password" value="<?php echo !empty($password)?$password:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($password2Error)?'error':'';?>">
					    <label class="control-label">Confirm New Password</label>
					    <div class="controls">
					      	<input name="password2" type="password"  placeholder="Confirm Password" value="<?php echo !empty($password2)?$password2:'';?>">
					      	<?php if (!empty($password2Error)): ?>
					      		<span class="help-inline"><?php echo $password2Error;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="button special fit">Update</button>
						  <a class="button fit" href="home.php">Back</a>
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