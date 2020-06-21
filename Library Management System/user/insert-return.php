<?php
include("../connection.php");

$libraryid = $_POST["studid"];
$borrowid = $_POST["borrowid"];
$bookid = $_POST["book_id"];

$stud_query = mysqli_query($connection,"SELECT * FROM student WHERE libraryid LIKE '%$libraryid%' ");
$stud_row = mysqli_fetch_assoc($stud_query);

$pending = $stud_row["pending"];
$pending = $pending - 1;

mysqli_query($connection,"UPDATE student SET pending = '$pending' WHERE libraryid LIKE '%$libraryid%'");

$book_query =  mysqli_query($connection,"SELECT * FROM books WHERE id = '$bookid' ");
$book_row = mysqli_fetch_assoc($book_query);
$db_left = $book_row["book_left"];

$db_left = $db_left + 1;

mysqli_query($connection,"UPDATE books SET book_left = '$db_left' WHERE id = '$bookid'");

$query = "DELETE FROM borrow WHERE id ='$borrowid' ";

if(mysqli_query($connection, $query))
{
	echo '<div class="alert alert-success">Book Successfully Returned!</div>';
}



?>