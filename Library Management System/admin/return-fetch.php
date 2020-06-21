<?php
include ("../connection.php");

$request = $_REQUEST;

$col = array('libraryid','studname','bname','dateborrow','datereturn');

$sql = "SELECT * FROM borrow";

$query = mysqli_query($connection,$sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

$sql = "SELECT * FROM borrow WHERE 1=1";

if(!empty($request['search']['value']))
{
	$sql .= " AND (libraryid LIKE '".$request['search']['value']."%' ";
	$sql .= " OR studname LIKE '".$request['search']['value']."%' ";
	$sql .= " OR bname LIKE '".$request['search']['value']."%' ";
	$sql .=  "OR dateborrow LIKE '".$request['search']['value']."%' )";

}

$query = mysqli_query($connection,$sql);
$totalData = mysqli_num_rows($query);

$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";

$query = mysqli_query($connection,$sql);
$data = array();

while($row = mysqli_fetch_array($query)) {

	$subdata = array();
	//$subdata[] = '<input type="checkbox" value="'.$row["id"].'">';
	$subdata[] = $row["libraryid"];
	$subdata[] = $row["studname"];
	$subdata[] = $row["bname"];
	$subdata[] = '<span style="color:green;font-weight:bold;">'.$row["dateborrow"].'</span>';
	$subdata[] =  '<span style="color:red;font-weight:bold;">'.$row["datereturn"].'</span>';
	//$subdata[] = $row['status'];
	
	$subdata[] = '<span name="Edit" style="float: right;" class=" btn btn-info btn-sm return_book" id="'.$row["id"].'">Return</span>';
	
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