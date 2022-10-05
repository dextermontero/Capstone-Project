<?php
require_once("../../../../include/initialize.php");
require_once('../../../../include/vendor/autoload.php');
$client = new \GuzzleHttp\Client();
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../../");
}

$id = $_POST['id'];
$category = 'service';
$mop = 'GCash';

// BILLING
$bill_email = "";
$bill_name = "";
$bill_phone = "";
$bill_address1 = "";
$bill_address2 = "";
$bill_city = ip_visitor_country()['geoplugin_city'];
$bill_states = ip_visitor_country()['geoplugin_region'];
$bill_postal = "1108";
$bill_country = ip_visitor_country()['geoplugin_countryName'];
$bill_date = date("Y-m-d");
$bill_time = date("H:i:s");
$bill_description = "Service Fee";


// GET BILLING INFORMATION
$billing = "SELECT * FROM user_profile WHERE user_id = '$user'";
$billresult = $conn->query($billing);
if($billresult -> num_rows > 0){
	$billrow = $billresult -> fetch_assoc();
	$bill_email .= $billrow['email'];
	$bill_name .= ucfirst($billrow['firstname']) .' '. ucfirst($billrow['lastname']);
	$bill_phone .= $billrow['contact_number'];
	$bill_address1 .= $billrow['address'];
	$bill_address2 .= "";
}

// GET SERVICE COST
$getCost = "SELECT appointments.id, appointments.branch_id, services.service_id, services.service_cost FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.id = '$id'";
$getResult = $conn->query($getCost);
if($getResult -> num_rows > 0){
	$getRow = $getResult -> fetch_assoc();
	$amount = $getRow['service_cost'];
	$service = $getRow['service_id'];
	$branch = $getRow['branch_id'];
	$add = "00";
	$total = $amount.$add;
	$response = $client->request('POST', 'https://api.paymongo.com/v1/sources', [
		'body' => '{
			"data":{
				"attributes":{
					"amount":'.$total.',
					"redirect":{
						"success":"http://vawvetclinic.info/client/billing/success.php",
									"failed":"http://vawvetclinic.info/client/billing/failed.php"
					},
					"type":"gcash",
					"currency":"PHP"
				}
			}
		}',
		'headers' => [
			'Accept' => 'application/json',
			'Authorization' => 'Basic c2tfdGVzdF9kVlh1cTNuZGJSa0RKNENyb3RLdzJ3aTc6',
			'Content-Type' => 'application/json',
		],
	]);
	$data = json_decode($response->getBody() , true); // returns an array
	$redirect = $data['data']['attributes']['redirect']['checkout_url'];
	$reference = $data['data']['attributes']['created_at'];
	$paymogoid = $data['data']['id'];
	$sql = $conn->prepare("INSERT INTO billing(ukayra_id, paymogo_id, appointment_id, services, category, description, branch_id, user_id, fullname, email, date, time, mode_of_payment, amount)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$sql -> bind_param("ssssssssssssss", $reference, $paymogoid, $id, $service, $category, $bill_description, $branch, $user, $bill_name, $bill_email, $bill_date, $bill_time, $mop, $amount);
	if($sql->execute()){
		echo $redirect;
	}else{
		echo 'failed';
	}
}

function ip_visitor_country() {
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $country  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    }else {
        $ip = $remote;
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=".$ip);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $ip_data_in = curl_exec($ch); // string
    curl_close($ch);

    $ip_data = json_decode($ip_data_in,true);
    $ip_data = str_replace('&quot;', '"', $ip_data); // for PHP 5.2 see stackoverflow.com/questions/3110487/
    return $ip_data;
}
?>