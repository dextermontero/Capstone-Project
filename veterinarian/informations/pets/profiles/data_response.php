<?php
require_once("../../../../include/initialize.php");

$sql = "SELECT COUNT(*) as 'total_notify' FROM notification WHERE receiver = 'veterinarian' AND status = '1' AND archive_status = '0'";
$result = $conn->query($sql);
$data = 0;
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	if($row['total_notify'] > 10){
		$data = '10 +';
	}else{
		$data = $row['total_notify'];
	}
}else{
	$data = 0;
}
echo json_encode($data);
?>