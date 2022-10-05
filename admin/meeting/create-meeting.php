<?php
require_once("../../include/initialize.php");
require_once('../../include/zoom-config.php');
session_start();

if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$to = $_POST['id'];
$randomCode = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+"), 0, 5);
$password = $randomCode;
$topic = verify($_POST['topic']);
$date = $_POST['date'];
$start = $_POST['start'];
$time = date('H:i:s', strtotime($start));

function create_meeting($user, $to, $topic, $date, $time, $pass) {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
	
    $db = new DB();
    $arr_token = $db->get_access_token();
    $accessToken = $arr_token->access_token;
    try {
        // if you have userid of user than change it with me in url
        $response = $client->request('POST', '/v2/users/me/meetings', [
            "headers" => [
                "Authorization" => "Bearer $accessToken"
            ],
            'json' => [
                "topic" => $topic,
                "type" => 2,                              
                "start_time" => $date."T".$time,    // meeting start time
                "duration" => "2592000",             // 30 minutes
                "password" => "$pass"                // meeting password
            ],
        ]);
 
        $data = json_decode($response->getBody());
		$url = $data->join_url;
		$pass = $data->password;
		$meeting_id = $data->id;
		$db->save_meetings($user, $to, $topic, $meeting_id, $url, $pass, $date, $time);
    } catch(Exception $e) {
        if( 401 == $e->getCode() ) {
            $refresh_token = $db->get_refersh_token();
 
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "refresh_token",
                    "refresh_token" => $refresh_token
                ],
            ]);
            $db->update_access_token($response->getBody());
 
            create_meeting();
        } else {
            echo $e->getMessage();
        }
    }
}

if($topic != '' && $date != '' && $start != ''){
	create_meeting($user, $to, $topic, $date, $time, $password);
}else{
	header('Location: index.php');
}

function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
