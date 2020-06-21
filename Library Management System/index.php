<!DOCTYPE html>
<html>
<head>
	<title>Library Management System</title>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width = device=width, initial-scale = 1">
    <link rel="stylesheet" href="style/bootstrap-3.3.7/css/bootstrap.min.css">
    <script src="style/js/jquery-3.3.1.min.js"></script>
    <script src="style/js/jQuery.js"></script>
    <script src="style/bootstrap-3.3.7/js/bootstrap.min.js"></script>
</head>
<?php

	include("connection.php");

	session_start();

	$username = $password = "";
	$err = "";
	if(isset($_POST['btnSubmit'])) {
		if(empty($_POST["username"])) {
			$err = "Empty field not allowed!";	
		}else {
			$username = $_POST["username"];	
		}
		if(empty($_POST["password"])) {
			$err = "Empty field not allowed!";	
		}else {
			$password = $_POST["password"];	
		}
		
		if($username && $password) {
			$check_username = mysqli_query($connection, "SELECT * FROM user WHERE username = '$username'");
			$check_username_row = mysqli_num_rows($check_username);
			if($check_username_row > 0) {
				while($row = mysqli_fetch_assoc($check_username)) {
					$db_password = $row["password"];
					$db_user_type = $row["usertype"];
					if($password == $db_password) {
						if($db_user_type == "Admin") {

							$_SESSION["user"] = $username;

							echo "<script>window.alert('Successfully Login!');</script>";
							echo "<script>window.location.href='admin';</script>";
						}else {
							echo "<script>window.alert('Successfully Login!');</script>";
							echo "<script>window.location.href='user';</script>";
							$_SESSION["user"] = $username;
						}	
					}else {
						echo "<script>window.alert('Password incorrect!');</script>";
					}
				}
			}else {
				echo "<script>window.alert('Username incorrect!');</script>";
			}
		}
	}
?>
<style type="text/css">
	.form-container{
		padding: 10px 20px;
		margin-top: 10vh;
	}

</style>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 "></div>
			<div class="col-md-4 ">
				<div class="form-container">
				<h3>LMS</h3>
				<p>Library Management System</p>
				<div class="panel panel-default">
				<div class="panel-heading"style="background-color: #222;color: #fff;">Login Form</div>
				<div class="panel-body">
				<form method="POST" autocomplete="off">
			 		<div class="input-group">
			    		<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			    		<input id="username" type="text" class="form-control" name="username" placeholder="Username">
			  		</div>
			  	<br>
			  		<div class="input-group">
			    		<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
			    		<input id="password" type="password" class="form-control input-md" name="password" placeholder="Password">
			  		</div>
			  	<br>
			       
			    <button type="submit" class="btn btn-default btn-block" name="btnSubmit">Submit</button>
			   
				</form>
				</div>
				</div>

				</div>	
			</div>
			<div class="col-md-4 "></div>
		</div>
	</div>
</body>
</html>