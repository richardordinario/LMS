<?php 
include("../connection.php");

	$id = $_POST["id"];
	$name = $_POST["name"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$retypepassword = $_POST["retype-password"];
	$usertype = $_POST["user"];

	if($id == "")
	{	
		if($name && $username && $password && $usertype)
		{
			mysqli_query($connection,"INSERT INTO user(name,username,password,usertype) VALUES('$name','$username','$password','$usertype')");
			echo 'Data Successfully Save!';
		}
	}
	else
	{
		mysqli_query($connection,"UPDATE user SET

			name = '$name',
			username = '$username',
			password = '$password',
			usertype = '$usertype'
			WHERE id = '$id'
		");
		echo 'Data Successfully Updated!';
	}

?>