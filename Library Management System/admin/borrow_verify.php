<?php
include("../connection.php");

if(isset($_POST["verify"]))
{
	$data = mysqli_query($connection,"SELECT * FROM student WHERE id = '".$_POST["verify"]."' "); 
	$row = mysqli_fetch_assoc($data);
	
	$check = mysqli_num_rows($data);

	if($check > 0) {
		echo json_encode($row);	
	}
	else 
	{
		echo json_encode("");
	}
	
}

?>