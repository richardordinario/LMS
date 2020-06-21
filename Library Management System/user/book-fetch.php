<?php
include ("../connection.php");

$request = $_REQUEST;

$col = array('book_name','book_dis','book_cat','author','book_left','stock');

$sql = "SELECT * FROM books";

$query = mysqli_query($connection,$sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

$sql = "SELECT * FROM books WHERE 1=1";

if(!empty($request['search']['value']))
{
	$sql .= " AND (book_name LIKE '".$request['search']['value']."%' ";
	$sql .= " OR book_dis LIKE '".$request['search']['value']."%' ";
	$sql .= " OR book_cat LIKE '".$request['search']['value']."%' ";
	$sql .=  "OR author LIKE '".$request['search']['value']."%' )";
}

$query = mysqli_query($connection,$sql);
$totalData = mysqli_num_rows($query);

$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";

$query = mysqli_query($connection,$sql);
$data = array();

while($row = mysqli_fetch_array($query)) {

	$subdata = array();
	$subdata[] = $row["book_name"];
	$subdata[] = $row["book_dis"];
	$subdata[] = $row["book_cat"];
	$subdata[] = $row["author"];
	$subdata[] = $row["book_left"];
	$subdata[] = $row['stock'];
	$subdata[] = '<span name="Edit" style="float: right;" class="glyphicon glyphicon-edit btn btn-info btn-xs edit_book" id="'.$row["id"].'"></span>';
	$subdata[] = '<span name="delete" style="float: right;" class="glyphicon glyphicon-trash btn btn-danger btn-xs delete_book" id="'.$row["id"].'"></span>';
	$data[] = $subdata;
}

$json_data = array(

	"draw"				=> intval($request['draw']),
	"recordsTotal"		=> intval($totalData),
	"recordsFiltered"	=> intval($totalFilter),
	"data"				=> $data

);

echo json_encode($json_data);
?>