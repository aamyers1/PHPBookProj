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
		$authorError = null;
		$dateError = null;
		$pagesError = null;
		$descriptionError = null;
		$genreError = null;
		
		// keep track post values
		$author = $_POST['book_author'];
		$date = $_POST['book_date'];
		$pages = $_POST['book_pages'];
		$description = $_POST['book_description'];
		$genre = $_POST['book_genre'];
		
		// validate input
		$valid = true;
		if (empty($author)) {
			$authorError = 'Please enter an author';
			$valid = false;
		}
		
		if (empty($date)) {
			$dateError = 'Please enter book year';
			$valid = false;
		}
		
		if (empty($pages)) {
			$pagesError = 'Please enter number of pages';
			$valid = false;
		}
		
		if (empty($description)) {
			$descriptionError = 'Please enter a description';
			$valid = false;
		}
		
		if (empty($pages)) {
			$genreError = 'Please enter genre';
			$valid = false;
		}
		
		
		// update data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE books  set book_author = ?, book_date = ?, book_pages =?, book_description =?, book_genre =? WHERE id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($author,$date,$pages,$description,$genre,$id));
			Database::disconnect();
			header("Location: books.php");
		}
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM books where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		$author = $data['book_author'];
		$date = $data['book_date'];
		$pages = $data['book_pages'];
		$description = $data['book_description'];
		$genre = $data['book_genre'];
		Database::disconnect();
	}

?>

<html>
	<head>
		<title>Update Book</title>
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
								<h2>Update Book</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">

								<form class="form-horizontal" action="update_book.php?id=<?php echo $id?>" method="post">
					  <div class="control-group <?php echo !empty($authorError)?'error':'';?>">
					    <label class="control-label">Author</label>
					    <div class="controls">
					      	<input name="book_author" type="text"  placeholder="Author" value="<?php echo !empty($author)?$author:'';?>">
					      	<?php if (!empty($authorError)): ?>
					      		<span class="help-inline"><?php echo $authorError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Year</label>
					    <div class="controls">
					      	<input name="book_date" type="text" placeholder="Year" value="<?php echo !empty($date)?$date:'';?>">
					      	<?php if (!empty($dateError)): ?>
					      		<span class="help-inline"><?php echo $dateError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($pagesError)?'error':'';?>">
					    <label class="control-label">Pages</label>
					    <div class="controls">
					      	<input name="book_pages" type="text"  placeholder="Pages" value="<?php echo !empty($pages)?$pages:'';?>">
					      	<?php if (!empty($pagesError)): ?>
					      		<span class="help-inline"><?php echo $pagesError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($genreError)?'error':'';?>">
					    <label class="control-label">Genre</label>
					    <div class="controls">
					      	<input name="book_genre" type="text"  placeholder="Description" value="<?php echo !empty($genre)?$genre:'';?>">
					      	<?php if (!empty($genreError)): ?>
					      		<span class="help-inline"><?php echo $genreError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="book_description" type="text"  placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="button special">Update</button>
						  <a class="button" href="books.php">Back</a>
						</div>
					</form>
				</div>
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