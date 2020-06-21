<?php
include("../connection.php");

$cat_name = $_POST["book_category"];
$cat_dis = $_POST["book_desc"];
$id = $_POST["cat_id"];

if($id == "")
{

	if($cat_name && $cat_dis)
	{
		mysqli_query($connection,"INSERT INTO category(category_name,category_disc) 
		VALUES('$cat_name','$cat_dis') ");
		echo 'Category Successfully Save!';
	}	
}
else
{

	mysqli_query($connection,"UPDATE category SET

		category_name = '$cat_name',
		category_disc = '$cat_dis'
		WHERE id = '$id'
		
	");
	echo 'Category Successfully Updated!';
}


?>