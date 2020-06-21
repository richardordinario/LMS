<?php
include("../connection.php");

$request=$_REQUEST;

$col =array('libraryid','studentid','fname','lname','mi','bdate','section','ylevel','address','img');

$sql = "SELECT * FROM student";

$query = mysqli_query($connection,$sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

$sql = "SELECT * FROM student WHERE 1=1";

if(!empty($request['search']['value']))
{
	$sql.= " AND (libraryid Like '".$request['search']['value']."%' ";
	$sql.= " OR studentid Like '".$request['search']['value']."%' ";
	$sql.= " OR fname Like '".$request['search']['value']."%' ";
	$sql.= " OR mi Like '".$request['search']['value']."%' ";
	$sql.= " OR lname Like '".$request['search']['value']."%' ";
	$sql.= " OR section Like '".$request['search']['value']."%' ";
	$sql.= " OR ylevel Like '".$request['search']['value']."%' ";
	$sql.= " OR address Like '".$request['search']['value']."%' )";


}

$query = mysqli_query($connection,$sql);
$totalData = mysqli_num_rows($query);

$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";

$query = mysqli_query($connection,$sql);

$data = array();

while($row=mysqli_fetch_array($query))
{
	$fullname = $row["fname"] . " " .$row["mi"] . " " . $row["lname"];
	
	$subdata = array();
	$subdata[] = $row["libraryid"];
	$subdata[] = $row["studentid"];
	$subdata[] = $fullname;
	$subdata[] = $row["bdate"];
	$subdata[] = $row["ylevel"];
	$subdata[] = $row["section"];
	$subdata[] = $row["address"];
	$subdata[] = '<span name="View" class="glyphicon glyphicon-info-sign btn btn-primary btn-xs view_student" id="'.$row["id"].'"></span>';
	$subdata[] = '<span name="Edit" class="glyphicon glyphicon-edit btn btn-info btn-xs edit_student" id="'.$row["id"].'"></span>';
	$subdata[] = '<span name="delete" class="glyphicon glyphicon-trash btn btn-danger btn-xs delete_student" id="'.$row["id"].'"></span>';
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
