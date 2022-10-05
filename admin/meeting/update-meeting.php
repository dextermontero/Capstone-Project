<?php
require_once("../../include/initialize.php");
require_once('../../include/zoom-config.php');
session_start();
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
} 
$meeting_id = $_POST['meeting_id'];
$topic = verify($_POST['topic']);
$date = $_POST['date'];
$start = $_POST['time'];
$time = date('H:i:s', strtotime($start));  
$pass = $_POST['pass'];   
$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
$db = new DB();
$arr_token = $db->get_access_token();
$accessToken = $arr_token->access_token;
$response = $client->request('PATCH', "/v2/meetings/{$meeting_id}", [
    "headers" => [
        "Authorization" => "Bearer $accessToken"
    ],
    'json' => [
        "topic" => $topic,
        "type" => 2,
        "start_time" => $date."T".$time,
        "duration" => "2592000",// 1 day
        "password" => "$pass"
    ],
]);
if (204 == $response->getStatusCode()) {
	$db->update_meetings($meeting_id, $topic, $date, $time);
}
function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>