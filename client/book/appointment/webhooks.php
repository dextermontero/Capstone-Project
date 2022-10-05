<?php
require_once("../../../include/initialize.php");
header('Content-Type: application/json');
$request = file_get_contents('php://input');
$payload = json_decode($request, true);
$type = $payload['data']['attributes']['type'];

if ($type == 'source.chargeable') {
	$amount = $payload['data']['attributes']['data']['attributes']['amount'];
	$id = $payload['data']['attributes']['data']['id'];
	$description = "Service Fee";
	$curl = curl_init();
	$fields = array("data" => array ("attributes" => array ("amount" => $amount, "source" => array ("id" => $id, "type" => "source"), "currency" => "PHP", "description" => $description)));
	$jsonFields = json_encode($fields);

	 curl_setopt_array($curl, [
	 CURLOPT_URL => "https://api.paymongo.com/v1/payments",
	 CURLOPT_RETURNTRANSFER => true,
	 CURLOPT_ENCODING => "",
	 CURLOPT_MAXREDIRS => 10,
	 CURLOPT_TIMEOUT => 30,
	 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	 CURLOPT_CUSTOMREQUEST => "POST",
	 CURLOPT_POSTFIELDS => $jsonFields,
	 CURLOPT_HTTPHEADER => [
	 	"Accept: application/json",
	// 	Input your encoded API keys below for authorization
	 	"Authorization: Basic c2tfdGVzdF9kVlh1cTNuZGJSa0RKNENyb3RLdzJ3aTc6" ,
	 	"Content-Type: application/json"
	 	],
	]);

	$response = curl_exec($curl);
	$payload1 = json_decode($response, true);
	$payid = $payload1['data']['id'];
	$srcid = $payload1['data']['attributes']['source']['id'];
	$sql = $conn->prepare("UPDATE billing SET ukayra_id = ? WHERE paymogo_id = ?");
	$sql->bind_param("ss", $payid, $srcid);
		if($sql->execute()){
		//Log the response
		$fp = file_put_contents('chargeable.log', $response );
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "cURL Error #:" . $err;
			//Log the response
			$fp = file_put_contents('chargeable.log', $err );
		} else {
			echo $response;
		}
	}
}
?>