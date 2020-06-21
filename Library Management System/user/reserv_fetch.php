<?php
include("../connection.php");
$output ='';
$sql="SELECT * FROM books WHERE  book_name LIKE '%".$_POST["search"]."%' ";
$result =mysqli_query($connection,$sql);
if(mysqli_num_rows($result) > 0)
{
	$output .= '<h4>Search Result</h4>';
	$output .= '
			<div class="table-responsive">
			<table class="table table-bordered table-striped">
				<tr>
					<th>Book Name</th>
					<th>Category</th>
					<th>Author</th>
					<th>Left</th>
					<th>Stock</th>
					<th>Action</th>
				</tr>
			
	';

	while($row = mysqli_fetch_assoc($result)) 
	{
		$output .= '
			<tr>
			<td>'.$row["book_name"].'</td>
			<td>'.$row["book_cat"].'</td>
			<td>'.$row["author"].'</td>
			<td>'.$row["book_left"].'</td>
			<td>'.$row["stock"].'</td>
			<td><span class="btn btn-info btn-sm reserve_btn" id="'.$row["id"].'">Reserve</span></td>
			</tr>
		';
	}
	echo $output;
}
else
{
	echo "No Data Found!";
}
?>