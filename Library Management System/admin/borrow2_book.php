
<?php
include("../connection.php");
if(isset($_POST["id"])){
	$data_query = mysqli_query($connection,"SELECT * FROM reserve WHERE id = '".$_POST["id"]."' "); 
	$row = mysqli_fetch_assoc($data_query);
	echo json_encode($row);
}
?>

