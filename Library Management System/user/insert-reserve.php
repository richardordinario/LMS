<?php
include("../connection.php");

$bookname = $_POST["bookn"];
$bookid = $_POST["book_id"];

//$qt = $_POST["quantity"];
$id = $_POST["libraryid"];

$check = mysqli_query($connection,"SELECT * FROM student WHERE libraryid = '$id' ");
$query_check = mysqli_num_rows($check);


date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');

$datereturn	 = date('Y-m-d', strtotime($date. '+ 1 days'));



if($query_check > 0)
{
	
	$perCheck = mysqli_fetch_assoc($check);
	
	$pending = $perCheck["pending"];
	
	$fname = $perCheck["fname"];
	$lname = $perCheck["lname"];
	$mi = $perCheck["mi"];

	$fullname = $fname . " " . $mi . " " . $lname;

	if($pending >= 3) {

		echo '<div class="alert alert-warning">Unable to borrow ! Student has pending book to return..</div>';
	}
	else 
	{
		if($bookname && $id)
		{
			$checkBook = mysqli_query($connection,"SELECT * FROM books WHERE id = '$bookid'");
			
			$check_row = mysqli_num_rows($checkBook);
			$fetch_book = mysqli_fetch_assoc($checkBook);
			$book_left = $fetch_book["book_left"];

			if($book_left != 0)
			{
				if($check_row > 0) {

					$check_borrow = mysqli_query($connection,"SELECT * FROM reserve WHERE libraryid = '$id' AND bookid = '$bookid'");

					$check_borrow_row = mysqli_num_rows($check_borrow);

					if ($check_borrow_row > 0) {
						# code...
									
						echo '<div class="alert alert-danger">Book already reserved!</div>';

					}else {

						$pending = $pending	+ 1;
						$stat = "0";

						mysqli_query($connection,"UPDATE student SET pending = '$pending' WHERE libraryid = '$id'");

						$book_left = $book_left - 1;

						mysqli_query($connection,"UPDATE books SET book_left = '$book_left' WHERE id = '$bookid'");

						mysqli_query($connection,"INSERT INTO reserve(libraryid,bookid,studname,bname,dateborrow) 
						VALUES('$id','$bookid','$fullname','$bookname','$datereturn') ");

						echo '<div class="alert alert-success">Book Successfully Reserved!</div>';	

					}
					
				}
			}
			else 
			{
				echo '<div class="alert alert-danger">Book is not available!</div>';
			}

		}
	}
}

else {
	
		echo '<div class="alert alert-danger">No record found!</div>';
}


?>