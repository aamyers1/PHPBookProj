<!DOCTYPE HTML>
<!--
File Name: books.php
File Author: Alissa Myers
Purpose: Lists all books in database in a table
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
								<h2>Books</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<a href="create_book.php" class="button special fit">Create New Book</a>
									<form method="post" action="books.php">
									<div class="12u$">
										<label for="demo-category">Sort By:</label>
										<div class="select-wrapper">
											<select name="demo-category" id="demo-category">
												<option value="1">Title</option>
												<option value="2">Author</option>
												<option value="3">Year</option>
												<option value="4">Genre</option>
											</select>
											<br />
											
											<input type="submit" value="sort" class="button fit" />
										</div>
									</div>
									</form>
									<br>
									<br>
										<div class="table-wrapper">
											<table class="alt">
												<thead>
												<tr>
													<th>Title</th>
													<th>Author</th>
													<th>Genre</th>
													<th>Date</th>
														<th></th>
												</tr>
												</thead>
												<tbody>
												<?php
												$option = $_POST['demo-category'];
												$str = "book_title";
												if ($option == '1') {
													$str= 'book_title';
												}
												if ($option == '2') {
													$str = 'book_author';
												}
												if($option == '3') {
													$str = 'book_date';
												}
												if($option == '4') {
													$str = 'book_genre';
												}
												
												$pdo = Database::connect();
												$sql = 'SELECT * FROM books ORDER BY ' . $str . ' ASC';
												foreach ($pdo->query($sql) as $row) {
															echo '<tr>';
															echo '<td>'. $row['book_title'] . '</td>';
															echo '<td>'. $row['book_author'] . '</td>';
															echo '<td>'. $row['book_genre'] . '</td>';
															echo '<td>'. $row['book_date'] . '</td>';
															echo '<td width=250>';
															echo '<a class="button fit" href="read_book.php?id='.$row['id'].'">Read</a>';
															echo '&nbsp;';
															echo '<a class="button fit" href="update_book.php?id='.$row['id'].'">Update</a>';
															echo '</td>';
															echo '</tr>';
												}
												Database::disconnect();
												?>
												</tbody>
											</table>
										</div>
									</section>

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