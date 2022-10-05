<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}

use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

require_once('../../../PHPMailer/src/Exception.php');
require_once('../../../PHPMailer/src/PHPMailer.php');
require_once('../../../PHPMailer/src/SMTP.php');

$id = $_POST['id'];

//NOTIFICATION
$category = 'invoice';
$icon = 'fa-file-invoice';
$title = 'Paid Invoice';
$ndate = date("Y-m-d");
$ntime = date("H:i");
$notif_status = '1';

$sql = "SELECT appointments.*, services.service_cost, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE appointments.id = '$id'";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$refID = time();
	$appID = $row['id'];
	$petname = $row['pet_name'];
	$service = $row['service_id'];
	$category = 'service';
	$description = 'Service Fee';
	$branch = $row['branch_id'];
	$branchName = $row['name'];
	$userID = $row['user_id'];
	$fullname = $row['c_fullname'];
	$date = date("F d, Y", strtotime($row['date']));
	$time = $row['timeslot'];
	$tdate = date("Y-m-d");
	$ttime = date("H:i:s");
	$mop = 'Over the counter';
	$cost = $row['service_cost'];
	$status = 'paid';
	$getEmail = "SELECT email FROM user_profile WHERE user_id = '$userID'";
	$getRes = $conn->query($getEmail);
	if($getRes -> num_rows > 0){
		$getRow = $getRes -> fetch_assoc();
		$email = $getRow['email'];
		$insert = $conn->prepare("INSERT INTO billing(ukayra_id, appointment_id, services, category, description, branch_id, user_id, fullname, email, date, time, mode_of_payment, amount, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$insert -> bind_param("ssssssssssssss", $refID, $appID, $service, $category, $description, $branch, $userID, $fullname, $email, $tdate, $ttime, $mop, $cost, $status);
		if($insert->execute()){
			$update = $conn->prepare("UPDATE appointments SET payment_status = ?, status = 'done' WHERE id = ?");
			$update -> bind_param("ss", $status, $appID);
			if($update->execute()){
				$url = web_root.'client/payments/invoice/view/?view='.$appID;
				$sqlnotify = $conn->prepare("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
				$sqlnotify -> bind_param("sssssssssss", $appID, $user, $userID, $category, $service, $icon, $url, $title, $ndate, $ntime, $notif_status);
				if($sqlnotify->execute()){
					echo 'success';
					appointment($fullname, $email, $petname, $date, $time, $service, $branchName, $tdate, $ttime, $cost);
				}else{
					echo 'failed';
				}
			}
		}else{
			echo 'invalid';
		}
	}
}else{
	echo 'invalid';
}


function appointment($fullname, $email, $petname, $date, $time, $service, $branch, $tDate, $tTime, $cost){
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
	$mail->SetFrom("vawvetclinic.not.official@gmail.com", "VAW Vet Clinic Appointment Invoice");
	//$mail->AddReplyTo($email, $fullname);
	//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
	$mail->Subject = "Appointment Invoice";
	$message = '
<html style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;-ms-overflow-style: scrollbar;-webkit-tap-highlight-color: transparent;">
	<head style="box-sizing: border-box;">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" style="box-sizing: border-box;"></script>
	</head>
	<body oncontextmenu="return false" class="snippet-body" style="box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #f1f2f6;min-width: 992px!important;">
		<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding" style="box-sizing: border-box;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 60.666667%;flex: 0 0 66.666667%;max-width: 66.666667%;padding: 2rem !important;">
			<div class="card" style="box-sizing: border-box;position: relative;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: none;border-radius: .25rem;margin-bottom: 30px;-webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);-moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);">
				<div class="card-body" style="box-sizing: border-box;-ms-flex: 1 1 auto;flex: 1 1 auto;padding: 1.25rem;">
					You have successfully availed service(s) in Vets at Work Veterinary Clinic. These are the following details of your availed service:
					<div class="row mb-4" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;margin-bottom: 1.5rem!important;">
						<div class="col-sm-6" style="box-sizing: border-box;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;">
							<br style="box-sizing: border-box;">
							<h3 class="text-dark mb-1" style="box-sizing: border-box;margin-top: 0;margin-bottom: .25rem!important;font-family: inherit;font-weight: 500;line-height: 1.2;color: #3d405c !important;font-size: 20px;orphans: 3;widows: 3;page-break-after: avoid;">Invoice Date/Time</h3>
							<div style="box-sizing: border-box;white-space: nowrap;">'.$tDate.' - '.$tTime.'</div>
						</div>
						<div class="col-sm-6 " style="box-sizing: border-box;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 50%;flex: 0 0 50%;max-width: 50%;">
							<br style="box-sizing: border-box;">
							<h3 class="text-dark mb-1" style="box-sizing: border-box;margin-top: 0;margin-bottom: .25rem!important;font-family: inherit;font-weight: 500;line-height: 1.2;color: #3d405c !important;font-size: 20px;orphans: 3;widows: 3;page-break-after: avoid;">Client</h3>
							<div style="box-sizing: border-box;white-space: nowrap;">Vets at Work Veterinary Clinic</div>
						</div>
					</div>
					<div class="table-responsive-sm" style="box-sizing: border-box;">
						<table class="table table-striped" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;max-width: 100%;margin-bottom: 1rem;background-color: transparent;">
							<thead style="box-sizing: border-box;display: table-header-group;">
								<tr style="box-sizing: border-box;page-break-inside: avoid;">
									<th class="center" style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">Service</th>
									<th style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">Pet Name</th>
									<th style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">Branch</th>
									<th class="right" style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">Date</th>
									<th class="center" style="box-sizing: border-box;text-align: inherit;padding: .75rem;vertical-align: bottom;border-top: 1px solid #dee2e6;border-bottom: 2px solid #dee2e6;background-color: #fff!important;">Time</th>
								</tr>
							</thead>
							<tbody style="box-sizing: border-box;">
								<tr style="box-sizing: border-box;page-break-inside: avoid;">
									<td class="center" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">'.ucfirst($service).'</td>
									<td class="left strong" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">'.$petname.'</td>
									<td class="left" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">'.$branch.'</td>
									<td class="right" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">'.$date.'</td>
									<td class="center" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">'.$time.'</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="row" style="box-sizing: border-box;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;">
						<div class="col-lg-4 col-sm-5" style="box-sizing: border-box;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;">
						</div>
						<div class="col-lg-4 col-sm-5 ml-auto" style="box-sizing: border-box;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;margin-left: auto!important;">
							<table class="table table-clear" style="box-sizing: border-box;border-collapse: collapse!important;width: 100%;max-width: 100%;margin-bottom: 1rem;background-color: transparent;">
								<tbody style="box-sizing: border-box;">
									<tr style="box-sizing: border-box;page-break-inside: avoid;">
										<td class="left" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">
										<strong class="text-dark" style="box-sizing: border-box;font-weight: bolder;color: #3d405c !important;">Total</strong> </td>
										<td class="right" style="box-sizing: border-box;padding: .75rem;vertical-align: top;border-top: 1px solid #dee2e6;background-color: #fff!important;">
										<strong class="text-dark" style="box-sizing: border-box;font-weight: bolder;color: #3d405c !important;">₱ '.$cost.'</strong>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<b>Regards</b>,<br>
			Vets at Work Veterinary Clinic
		</div>
		<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js" style="box-sizing: border-box;"></script>
		<script type="text/javascript" src="" style="box-sizing: border-box;"></script>
		<script type="text/javascript" src="" style="box-sizing: border-box;"></script>
		<script type="text/Javascript" style="box-sizing: border-box;"></script>
	</body>
</html>

	';
	
	$mail->MsgHTML($message); 
	if(!$mail->Send()) {
		
	} else {
		
	}	
}
?>