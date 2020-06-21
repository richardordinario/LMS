<?php
include("../connection.php");

if(isset($_POST["id"]))
{

	$query = "DELETE FROM user WHERE id ='".$_POST["id"]."' ";
	if(mysqli_query($connection, $query))
	{
		echo 'Data Successfully Deleted!';
	}
}	


?>