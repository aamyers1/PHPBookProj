<!DOCTYPE HTML>
<!--
File Name: create_book.php
File Author: Alissa Myers
Purpose: Allows the creation of a new book
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
	
	if ( !empty($_POST)) {
		// keep track validation errors
		$titleError = null;
		$authorError = null;
		$dateError = null;
		$genreError = null;
		$pagesError = null;
		$descriptionError = null;
		$pictureError = null; // not used
		
		
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];
		$content = file_get_contents($tmpName);
		
		
		// keep track post values
		$title = $_POST['book_title'];
		$author = $_POST['book_author'];
		$date= $_POST['book_date'];
		$genre= $_POST['book_genre'];
		$pages = $_POST['book_pages'];
		$description = $_POST['book_description'];
		

		// validate input
		$valid = true;
		if (empty($title)) {
			$titleError = 'Please enter a title';
			$valid = false;
		}
		
		if (empty($author)) {
			$authorError = 'Please enter an author';
			$valid = false;
		}
		
		if (empty($date)) {
			$commentsError = 'Please enter a date';
			$valid = false;
		} 
		
		if (empty($genre)) {
			$genreError = 'Please enter a genre';
			$valid = false;
		}
		
		if (empty($pages)) {
			$pagesError = 'Please enter the number of pages';
			$valid = false;
		}
		
		if(empty($description)) {
			$descriptionError = 'Please enter book description';
			$valid = false;
		}
		
		// insert data
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO books(book_title, book_author, book_genre, book_date, book_pages, book_description,filename,filesize,filetype,filecontent) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($title,$author, $genre, $date, $pages, $description, $fileName,$fileSize,$fileType,$content));
			Database::disconnect();
			header("Location: home.php");
		}
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
								<h2>Add a Book</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">

									<div class="row">
		    			<h3>Add a New Book</h3>
		    		</div>
					
					<form class="form-horizontal" action="create_book.php" method="post" enctype="multipart/form-data">
					
					  <div class="control-group <?php echo !empty($titleError)?'error':'';?>">
					    <label class="control-label"></label>
					    <div class="controls">
							<label>Title</label>
					      	<input name="book_title" type="text"  placeholder="Title" value="<?php echo !empty($title)?$title:'';?>">
					      	<?php if (!empty($titleError)): ?>
					      		<span class="help-inline"><?php echo $titleError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($ratingError)?'error':'';?>">
					    <label class="control-label">Author</label>
					    <div class="controls">
					      	<input name="book_author" type="text" placeholder="Author" value="<?php echo !empty($author)?$author:'';?>">
					      	<?php if (!empty($authorError)): ?>
					      		<span class="help-inline"><?php echo $authorError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($genreError)?'error':'';?>">
					    <label class="control-label">Genre</label>
					    <div class="controls">
					      	<input name="book_genre" type="text"  placeholder="Genre" value="<?php echo !empty($genre)?$genre:'';?>">
					      	<?php if (!empty($genreError)): ?>
					      		<span class="help-inline"><?php echo $genreError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					<div class="control-group <?php echo !empty($dateError)?'error':'';?>">
					    <label class="control-label">Year</label>
					    <div class="controls">
					      	<input name="book_date" type="text"  placeholder="Year" value="<?php echo !empty($date)?$date:'';?>">
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
					  <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
					    <label class="control-label">Description</label>
					    <div class="controls">
					      	<input name="book_description" type="text"  placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
					      	<?php if (!empty($descriptionError)): ?>
					      		<span class="help-inline"><?php echo $descriptionError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  <div class="control-group <?php echo !empty($pictureError)?'error':'';?>">
					    <label class="control-label">Cover</label>
					    <input type="hidden" name="MAX_FILE_SIZE" value="16000000">
						<input name="userfile" type="file" id="userfile">
						
					 </div>
					  <br>
					  <br>
					  
					  <div class="form-actions">
						  <button type="submit" class="button special">Create</button>
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