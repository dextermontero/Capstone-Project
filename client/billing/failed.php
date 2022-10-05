<?php
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

$sql = "SELECT paymogo_id, status, appointment_id, branch_id, email, category FROM billing WHERE user_id = '$user' ORDER BY bill_id DESC LIMIT 1";
$result = $conn->query($sql);
if($result -> num_rows > 0){
	$row = $result -> fetch_assoc();
	$payId = $row['paymogo_id'];
	$appointmentID = $row['appointment_id'];
	$email = $row['email'];
	$branchID = $row['branch_id'];
	if($row['category'] == 'reservation'){
		if($row['status'] == null || $row['status'] == ''){
			$bname = "";
			$baddress = "";
			$branchsql = "SELECT name, address FROM branch WHERE branch_id = '$branchID'";
			$bresult = $conn->query($branchsql);
			if($bresult -> num_rows > 0) {
				$brow = $bresult -> fetch_assoc();
				$bname .= ucfirst($brow['name']);
				$baddress .= $brow['address'];
			}
			$sqls = "SELECT appointments.c_fullname, appointments.date, appointments.timeslot, services.service_title, appointments.status FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id WHERE appointments.id = '$appointmentID'";
			$results = $conn->query($sqls);
			if($results -> num_rows > 0){
				$rows = $results -> fetch_assoc();
				$fullname = $rows['c_fullname'];
				$date = $rows['date'];
				$time = $rows['timeslot'];
				$service = $rows['service_title'];
				$status = $rows['status'];
				if($status == "pending"){
					
				}else{
					$asql = $conn->prepare("UPDATE appointments SET status = 'pending' WHERE id = ?");
					$asql -> bind_param("s", $appointmentID);
					if($asql->execute()){
						$newStatus = "pending";
						$sqlbill = $conn->prepare("UPDATE billing SET status = 'unpaid' WHERE paymogo_id = ?");
						$sqlbill -> bind_param("s", $payId);
						if($sqlbill->execute()){						
							appointment($fullname, $email, $date, $time, $service, $bname, $baddress, $newStatus);
						}						
					}
				}
			}			
		}
	}else{
		if($row['status'] == null || $row['status'] == ''){
			$sql = "SELECT appointments.c_fullname, appointments.pet_name, appointments.date, appointments.timeslot, services.service_title, services.service_cost, branch.name FROM appointments LEFT JOIN services ON services.service_id = appointments.service_id LEFT JOIN branch ON branch.branch_id = appointments.branch_id WHERE id = '$appointmentID'";
			$result = $conn->query($sql);
			if($result -> num_rows > 0){
				$row = $result -> fetch_assoc();
				$fullname = $row['c_fullname'];
				$petname = $row['pet_name'];
				$date = date("F d, Y", strtotime($row['date']));
				$time = date("g:i A", strtotime($row['timeslot']));
				$service = $row['service_title'];
				$branch = $row['name'];
				$todayDate = date("F d, Y");
				$todayTime = date("g:i A", time());
				$cost = $row['service_cost'];
				invoice($fullname, $email, $petname, $date, $time, $service, $branch, $todayDate, $todayTime, $cost);
			}
		}		
	}
}else {
    header("location:".web_root."client");
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
	$mail->Username   = "john.montero1109@gmail.com";
	$mail->Password   = "SECRETNOCLUE";	
	$mail->IsHTML(true);
	$mail->AddAddress($email, $fullname);
	$mail->SetFrom("vawvetclinic.not.official@gmail.com", "VAW Vet Clinic Schedule of Appointment");
	//$mail->AddReplyTo($email, $fullname);
	//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
	$mail->Subject = "Schedule of Appointment";
	$message = '
	<html>
		<body>
			<div>
				<p>Greetings <b>'.$fullname.'</b>,</p>
				This is your appointment details for the Vets at Work Veterinary Clinic
				<br><br>
				<b>Type of Service:</b> '.$service.'<br>
				<b>Day & Time:</b> '. date("F d, Y", strtotime($date)).' & '. date("g:i A", strtotime($time)) .'<br>
				<b>Status:</b> '. ucfirst($status) .'<br>
				<b>Branch:</b> '. $branch .'<br>
				<b>Venue:</b> '. $branch_address .'<br>
				<br>
				Please confirm if this works for you. Contact us for your suggestions. Thank you very much our dear fur parents!
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

function invoice($fullname, $email, $petname, $date, $time, $service, $branch, $tDate, $tTime, $cost){
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
	$mail->Subject = "Appointment Paid";
	$message = '
<html style="box-sizing: border-box;font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;-ms-overflow-style: scrollbar;-webkit-tap-highlight-color: transparent;">
	<head style="box-sizing: border-box;">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" style="box-sizing: border-box;"></script>
	</head>
	<body oncontextmenu="return false" class="snippet-body" style="box-sizing: border-box;margin: 0;font-family: -apple-system,BlinkMacSystemFont,&quot;Segoe UI&quot;,Roboto,&quot;Helvetica Neue&quot;,Arial,sans-serif,&quot;Apple Color Emoji&quot;,&quot;Segoe UI Emoji&quot;,&quot;Segoe UI Symbol&quot;;font-size: 1rem;font-weight: 400;line-height: 1.5;color: #212529;text-align: left;background-color: #f1f2f6;min-width: 992px!important;">
		<div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding" style="box-sizing: border-box;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;-ms-flex: 0 0 60.666667%;flex: 0 0 66.666667%;max-width: 66.666667%;padding: 2rem !important;">
			<div class="card" style="box-sizing: border-box;position: relative;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: none;border-radius: .25rem;margin-bottom: 30px;-webkit-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);-moz-box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);box-shadow: 0px 1px 2px 1px rgba(154, 154, 204, 0.22);">
				<div class="card-body" style="box-sizing: border-box;-ms-flex: 1 1 auto;flex: 1 1 auto;padding: 1.25rem;">
					Dear <b>'.$fullname.'</b>,
					<br>
					<br>
					Thank you for availing our services at Vets at Work Veterinary Clinic. Please find below the payment details of your payed service(s).
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
<html lang="en">
	<head>
		<title>Transaction | Vets at Work Veterinary</title>
		<?php include('../include/header.php');?>		
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			

			<!-- Main Sidebar Container -->
			<?php include('../include/sidebar.php'); ?>
			
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<a href="javascript: history.go(-4)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
							<div class="col-sm-6">
								<h1 class="m-0">Transaction</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="main-body">
 							<div class="row">								
								<div class="col-lg-12 col-12">
									<div class="card">									
										<div class="card-body">
											<div class="p-5 text-center">
												<label>
													<i class="fa fa-times-circle text-danger fa-3x"></i>&nbsp;
													<span style="font-size: 40px;" class="font-weight-normal">Transaction Incompleted</span>
												</label>
											</div>
											<div class="row justify-content-center">
												<div class="col-lg-6 col-12">
													<?php
														$sql = "SELECT billing.ukayra_id, billing.date, billing.category, billing.description, billing.time, billing.status, billing.status, billing.amount, billing.mode_of_payment, services.service_title, branch.name FROM billing INNER JOIN services ON services.service_id = billing.services LEFT JOIN branch ON branch.branch_id = billing.branch_id WHERE billing.paymogo_id = '$payId' AND billing.user_id = '$user'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															$row = $result -> fetch_assoc();
													?>
													<table class="table table-borderedless table-striped">
														<?php
															if($row['category'] == 'reservation'){
														?>
														<thead>
															<tr>
																<th colspan="2" class="text-center">Reservation Details</th>
															</tr>
														<thead>
														<tbody align="center">
															<tr>
																<td class="w-25">Created at</td>
																<td class="w-25"><?php echo date("F d, Y", strtotime($row['date'])) .' - '. date("g:i A", strtotime($row['time']));?></td>
															</tr>
															<tr>
																<td class="w-25">Message</td>
																<td class="w-25">Reservation Fee</td>
															</tr>
															<tr>
																<td class="w-25">Payment Status</td>
																<td class="w-25 text-danger"><?php echo ucfirst($row['status']); ?></td>
															</tr>
															<tr>
																<td class="w-25">Payment Method</td>
																<td class="w-25"><?php echo ucfirst($row['mode_of_payment']); ?></td>
															</tr>
															
															<tr>
																<td class="w-25">Amount</td>
																<td class="w-25">₱ <?php echo number_format($row['amount']);?></td>
															</tr>																												
														</tbody>														
														<?php
															}else{
														?>
														<thead>
															<tr>
																<th colspan="2" class="text-center">Transaction Details</th>
															</tr>
														<thead>
														<tbody align="center">
															<tr>
																<td class="w-25">Created at</td>
																<td class="w-25"><?php echo date("F d, Y", strtotime($row['date'])) .' - '. date("g:i A", strtotime($row['time']));?></td>
															</tr>
															<tr>
																<td class="w-25">Service</td>
																<td class="w-25"><?php echo $row['service_title'];?></td>
															</tr>
															<tr>
																<td class="w-25">Branch</td>
																<td class="w-25"><?php echo $row['name'];?></td>
															</tr>
															<tr>
																<td class="w-25">Payment Status</td>
																<td class="w-25 text-danger">Unpaid</td>
															</tr>
															<tr>
																<td class="w-25">Payment Method</td>
																<td class="w-25"><?php echo ucfirst($row['mode_of_payment']); ?></td>
															</tr>
															<tr>
																<td class="w-25">Message</td>
																<td class="w-25"><?php echo $row['description']; ?></td>
															</tr>
															<tr>
																<td class="w-25">Amount</td>
																<td class="w-25">₱ <?php echo number_format($row['amount']);?></td>
															</tr>																												
														</tbody>														
														<?php
															}
														?>
													</table>
													<?php
														}
													?>
													


																									
												</div>
											</div>
										</div>
									</div>
								</div>
 							</div>
 						</div>
					</div>
				</section>
			</div>
			<footer class="main-footer">
				<strong>Copyright &copy; <?php echo date("Y");?> <a href="<?php echo web_root; ?>">Vets at Work Veterinary Clinic</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b></b>
				</div>
			</footer>
		</div>

		<?php include('../include/footer.php');?>
	</body>
</html>