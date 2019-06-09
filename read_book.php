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
		header("Location: read_readers.php");
	} else {
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM books where id = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($id));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		Database::disconnect();
	}

?>

<html>
	<head>
		<title>Book Information</title>
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
								<h2>Details</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">

									<h1>Details</h1>
						<?php
							if ($data['filecontent'] != null) {
							echo "<img height='400px' width='auto' src='data:image/jpeg;base64," . base64_encode($data['filecontent']) . "'>";
							}
							echo '<br />Title: ' . $data['book_title'] . '<br />';
							echo 'Author: ' . $data['book_author'] . '<br />';
							echo 'Year: ' . $data['book_date'] . '<br />';
							echo 'Genre: ' . $data['book_genre'] . '<br />';
							echo 'Pages: ' . $data['book_pages'] . '<br />';
							echo 'Description: ' . $data['book_description'] . '<br />';
							
						?>
						
						<br />
						<br />
						<?php 
						echo '<a href="create_review.php?id='. $id . '" class="button special fit">Write a New Review</a><br />';
						echo '  <a href="books.php" class="button fit">Back</a>';
						?>
						<br/>
						<br />
						<h2>Book Reviews </h2>
						<hr />
						<br />
						<table>
										
							
									<?php
										$sql2  = 'SELECT ratings.id, rating_title, rating_score, rating_date, rating_comments, reader_username, reader_id FROM ratings INNER JOIN books ON ratings.book_id = books.id INNER JOIN readers ON ratings.reader_id = readers.id WHERE books.id=' . $id ;
										foreach ($pdo->query($sql2) as $row) {
											echo '<tr><td width="25%"><a href="read_user.php?id=' . $row['reader_id'] .'">'. $row['reader_username'] . '</a><br />';							        
											echo 'Score:&nbsp &nbsp ' . $row['rating_score'] . '<br />';
											echo 'Date: ' . $row['rating_date'] . '<br />';
											if($_SESSION['userid'] == $row['reader_id']) {
												
												echo '<a href="update_review.php?id=' . $row['id'] . '" class="button fit small ">Update Your Review</a>';
												echo '<a href="delete_review.php?id=' . $row['id'] . '" class="button fit small" >Delete this Review</a>';
											}
											echo '</td>';
											
											echo '<td>Title: ' . $row['rating_title'] . ' <br />';
											echo 'Comments: '. $row['rating_comments']. '</td></tr>';
											
											
									
										}
										
									?>
									</table>
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