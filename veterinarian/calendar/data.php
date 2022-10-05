<?php
require_once("../../include/initialize.php");
header('Content-Type: application/json');
$data = array();
$result =  mysqli_query($conn, "SELECT * FROM calendar_events ORDER BY id");

while($row = mysqli_fetch_array($result))
{        
	$datas = array(
		'id'   => $row["id"],
		'to_client'   => $row["to_client"],
		'title'   => $row["title"],
		'start'   => $row["start_event"],
		'end'   => $row["end_event"]
	);
	array_push($data, $datas);        
}
echo json_encode($data);

?>