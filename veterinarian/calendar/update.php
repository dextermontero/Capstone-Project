<?php

require_once("../../include/initialize.php");
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

$sql = $conn->prepare("UPDATE calendar_events SET title = ?, start_event = ?, end_event = ? WHERE id = ?");
$sql->bind_param("sssi", $title, $start, $end, $id);
$sql->execute();
	
?>