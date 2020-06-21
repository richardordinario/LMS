<?php
include ("../connection.php");

$request = $_REQUEST;

$col = array('category_name','category_disc');

$sql = "SELECT * FROM category";

$query = mysqli_query($connection,$sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

$sql = "SELECT * FROM category WHERE 1=1";

if(!empty($request['search']['value']))
{
	$sql .= " AND (category_name LIKE '".$request['search']['value']."%' ";
	$sql .= " OR category_disc LIKE '".$request['search']['value']."%' )";
}

$query = mysqli_query($connection,$sql);
$totalData = mysqli_num_rows($query);

$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";

$query = mysqli_query($connection,$sql);
$data = array();

while($row = mysqli_fetch_array($query)) {

	$subdata = array();
	$subdata[] = $row["category_name"];
	$subdata[] = $row["category_disc"];
	$subdata[] = '<span name="delete" style="float: right;" class="glyphicon glyphicon-edit btn btn-info btn-xs edit_cat" id="'.$row["id"].'"></span>';
	$subdata[] = '<span name="delete" style="float: right;" class="glyphicon glyphicon-trash btn btn-danger btn-xs delete_cat" id="'.$row["id"].'"></span>';
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