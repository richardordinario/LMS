<?php
include("../connection.php");

$bookname = $_POST["bookn2"];
$bookid = $_POST["book_id2"];
$days = $_POST["days"];
$reserveid = $_POST["res_id"];
$fullname = $_POST["studname2"];
//$qt = $_POST["quantity"];
$id = $_POST["libraryid2"];

$check = mysqli_query($connection,"SELECT * FROM student WHERE libraryid = '$id' ");
$query_check = mysqli_num_rows($check);
$penCheck = mysqli_fetch_assoc($check);

$pending = $penCheck["pending"];
$pending = $pending - 1;

mysqli_query($connection,"UPDATE student SET pending = '$pending' WHERE libraryid = '$id'");

date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');

	if($days == "1") {

		$datereturn	 = date('Y-m-d', strtotime($date. '+ 1 days'));

	}else if($days == "2") {
		$datereturn	 = date('Y-m-d', strtotime($date. '+ 2 days'));

	}else if($days == "3") {
		$datereturn	 = date('Y-m-d', strtotime($date. '+ 3 days'));

	}else if($days == "4") {
		$datereturn	 = date('Y-m-d', strtotime($date. '+ 4 days'));

	}else if($days == "5") {
		$datereturn	 = date('Y-m-d', strtotime($date. '+ 5 days'));

	}

if($query_check > 0)
{
	
	$perCheck = mysqli_fetch_assoc($check);
	$new_pending = $perCheck["pending"];


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

					$check_borrow = mysqli_query($connection,"SELECT * FROM borrow WHERE libraryid = '$id' AND bookid = '$bookid'");

					$check_borrow_row = mysqli_num_rows($check_borrow);

					if ($check_borrow_row > 0) {
						# code...
									
						echo '<div class="alert alert-danger">Book already borrowed!</div>';

					}else {

						$new_pending = $new_pending	+ 1;
						$stat = "0";

						mysqli_query($connection,"UPDATE student SET pending = '$new_pending' WHERE libraryid = '$id'");

						$book_left = $book_left - 1;

						//mysqli_query($connection,"UPDATE books SET book_left = '$book_left' WHERE id = '$bookid'");

						mysqli_query($connection,"INSERT INTO borrow(bookid,libraryid,studname,bname,dateborrow,datereturn,penalty) 
						VALUES('$bookid','$id','$fullname','$bookname','$date','$datereturn','$stat') ");

						mysqli_query($connection,"DELETE FROM reserve WHERE id = '$reserveid' ");

						echo '<div class="alert alert-success">Book Successfully Borrowed!</div>';	

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