<!DOCTYPE HTML>
<!--
File Name: create_review.php
File Author: Alissa Myers
Purpose: Allows users to create a new review
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
		echo ''. $SESSION_['userid'] . ' ';
		$id = null;
		if ( !empty($_GET['id'])) {
			$id = $_REQUEST['id'];
		}
		if ( null==$id ){
			echo 'oop';
		}
	
		$pdo = Database::connect();
		$sql = 'SELECT * FROM ratings WHERE book_id =' . $id . '';
		foreach ($pdo->query($sql2) as $row) {
			if($row['reader_id'] == $_SESSION['userid']){
				echo '<h2>You have already reviewed this book.</h2>';
				echo '<a href="books.php" class="button fit">Back</a>';
				exit();
			}
		}
		

	if ( !empty($_POST)) {
		// keep track validation errors
		$titleError = null;
		$ratingError = null;
		$commentsError = null;

		
		// keep track post values
		$title = $_POST['rating_title'];
		$rating = $_POST['rating_score'];
		$comments = $_POST['rating_comments'];
		$date = $_POST['rating_date'];
		
		$date =  date('Y-m-d H:i:s');
		// validate input
		$valid = true;
		if (empty($title)) {
			$titleError = 'Please enter a title';
			$valid = false;
		}
		
		if (empty($rating)) {
			$ratingError = 'Please enter a score out of 10';
			$valid = false;
		}
		if($rating < 0 or $rating > 10) {
			$valid = false;
			$ratingError = 'rating out of bounds!';
		}
		
		if (empty($comments)) {
			$commentsError = 'Please enter some comments';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO ratings(rating_title,rating_score,rating_comments,reader_id,book_id,rating_date) values(?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($title,$rating,$comments, $_SESSION['userid'], $id, $date));
			Database::disconnect();
			header("Location: books.php");
		}
	}
	
?>

<html>
	<head>
		<title>Create Review</title>
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
								<h2>Write a Review</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">

									<?php 
						echo '<form class="form-horizontal" action="create_review.php?id=' . $id . '"method="post">';
					?>
					  <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
					    <label class="control-label">Title</label>
					    <div class="controls">
					      	<input name="rating_title" type="text"  placeholder="Title" value="<?php echo !empty($title)?$title:'';?>">
					      	<?php if (!empty($titleError)): ?>
					      		<span class="help-inline"><?php echo $titleError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
					    <label class="control-label">Rating</label>
					    <div class="controls">
					      	<input name="rating_score" type="text" placeholder="Score" value="<?php echo !empty($rating)?$rating:'';?>">
					      	<?php if (!empty($ratingError)): ?>
					      		<span class="help-inline"><?php echo $ratingError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($commentsError)?'error':'';?>">
					    <label class="control-label">Comments</label>
					    <div class="controls">
					      	<textarea name="rating_comments" rows="4"  placeholder="Comments" value="<?php echo !empty($comments)?$comments:'';?>"></textarea>
					      	<?php if (!empty($commentsError)): ?>
					      		<span class="help-inline"><?php echo $commentsError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="form-actions">
						  <button type="submit" class="button special ">Create</button>
						  <a class="button" href="books.php">Back</a>
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