<?php
include("../connection.php");

if(isset($_POST["id"])){
	$id = $_POST["id"];

	date_default_timezone_set('Asia/Manila');
	$date = date('Y-m-d');
	$date1 = date_create($date);

	$data_query = mysqli_query($connection,"SELECT * FROM borrow WHERE id = '".$_POST["id"]."' "); 
	$row = mysqli_fetch_assoc($data_query);
	$retDate = $row["datereturn"];

	if($date > $retDate) {
		$date2 = date_create($retDate);

		$diff = date_diff($date1,$date2);
		$penalty = $diff->format("%a");
		$penalty = $penalty * 5;
			
		mysqli_query($connection,"UPDATE borrow SET penalty = '$penalty' WHERE id = '".$_POST["id"]."' ");
	

		$trow_query = mysqli_query($connection,"SELECT * FROM borrow WHERE id = '".$_POST["id"]."' "); 
		$trow = mysqli_fetch_assoc($trow_query);
		echo json_encode($trow);

	}else {
		$trow_query = mysqli_query($connection,"SELECT * FROM borrow WHERE id = '".$_POST["id"]."' "); 
		$trow = mysqli_fetch_assoc($trow_query);
		echo json_encode($trow);
	}

	
}
?>