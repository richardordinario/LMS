<?php
	include("../connection.php");
	$target_dir = "../image";	

	date_default_timezone_set('Asia/Manila');
	$date = date('Y');
	$time = time('h:i:sa');

	$fname = $_POST['fname'];
	$mi = $_POST['mi'];
	$lname = $_POST['lname'];
	$studid = $_POST['studid'];
	$address = $_POST['address'];
	$bdate = $_POST['bdate'];
	$ylevel = $_POST['ylevel'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$section = $_POST['section'];
	$id = $_POST['dbid'];

	$fname = strtoupper($fname);
	$mi = strtoupper($mi);
	$lname = strtoupper($lname);
	$address = strtoupper($address);
	$ylevel = strtoupper($ylevel);
	$section = strtoupper($section);

	if($_POST["action"]=="insert")
	{

		

		$query = mysqli_query($connection,"SELECT * FROM student");
		$count = mysqli_num_rows($query);
		$count = $count + 1001;
		$libraryid = $date . "-" . $count;

		$target_file = $target_dir . "/" . basename($_FILES["image"]["name"]);
		
		if(move_uploaded_file($_FILES["image"]["tmp_name"],$target_file)) {
			
			mysqli_query($connection,"INSERT INTO student (libraryid,studentid,fname,lname,mi,bdate,section,ylevel,address,contact,gender,img)VALUES('$libraryid','$studid','$fname','$lname','$mi','$bdate','$section','$ylevel','$address','$contact','$gender','$target_file')");
			echo "Student Record Successfully Saved!";

		}
	}else if($_POST["action"]=="update"){
		
		if(empty($_FILES["image"])) {
			$query = mysqli_query($connection,"UPDATE student SET
				 studentid = '$studid',
				 fname = '$fname',
				 lname = '$lname',
				 mi = '$mi',
				 bdate = '$bdate',
				 section = '$section',
				 ylevel = '$ylevel',
				 address = '$address',
				 contact= '$contact',
				 gender = '$gender' WHERE id = '$id'");
			
				echo "Student Record Successfully Update!";
		}
		else
		{
			$target_file = $target_dir . "/" . basename($_FILES["image"]["name"]);
			$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

			if($fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "gif") 
			{
				$query = mysqli_query($connection,"UPDATE student SET
				 studentid = '$studid',
				 fname = '$fname',
				 lname = '$lname',
				 mi = '$mi',
				 bdate = '$bdate',
				 section = '$section',
				 ylevel = '$ylevel',
				 address = '$address',
				 contact= '$contact',
				 gender = '$gender' WHERE id = '$id'");
			
				echo "Student Record Successfully Update!";
			}
			else
			{
				if($fileType != "jpg" && $fileType != "jpeg" && $fileType != "png" && $fileType != "gif") 
				{
					echo "Invalid Image Type";
				}
				else
				{
					if(move_uploaded_file($_FILES["image"]["tmp_name"],$target_file)) 
				{
					$query = mysqli_query($connection,"UPDATE student SET
					 studentid = '$studid',
					 fname = '$fname',
					 lname = '$lname',
					 mi = '$mi',
					 bdate = '$bdate',
					 section = '$section',
					 ylevel = '$ylevel',
					 address = '$address',
					 contact= '$contact',
					 gender = '$gender',
					 img = '$target_file' WHERE id = '$id'");
				
					echo "Student Record Successfully Update!";
				}
				}
				
			}
		}

		

		
	}
?>