<?php
include("../connection.php");

$id = $_POST["book_id"];
$qt = $_POST["booknum"];


$get_dbstock = mysqli_query($connection,"SELECT * FROM books WHERE id = '$id' ");
while($row = mysqli_fetch_assoc($get_dbstock)){
	$dbLeft = $row['book_left'];
	$dbStock = $row['stock'];
	$dbLeft = $dbLeft + $qt;
	$dbStock = $dbStock + $qt;
	mysqli_query($connection,"UPDATE books SET
		book_left = '$dbLeft',
		stock = '$dbStock'
		WHERE id = '$id'
	");
	echo 'Book Successfully Added!';
}

?>