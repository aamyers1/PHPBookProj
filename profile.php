
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
		$pdo = database::connect();
	$sql = "SELECT * FROM readers where id = " . $_SESSION['userid'];
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	

	Database::disconnect();

?>



		<!-- Page Wrapper -->
			<div id="page-wrapper">



				<!-- Wrapper -->
					<section id="wrapper">
						<header>
							<div class="inner">
								<h2>Account Information</h2>
							</div>
						</header>

						<!-- Content -->
							<div class="wrapper">
								<div class="inner">
									<h2>Welcome, <?php echo ''. $data['reader_name']; ?></h2>
									<br />
									<br />
									<?php 
										echo "Name: " . $data['reader_name'];
										echo "<br />";
										echo"<br />";
										echo "Username: " . $data['reader_username'];
										echo "<br />";
										echo"<br />";
										echo "Email: " . $data['reader_email'];
										echo "<br />";
										echo"<br />";
										echo "Member Since: " . $data['reader_join_date'];
										echo "<br />";
									?>
											
									<div class="container buttons">
										<br />
										<a href="update_reader.php" class="button special fit">Update Profile</a>
										<a href ="delete_reader.php" class="button fit">Delete User</a>
										<a href = "home.php" class="button fit">Back</a>
										<br />
										<hr />
										<br />
									</div>
									<div class="container userReviews">
									</div>
									<h2>Your Reviews</h2>
									<div class="table-wrapper">
											<table class="alt">
												
													<?php 
																			
																			
														$sql2 = 'SELECT ratings.id, book_title, book_author, rating_score,rating_comments, rating_date, rating_title FROM ratings INNER JOIN books ON books.id = ratings.book_id WHERE reader_id = ' . $_SESSION['userid']; 
											
														
												foreach ($pdo->query($sql2) as $row) {
											echo '<tr><td width="25%">Title: '. $row['book_title'] . '<br />';							        
											echo 'Author: ' . $row['book_author'] . '<br />';
											echo 'Date: ' . $row['rating_date'] . '<br />';
											
												
												echo '<a href="update_review.php?id=' . $row['id'] . '" class="button fit small ">Update Your Review</a>';
												echo '<a href="delete_review.php?id=' . $row['id'] . '" class="button fit small" >Delete this Review</a>';
											
											echo '</td>';
											
											echo '<td>Title: ' . $row['rating_title'] . ' <br />';
											echo 'Score:  ' . $row['rating_score'] . ' <br />';
											echo 'Comments: '. $row['rating_comments']. '</td></tr>';
														}

								
													?>
											</table>
									</div>

							</section>

				

			</div>


