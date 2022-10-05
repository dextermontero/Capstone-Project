<?php
header('Content-Type: application/json');
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] !== 'client' || empty($_SESSION['login_id'])){
	header("location: ../../");
}else{
	$user = $_SESSION['login_id'];
}


$data = array();
$result =  mysqli_query($conn, "SELECT * FROM calendar_events WHERE to_client = '$user' AND archive_status = '0'");

while($row = mysqli_fetch_array($result))
{        
	$datas = array(
		'id'   => $row["id"],
		'title'   => $row["title"],
		'start'   => $row["start_event"],
		'end'   => $row["end_event"]
	);
	array_push($data, $datas);        
}
echo json_encode($data);

?>