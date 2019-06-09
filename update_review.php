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
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	
	if ( null==$id ) {
		header("Location: home.php");
	}
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$scoreError = null;
		$titleError = null;
		$commentsError = null;

		
		// keep track post values
		$score= $_POST['rating_score'];
		$title = $_POST['rating_title'];
		$comments = $_POST['rating_comments'];

		$date =  date('Y-m-d H:i:s');
		// validate input
		$valid = true;
		if (empty($score)) {
			$scoreError = 'Please enter a score';
			$valid = false;
		}
		if($score > 10 or $score < 0) {
			$scoreError = 'Score must be between 1 and 10';
			$valid = false;
		}
		
		if (empty($title)) {
			$titleError = 'Please enter review title';
			$valid = false;
		}
		
		if (empty($comments)) {
			$commentsError = 'Please enter review comments';
			$valid = false;
		}
		
		
		// update data
		if ($valid) {

			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE ratings  set rating_score = ?, rating_title = ?, rating_comments =?, rating_date =?  WHERE id = ?";
			$q = $pdo->prepare($sql);


			$q->execute(array($score, $title, $comments, $date, $id));

			Database::disconnect();
			header("Location: books.php");
		}
	}
	else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM ratings where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$score = $data['rating_score'];
		$title = $data['rating_title'];
		$comments = $data['rating_comments'];
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
								<form class="form-horizontal" action="update_review.php?id=<?php echo $id;?>" method="post">
					  <div class="control-group <?php echo !empty($scoreError)?'error':'';?>">
					    <label class="control-label">Score</label>
					    <div class="controls">
					      	<input name="rating_score" type="text"  placeholder="Score" value="<?php echo !empty($score)?$score:'';?>">
					      	<?php if (!empty($scoreError)): ?>
					      		<span class="help-inline"><?php echo $scoreError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
					    <label class="control-label">Title</label>
					    <div class="controls">
					      	<input name="rating_title" type="text" placeholder="Title" value="<?php echo !empty($title)?$title:'';?>">
					      	<?php if (!empty($titleError)): ?>
					      		<span class="help-inline"><?php echo $titleError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($commentsError)?'error':'';?>">
					    <label class="control-label">Comments</label>
					    <div class="controls">
					      	<input name="rating_comments" type="text"  placeholder="Comments" value="<?php echo !empty($comments)?$comments:'';?>">
					      	<?php if (!empty($commentsError)): ?>
					      		<span class="help-inline"><?php echo $commentsError;?></span>
					      	<?php endif;?>
							
				
					    </div>
					  </div>
					  
					  <br />
					  <br />
					  <div class="form-actions">
						  <button type="submit" class="button special fit">Update</button>
						  <a class="button fit " href="books.php">Back</a>
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