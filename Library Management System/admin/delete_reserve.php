<?php
include("../connection.php");

date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');

$query = mysqli_query($connection,"SELECT * FROM reserve");

if(mysqli_num_rows($query) > 0)
{
	while($row = mysqli_fetch_assoc($query))
	{
		$date_reserve = $row["dateborrow"];
		$reserve_id = $row["id"];
		$stud_card = $row["libraryid"];
		$book_id = $row["bookid"];

		if($date > $date_reserve)
		{
			$student = mysqli_query($connection,"SELECT * FROM student WHERE libraryid = '$stud_card'");
		
			$student_row = mysqli_fetch_assoc($student);
			$pending = $student_row["pending"];

			$pending = $pending - 1;

			mysqli_query($connection,"UPDATE student SET pending = '$pending' WHERE libraryid = '$stud_card' ");

			$book = mysqli_query($connection,"SELECT * FROM books WHERE id = '$book_id' ");
			$book_row = mysqli_fetch_assoc($book);
			$left = $book_row["book_left"];

			$left = $left + 1;

			mysqli_query($connection,"UPDATE books SET book_left = '$left' WHERE id = '$book_id' ");

			mysqli_query($connection,"DELETE FROM reserve WHERE id = '$reserve_id' ");
		}
		else
		{

		}
	}
} 
else
{

}


?>