<?php
require_once("../../include/initialize.php");
require_once('../../include/vendor/autoload.php');
$client = new \GuzzleHttp\Client();
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$id = $_POST['id'];

$sql = "SELECT ukayra_id, amount FROM billing WHERE appointment_id = $id";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$payid = $row['ukayra_id'];
	$amounts = $row['amount']."00";
	//$amount = $amounts - ($amounts * .3);
	$amount = 100;
	try {
		$response = $client->request('POST', 'https://api.paymongo.com/refunds', [
			'body' => '{
				"data":{
					"attributes":{
					  "amount":'.$amount.',
					  "payment_id": "'.$payid.'",
					  "reason":"requested_by_customer",
					  "notes":"Cancel Reservation"
					}
				}
			}',
			'headers' => [
				'Accept' => 'application/json',
				'Authorization' => 'Basic c2tfdGVzdF9kVlh1cTNuZGJSa0RKNENyb3RLdzJ3aTc6',
				'Content-Type' => 'application/json',
			],
		]);	
		$data = json_decode($response->getBody(), true);
		$pay_id = $data['data']['attributes']['payment_id'];
		$updateBill = $conn->prepare("UPDATE billing SET status = 'refund' WHERE ukayra_id = ?");
		$updateBill->bind_param("s", $pay_id);
		if($updateBill->execute()){
			$updateAppointment = $conn->prepare("UPDATE appointments SET status = 'refund' WHERE id = ?");
			$updateAppointment->bind_param("s", $id);
			if($updateAppointment->execute()){
				echo 'success';
			}else{
				echo 'failed';
			}
		}
	} catch (\GuzzleHttp\Exception\RequestException $e) {
		echo 'invalid';	
		/*if ($e->hasResponse()) {
			$response = $e->getResponse();
			//var_dump($response->getStatusCode()); // HTTP status code;
			//var_dump($response->getReasonPhrase()); // Response message;
			var_dump((string) $response->getBody()); // Body, normally it is JSON;
			//var_dump(json_decode((string) $response->getBody())); // Body as the decoded JSON;
			//var_dump($response->getHeaders()); // Headers array;
			//var_dump($response->hasHeader('Content-Type')); // Is the header presented?
			//var_dump($response->getHeader('Content-Type')[0]); // Concrete header value;
		}*/	
	}catch( Exception $e){
		echo 'invalid';	
	}
}
?>