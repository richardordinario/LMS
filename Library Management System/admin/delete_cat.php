<?php
include("../connection.php");

if(isset($_POST["id"]))
{
	$query = "DELETE FROM category WHERE id ='".$_POST["id"]."' ";
	if(mysqli_query($connection, $query))
	{
		echo 'Category Successfully Deleted!';
	}
}	


?>