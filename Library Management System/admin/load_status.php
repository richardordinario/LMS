<?php

include("../connection.php");

date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');

$check = mysqli_query($connection,"SELECT * FROM borrow WHERE datereturn < '$date' ");

while($row = mysqli_fetch_assoc($check)) {
	
	$stat = "Penalty";
	$id = $row["id"];

	mysqli_query($connection,"UPDATE borrow SET status = '$stat' WHERE id ='$id'");


}
?>