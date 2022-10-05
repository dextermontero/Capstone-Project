<?php
require_once("../../../include/initialize.php");
require_once('../../../include/vendor/autoload.php');
$client = new \GuzzleHttp\Client();
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

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
$bill_description = "Reservation fee";
$amount = "100";
$add = "00";
$total = $amount.$add;
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

$fullname = $_POST['fullname'];
$date = date("Y-m-d", strtotime($_POST['date']));
$pet_name = $_POST['pet_name'];
$branch = $_POST['branch'];
$service = $_POST['service'];
$time = $_POST['time'];
$shows = 1;

//NOTIFICATION
$receiver = 'veterinarian';
$category = 'appointment';
$services = $service;
$icon = 'fa-calendar-alt';
$title = 'Request Appointment';
$status = ' ';
$ndate = date("Y-m-d");
$ntime = date("H:i");
$notif_status = '1';
//GET SERVICE NAME 
$ctitle = "";
$cstart = $date.' '.date("H:i", strtotime($time));
$cend = $cstart;
$csql = "SELECT service_title FROM services WHERE service_id = '$service'";
$cresult = $conn->query($csql);
if($cresult -> num_rows > 0) {
	$crow = $cresult -> fetch_assoc();
	$ctitle .= ucfirst($crow['service_title']);
}
//GET BRANCH NAME AND ADDRESS
$bname = "";
$baddress = "";
$branchsql = "SELECT name, address FROM branch WHERE branch_id = '$branch'";
$bresult = $conn->query($branchsql);
if($bresult -> num_rows > 0) {
	$brow = $bresult -> fetch_assoc();
	$bname .= ucfirst($brow['name']);
	$baddress .= $brow['address'];
}

$sql = "SELECT * FROM appointments WHERE date = '$date' AND timeslot = '$time' AND shows = '1'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	echo 'exist';
}else{
	$sql = $conn->prepare("INSERT INTO appointments(user_id, c_fullname, pet_name, date,  timeslot, service_id, branch_id, status, shows)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$sql->bind_param("sssssssss", $user, $fullname, $pet_name, $date, $time, $service, $branch, $status, $shows);
	if($sql->execute()){
		//$sl = "SELECT email FROM user_profile WHERE user_id = '$user'";
		$sl = "SELECT appointments.id, appointments.service_id, appointments.user_id, user_profile.email FROM appointments LEFT JOIN user_profile ON user_profile.user_id = appointments.user_id WHERE appointments.date = '$date' AND appointments.timeslot = '$time' AND appointments.user_id = '$user' AND appointments.archive_status = '0'";
		$sr = $conn->query($sl);
		if($sr -> num_rows > 0){
			$srow = $sr -> fetch_assoc();
			$token = $srow['id'];
			$email = $srow['email'];
			$url1 = web_root.'veterinarian/notifications/?notif_id='.$token.'&category='.$category.'&services='.$services.'&appointment_id='.$token.'&date='.$date.'&time='.$time;
			$sqlnotify = $conn->prepare("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$sqlnotify -> bind_param("sssssssssss", $token, $user, $receiver, $category, $services, $icon, $url1, $title, $ndate, $ntime, $notif_status);
			$sqlcalendar = $conn->prepare("INSERT INTO calendar_events(to_client, token, title, start_event, end_event)VALUES(?, ?, ?, ?, ?)");
			$sqlcalendar -> bind_param("sssss", $user, $token, $ctitle, $cstart, $cend);
			if($sqlnotify->execute() && $sqlcalendar->execute()){
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
				$cat = 'reservation';
				$mop = 'GCash';
				$sql = $conn->prepare("INSERT INTO billing(ukayra_id, paymogo_id, appointment_id, services, category, description, branch_id, user_id, fullname, email, date, time, mode_of_payment, amount)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$sql -> bind_param("ssssssssssssss", $reference, $paymogoid, $token, $service, $cat, $bill_description, $branch, $user, $bill_name, $email, $bill_date, $bill_time,  $mop, $amount);
				if($sql->execute()){
					echo $redirect;
				}else{
					echo 'failed';
				}
			}else{
				echo 'failed';
			}
		}
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