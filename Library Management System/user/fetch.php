<?php
include("../connection.php");

$request=$_REQUEST;

$col =array('name','username','password','usertype');

$sql = "SELECT * FROM user";

$query = mysqli_query($connection,$sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

$sql = "SELECT * FROM user WHERE 1=1";

if(!empty($request['search']['value']))
{
	$sql.= " AND (name Like '".$request['search']['value']."%' ";
	$sql.= " OR username Like '".$request['search']['value']."%' ";
	$sql.= " OR usertype Like '".$request['search']['value']."%' )";


}

$query = mysqli_query($connection,$sql);
$totalData = mysqli_num_rows($query);

$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."  ".$request['order'][0]['dir']."  LIMIT ".$request['start']."  ,".$request['length']."  ";

$query = mysqli_query($connection,$sql);

$data = array();

while($row=mysqli_fetch_array($query))
{
	$jScript = md5(rand(1,9));

	$pass = strlen($row["password"]);
	$pass .= $jScript;

	$subdata = array();
	$subdata[] = $row["name"];
	$subdata[] = $row["username"];
	$subdata[] = $pass;
	$subdata[] = $row["usertype"];
	$subdata[] = '<span name="Edit" class="glyphicon glyphicon-edit btn btn-info btn-xs edit" id="'.$row["id"].'"></span>';
	$subdata[] = '<span name="delete" class="glyphicon glyphicon-trash btn btn-danger btn-xs delete" id="'.$row["id"].'"></span>';
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
