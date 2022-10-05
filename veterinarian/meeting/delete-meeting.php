<?php
require_once("../../include/initialize.php");
require_once('../../include/zoom-config.php');
session_start();

if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
 
$db = new DB();
$arr_token = $db->get_access_token();
$accessToken = $arr_token->access_token;
$meetingId = $_POST['meeting_id']; 

$response = $client->request('DELETE', "/v2/meetings/{$meetingId}", [
    "headers" => [
        "Authorization" => "Bearer $accessToken"
    ]
]);

$db->delete_meeting($meetingId);

?>
