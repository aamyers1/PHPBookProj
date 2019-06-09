<!--
File Name: booksapi.php
File Author: Alissa Myers
Purpose: json encoded api service allows people to get a list of all book titles or to look up a title by id
-->
<?php
include 'database.php';
$pdo = Database::connect();

	if ( !empty($_GET['id'])) {
		$sql = 'SELECT book_title, book_author FROM books WHERE id=' . $_GET['id'];
	}
	else{
		$sql = 'SELECT book_title, book_author FROM books';
	}
	$arr = array();
	foreach($pdo->query($sql) as $row) {


		array_push($arr,  $row['book_title'])  ;
	}
	echo stripslashes('{"book_titles:'. json_encode($arr) . '}');


?>
