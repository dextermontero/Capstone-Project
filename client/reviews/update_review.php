<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$id = $_POST['id'];
$description = verify($_POST['description']);

$sql = $conn->prepare("UPDATE reviews SET review_description = ? WHERE review_id = ?");
$sql -> bind_param("ss", $description, $id);
if($sql->execute()){
	echo 'success';
}else{
	echo 'failed';
}


function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>