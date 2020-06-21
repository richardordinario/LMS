<?php
include("../connection.php");

$bookname = $_POST["bookName"];
$dis = $_POST["description"];
$author = $_POST["author"];
$category = $_POST["cat"];
$qt = $_POST["stock"];
$dbLeft = $_POST["stock"];
$id = $_POST["id"];

if($id == "")
{
	if($bookname && $dis && $author && $category && $qt)
	{
		mysqli_query($connection,"INSERT INTO books(book_name,book_dis,book_cat,author,book_left,stock) 
		VALUES('$bookname','$dis','$category','$author','$qt','$qt') ");
		
		echo 'Book Successfully Save!';
	}	
}
else 
{
	//$dbStock = $row['stock'];

	$check_borrow = mysqli_query($connection,"SELECT * FROM borrow WHERE bookid = '$id' ");
	if(mysqli_num_rows($check_borrow) > 0) 
	{
		$borrow = mysqli_num_rows($check_borrow);
		$dbLeft = $dbLeft - $borrow;
	}
	else
	{

	}
	$check_reserve = mysqli_query($connection,"SELECT * FROM reserve WHERE bookid = '$id' ");
	if(mysqli_num_rows($check_reserve) > 0) 
	{
		$reserve = mysqli_num_rows($check_reserve);
		$dbLeft = $dbLeft - $reserve;
	}
	else
	{

	} 
	mysqli_query($connection,"UPDATE books SET

		book_name = '$bookname',
		book_dis = '$dis',
		book_cat = '$category',
		author = '$author',
		book_left = '$dbLeft',
		stock = '$qt'
		WHERE id = '$id'
		
	");
	echo 'Book Successfully Updated!';
}


?>