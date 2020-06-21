<?php
include("../connection.php");

if(isset($_POST["id"]))
{
	$data = mysqli_query($connection,"SELECT * FROM student WHERE id = '".$_POST["id"]."' "); 
	$row = mysqli_fetch_assoc($data);
	echo json_encode($row);
}

?>