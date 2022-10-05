<?php
require_once("../../include/initialize.php");
require_once('../../include/vendor/autoload.php');
$client = new \GuzzleHttp\Client();
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

require_once('../../PHPMailer/src/Exception.php');
require_once('../../PHPMailer/src/PHPMailer.php');
require_once('../../PHPMailer/src/SMTP.php');

$id = $_POST['id'];
$status = 'cancel';
$shows = 0;



$sql = "SELECT * FROM user_profile WHERE user_id = '$user'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$email = $row['email'];
	$sapp = "SELECT appointments.c_fullname, appointments.date, appointments.timeslot, services.service_title, appointments.branch_id FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.id = '$id'";
	$appresult = $conn->query($sapp);
	if($appresult -> num_rows > 0) {
		$approw = $appresult -> fetch_assoc();
		$fullname = $approw['c_fullname'];
		$date = date("F d, Y", strtotime($approw['date']));
		$time = $approw['timeslot'];
		$service = $approw['service_title'];
		$branch = $approw['branch_id'];
		// GET BRANCH INFORMATION
		$bname = "";
		$baddress = "";
		$branchsql = "SELECT name, address FROM branch WHERE branch_id = '$branch'";
		$bresult = $conn->query($branchsql);
		if($bresult -> num_rows > 0) {
			$brow = $bresult -> fetch_assoc();
			$bname .= ucfirst($brow['name']);
			$baddress .= $brow['address'];
		}
		$upapp = $conn->prepare("UPDATE appointments SET shows = ?, status = ? WHERE id = ?");
		$upapp -> bind_param("sss", $shows, $status, $id);
		if($upapp->execute()){
			$sql = "SELECT ukayra_id, amount FROM billing WHERE appointment_id = $id";
			$result = $conn->query($sql);
			if($result -> num_rows > 0){
				$row = $result -> fetch_assoc();
				$payid = $row['ukayra_id'];
				$amounts = $row['amount']."00";
				$amount = $amounts - ($amounts * .3);
				//$amount = 100;
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
						echo 'success';
						appointment($fullname, $email, $date, $time, $service, $bname, $baddress, $status);
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
		}
	}else{
		echo 'invalid';
	}
}else{
	echo 'invalid';
}

function appointment($fullname, $email, $date, $time, $service, $branch, $branch_address, $status){
	$from = "vawvetclinic.not.official@gmail.com";
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Mailer = "smtp";

	$mail->SMTPDebug  = 0;  
	$mail->SMTPAuth   = TRUE;
	$mail->SMTPSecure = "tls";
	$mail->Port       = 587;
	$mail->Host       = "smtp.gmail.com";
	$mail->Username   = "vawvetclinic.not.official1@gmail.com";
	$mail->Password   = "SECRETNOCLUE";	
	$mail->IsHTML(true);
	$mail->AddAddress($email, $fullname);
	$mail->SetFrom("vawvetclinic.not.official@gmail.com", "VAW Vet Clinic Cancelled of Appointment");
	//$mail->AddReplyTo($email, $fullname);
	//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
	$mail->Subject = "Cancelled of Appointment";
	$message = '
	<html>
		<body>
			<div>
				<p>Greetings <b>'.$fullname.'</b>,</p>
				You have successfully cancelled your appointment. These are the details:
				<br><br>
				<b>Type of Service:</b> '.$service.'<br>
				<b>Day & Time:</b> '. date("F d, Y", strtotime($date)).' & '. date("g:i A", strtotime($time)) .'<br>
				<b>Status:</b> '. ucfirst($status) .'<br>
				<b>Branch:</b> '. $branch .'<br>
				<b>Venue:</b> '. $branch_address .'<br>
				<br>
				If you wish to schedule a new appointment, please go to our website @vawvetclinic.info or contact us for other inquiries. Thank you very much our dear fur parents!
				<br>
				<br>
				<b>Thank you</b>,<br>
				Vets at Work Veterinary Clinic
			</div>
		</body>
	</html>	
	';
	
	$mail->MsgHTML($message); 
	if(!$mail->Send()) {
		
	} else {
		
	}	
}
?>