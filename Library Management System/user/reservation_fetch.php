<?php
include ("../connection.php");
date_default_timezone_set('Asia/Manila');
$date = date('Y-m-d');

$request = $_REQUEST;

$col = array('libraryid','studname','bname','dateborrow');

$sql = "SELECT * FROM reserve";

$query = mysqli_query($connection,$sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;


$sql = "SELECT * FROM reserve WHERE 1=1";
//$sql .= "SELECT * FROM reserve WHERE 1=1";
//$sql .= "AND dateborrow < '$date'";

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
	//$subdata[] = $row['status'];
	
	$subdata[] = '<span name="E" style="float: right;" class=" btn btn-info btn-xs borrow2_book" id="'.$row["id"].'">Borrow</span>';
	$subdata[] = '<span name="" style="float: right;" class=" btn btn-danger btn-xs cancel_book" id="'.$row["id"].'">Cancel</span>';
	
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