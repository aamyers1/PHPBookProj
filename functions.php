<!--
File Name: functions.php
File Author: Alissa Myers
Purpose: Contains object oriented code for some pages
-->
<?php 
Class Functions {

	public function session_var() {
			session_start();
	if (Empty($_SESSION['userid'])) {
		Database::login();
		exit();
	}
	}
	public function RRhead() {
		echo '<head><title>Readers</title><meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1"/><link rel="stylesheet" href="assets/css/main.css"/></head><body><!-- Page Wrapper --><div id="page-wrapper">';
		Database::mainMenu();
		echo '<section id="wrapper"><header><div class="inner"><h2>All Readers</h2></div></header><div class="wrapper"><div class="inner"><div class="table-wrapper"><table class="alt"> <thead> <tr> <th>Username</th> <th>Join Date</th> <th>Options</th> </tr></thead> <tbody>';
		
	}
	
	public function readers_table_php() {
		$pdo = Database::connect();
		$sql = 'SELECT * FROM readers ORDER BY id';
		foreach ($pdo->query($sql) as $row) {
				echo '<tr>';
			echo '<td>'. $row['reader_username'] . '</td>';
			echo '<td>'. $row['reader_join_date'] . '</td>';
			echo '<td width=250>';
			echo '<a class="button special fit" href="read_user.php?id='.$row['id'].'">User Details</a>';
			echo '</td>';
			echo '</tr>';
		}
		Database::disconnect();
	}
	
	public function RRfoot() {
		echo '</tbody></table></div></div></section></div><script src="assets/js/skel.min.js"></script><script src="assets/js/jquery.min.js"></script><script src="assets/js/jquery.scrollex.min.js"></script><script src="assets/js/util.js"></script><script src="assets/js/main.js"></script></body>';
	}
	
	public function RRPage() {
		self::RRhead();
		self::readers_table_php();
		self::RRfoot();
	}
	public function RUMainPHP(){
	
	$id = null;
	if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
	}
	

	$pdo = database::connect();
	$sql = "SELECT * FROM readers where id = " . $id;
	$q = $pdo->prepare($sql);
	$q->execute(array($id));
	$data = $q->fetch(PDO::FETCH_ASSOC);
	

	Database::disconnect();
	self::RUHead();
						echo "Name: " . $data['reader_name'];
					echo "<br />";
					echo "Username: " . $data['reader_username'];
					echo"<br />";
					echo "Member Since: " . $data['reader_join_date'];
					echo "<br />";
	}

	
	public function RUHead() {
		echo '<head><title>User Details</title><meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1"/><link rel="stylesheet" href="assets/css/main.css"/></head><body><div id="page-wrapper"><?php Database::mainMenu();?><section id="wrapper"><header><div class="inner"><h2>User Details</h2></div></header><div class="wrapper"><div class="inner"><h2> User Information </h1><div class="container infos">';
		Database::mainMenu();
	}
	
	public function RUMid() {
		echo '<br/><br/><a href="read_readers.php" class="button special fit">Back</a></div><br/><hr><br/><h4>User Reviews</h4><br/><div class="table-wrapper"><table class="alt">';
	}
	
	public function RUFoot() {
		echo '</table></div></div></section></div><script src="assets/js/skel.min.js"></script><script src="assets/js/jquery.min.js"></script><script src="assets/js/jquery.scrollex.min.js"></script><script src="assets/js/util.js"></script><script src="assets/js/main.js"></script></body>';
	}
	
	public function RURevTab() {
		$pdo = database::connect();
		$count = 0;
		$id = null;
		if ( !empty($_GET['id'])) {
		$id = $_REQUEST['id'];
		}
		$sql2 = 'SELECT * FROM ratings INNER JOIN books ON books.id = ratings.book_id WHERE reader_id = ' . $id; 
																
							
										
							foreach ($pdo->query($sql2) as $row) {
							echo '<tr><td width="25%"><a href="read_book.php?id=' . $row['id'] .'">Title: '. $row['book_title'] . '</a><br />';							        
							echo 'Author: ' . $row['book_author'] . '<br />';
							echo 'Date: ' . $row['rating_date'] . '<br />';
							
							echo '</td>';
							
							echo '<td>Title: ' . $row['rating_title'] . ' <br />';
							echo 'Score:  ' . $row['rating_score'] . ' <br />';
							echo 'Comments: '. $row['rating_comments']. '</td></tr>';
							$count ++;
										}

		if ($count == 0) {
			echo '<tr><td>This user has no reviews<td><td></td><td></td><td></td></tr>';
		}
		Database::disconnect();
	}
	
	public function RUPage() {
		self::RUMainPHP();
		self::RUMid();
		self::RURevTab();
		self::RUFoot();

	}
}
?>