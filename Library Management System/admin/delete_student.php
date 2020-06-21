<?php
include("../connection.php");

if(isset($_POST["id"]))
{
	$query = "DELETE FROM student WHERE id ='".$_POST["id"]."' ";
	if(mysqli_query($connection, $query))
	{
		echo 'Student Successfully Deleted!';
	}
}	


?>