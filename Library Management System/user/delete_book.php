<?php
include("../connection.php");

if(isset($_POST["id"]))
{
	$query = "DELETE FROM books WHERE id ='".$_POST["id"]."' ";
	if(mysqli_query($connection, $query))
	{
		echo 'Book Successfully Deleted!';
	}
}	


?>