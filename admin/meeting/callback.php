<?php
require_once('../../include/zoom-config.php');
  
try {
    $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
 
    $response = $client->request('POST', '/oauth/token', [
        "headers" => [
            "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
        ],
        'form_params' => [
            "grant_type" => "authorization_code",
            "code" => $_GET['code'],
            "redirect_uri" => REDIRECT_URI
        ],
    ]);
 
    $token = json_decode($response->getBody()->getContents(), true);
 
    $db = new DB();
 
    if($db->is_table_empty()) {
        $db->update_access_token(json_encode($token));
		if(isset($_GET['code'])){
			echo '<script>window.location.href = "http://vawvetclinic.info/admin/meeting/";</script>';
		}
	}else{
      	$db->update_access_token(json_encode($token));
		if(isset($_GET['code'])){
			echo '<script>window.location.href = "http://vawvetclinic.info/admin/meeting/";</script>';
		}		
	}
    
} catch(Exception $e) {
    echo $e->getMessage();
}