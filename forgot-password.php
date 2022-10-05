<?php
require_once('./include/initialize.php');
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\Exception;

require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');

$email = verify($_POST['email']);

$randomCode = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
$genPassword = $randomCode;
$ciphering = "AES-128-CTR";
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;	
$encryption_iv = '1234567891011121';
$encryption_key = "+ObRG)moziZfrceSKxqs!T#BkMhavJ&gjpF%CY(N*DEPLAWdwVI@uUQl^yHtX_n";
$encryption = openssl_encrypt($genPassword, $ciphering, $encryption_key, $options, $encryption_iv);
$hashpass = $encryption;
$date = date("Y-m-d");
$time = date("H:i:s");


$a = "SELECT uid, roles, email FROM login_tbl WHERE email = '$email'";
$b = $conn->query($a);
if($b -> num_rows > 0){
	$c = $b -> fetch_assoc();
	$uid = $c['uid'];
	if($c['roles'] == 'client' && $c['email'] == $email){
		$sql = "SELECT user_id, firstname, lastname, email FROM user_profile WHERE user_id = '$uid'";
		$result = $conn->query($sql);
		if($result -> num_rows > 0){
			$row = $result -> fetch_assoc();
			$id = $row['user_id'];
			$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
			$email = $row['email'];
			$sqlup = $conn->prepare("UPDATE login_tbl SET password = ? WHERE email = ? AND uid = ?");
			$sqlup->bind_param("sss", $hashpass, $email, $id);
			if($sqlup->execute()){
				$activity = "<b>$fullname</b> requesting to reset password";
				$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
				$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
				if($ab->execute()){
					resetPassword($fullname, $email, $genPassword);
					echo 'success';
				}else {
					echo 'failed';
				}				
			}
		}
	}elseif($c['roles'] == 'administrator' && $c['email'] == $email || $c['roles'] == 'superadmin' && $c['email'] == $email){
		$sql = "SELECT admin_id, firstname, lastname, email FROM admin_profile WHERE admin_id = '$uid'";
		$result = $conn->query($sql);
		if($result -> num_rows > 0){
			$row = $result -> fetch_assoc();
			$id = $row['admin_id'];
			$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
			$email = $row['email'];
			$sqlup = $conn->prepare("UPDATE login_tbl SET password = ? WHERE email = ? AND uid = ?");
			$sqlup->bind_param("sss", $hashpass, $email, $id);
			if($sqlup->execute()){
				$activity = "<b>$fullname</b> requesting to reset password";
				$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
				$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
				if($ab->execute()){
					resetPassword($fullname, $email, $genPassword);
					echo 'success';
				}else {
					echo 'failed';
				}				
			}
		}
	}elseif($c['roles'] == 'veterinarian' && $c['email'] == $email){
		$sql = "SELECT vet_id, firstname, lastname, email FROM vet_profile WHERE vet_id = '$uid'";
		$result = $conn->query($sql);
		if($result -> num_rows > 0){
			$row = $result -> fetch_assoc();
			$id = $row['vet_id'];
			$fullname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
			$email = $row['email'];
			$sqlup = $conn->prepare("UPDATE login_tbl SET password = ? WHERE email = ? AND uid = ?");
			$sqlup->bind_param("sss", $hashpass, $email, $id);
			if($sqlup->execute()){
				$activity = "<b>$fullname</b> requesting to reset password";
				$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
				$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
				if($ab->execute()){
					resetPassword($fullname, $email, $genPassword);
					echo 'success';
				}else {
					echo 'failed';
				}				
			}
		}
	}else{
		echo 'no_email';
	}
	
}

function resetPassword($fullname, $email, $genPassword){
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
	$mail->SetFrom("vawvetclinic.not.official@gmail.com", "VAW Clinic Reset Password");
	//$mail->AddReplyTo($email, $fullname);
	//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
	$mail->Subject = "Reset Password";
	$message = '
	<html>
		<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">   
			<table style="display:none!important;">
				<tr>
					<td>
						<div style="overflow:hidden;display:none;font-size:1px;color:#ffffff;line-height:1px;font-family:Arial;maxheight:0px;max-width:0px;opacity:0;">
							Welcome to Vets at Work Veterinary Clinic
						</div>
					</td>
				</tr>
			</table>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff">
				<tr>
					<td align="center">
						<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
							<tr>
								<td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
							</tr>
							<tr>
								<td align="center">
									<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
										<tr>
											<td align="center" height="70" style="height:70px;">
												<a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="100" border="0" style="display: block; width: 100px;" src="http://vawvetclinic.info/dist/img/login-logo.png" alt="" /></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
				<tr>
					<td align="center">
						<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
							<tr>
								<td align="center" style="color: #343434; font-size: 24px; font-family: Quicksand, Calibri, sans-serif; font-weight:700;letter-spacing: 3px; line-height: 35px;"
									class="main-header">
									<div style="line-height: 35px">
										Welcome to <span style="color: #f08a17;">Vets at Work Veterinary Clinic</span>
									</div>
								</td>
							</tr>
							<tr>
								<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
							</tr>
							<tr>
								<td align="center">
									<table border="0" width="40" align="center" cellpadding="0" cellspacing="0" bgcolor="eeeeee">
										<tr>
											<td height="2" style="font-size: 2px; line-height: 2px;">&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
							</tr>
							<tr>
								<td align="left">
									<table border="0" width="590" align="center" cellpadding="0" cellspacing="0" class="container590">
										<tr>
											<td align="left" style="color: #888888; font-size: 16px; font-family: Work Sans, Calibri, sans-serif; line-height: 24px;">
												<!-- section text ======-->
												<p style="line-height: 24px; margin-bottom:15px;">
													Hi <b>'.$fullname.'</b>,
												</p>
												<p style="line-height: 24px;margin-bottom:15px;">
													Your account password can be reset by entering the password below, If you did not request a new password please let us know/please ignore
												</p>
												<table border="0" align="center" width="180" cellpadding="0" cellspacing="0" bgcolor="5caad2" style="margin-bottom:20px;">
													<tr>
														<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
													</tr>
													<tr>
														<td align="center" style="color: #ffffff; font-size: 14px; font-family: Work Sans, Calibri, sans-serif; line-height: 22px; letter-spacing: 2px;">
															<!-- main section button -->

															<div style="line-height: 22px;">
																<center>Your Password</center>
																<a href="" style="color: #ffffff; text-decoration: none;">'.$genPassword.'</a>
															</div>
														</td>
													</tr>
													<tr>
														<td height="10" style="font-size: 10px; line-height: 10px;">&nbsp;</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
				</tr>
			</table>	
			<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="2a2e36">
				<tr>
					<td align="center" style="background-image: url(offer.jpg); background-size: cover; background-position: top center; background-repeat: no-repeat;"
						background="offer.jpg">
						<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
							<tr>
								<td height="50" style="font-size: 50px; line-height: 50px;">&nbsp;</td>
							</tr>
							<tr>
								<td align="center">
									<table border="0" width="380" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
										class="container590">
										<tr>
											<td align="center">
												<table border="0" align="center" cellpadding="0" cellspacing="0" class="container580">
													<tr>
														<td align="center" style="color: #cccccc; font-size: 16px; font-family: Work Sans, Calibri, sans-serif; line-height: 26px;">
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
							</tr>
							<tr>
								<td height="50" style="font-size: 50px; line-height: 50px;">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" class="bg_color">
				<tr>
					<td height="60" style="font-size: 60px; line-height: 60px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">
						<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">
							<tr>
								<td align="center">
									<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590 bg_color">
										<tr>
											<td>
												<table border="0" width="300" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
													class="container590">
													<tr>
														<!-- logo -->
														<td align="left">
															<a href="" style="display: block; border-style: none !important; border: 0 !important;"><img width="80" border="0" style="display: block; width: 80px;" src="login-logo.png" alt="" /></a>
														</td>
													</tr>
													<tr>
														<td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
													</tr>
													<tr>
														<td align="left" style="color: #888888; font-size: 14px; font-family: Work Sans, Calibri, sans-serif; line-height: 23px;"
															class="text_color">
															<div style="color: #333333; font-size: 14px; font-family: Work Sans, Calibri, sans-serif; font-weight: 600; mso-line-height-rule: exactly; line-height: 23px;">

																Email us: <br/> <a href="mailto:" style="color: #888888; font-size: 14px; font-family: Hind Siliguri, Calibri, Sans-serif; font-weight: 400;">vawvetclinic.not.official@gmail.com</a>

															</div>
														</td>
													</tr>
												</table>
												<table border="0" width="2" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
													class="container590">
													<tr>
														<td width="2" height="10" style="font-size: 10px; line-height: 10px;"></td>
													</tr>
												</table>
												<table border="0" width="200" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
													class="container590">
													<tr>
														<td class="hide" height="45" style="font-size: 45px; line-height: 45px;">&nbsp;</td>
													</tr>
													<tr>
														<td height="15" style="font-size: 15px; line-height: 15px;">&nbsp;</td>
													</tr>
													<tr>
														<td>
															<table border="0" align="right" cellpadding="0" cellspacing="0">
																<tr>
																	<td>
																		<a href="https://www.facebook.com/mdbootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/Qc3zTxn.png" alt=""></a>
																	</td>
																	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																	<td>
																		<a href="https://twitter.com/MDBootstrap" style="display: block; border-style: none !important; border: 0 !important;"><img width="24" border="0" style="display: block;" src="http://i.imgur.com/RBRORq1.png" alt=""></a>
																	</td>
																	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="60" style="font-size: 60px; line-height: 60px;">&nbsp;</td>
				</tr>
			</table>
			<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="f4f4f4">
				<tr>
					<td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">
						<table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
							<tr>
								<td>
									<table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
										class="container590">
										<tr>
											<td align="left" style="color: #aaaaaa; font-size: 14px; font-family: Work Sans, Calibri, sans-serif; line-height: 24px;">
												<div style="line-height: 24px;">

													<span style="color: #333333;">Vets at Work Veterinary Clinic</span>

												</div>
											</td>
										</tr>
									</table>
									<table border="0" align="left" width="5" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
										class="container590">
										<tr>
											<td height="20" width="5" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
										</tr>
									</table>
									<table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"
										class="container590">
										<tr>
											<td align="center">
												<table align="center" border="0" cellpadding="0" cellspacing="0">
													<tr>
														<td align="center">
															<a style="font-size: 14px; font-family: Work Sans, Calibri, sans-serif; line-height: 24px;color: #f08a17; text-decoration: none;font-weight:bold;"
																href="{{UnsubscribeURL}}">UNSUBSCRIBE</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="25" style="font-size: 25px; line-height: 25px;">&nbsp;</td>
				</tr>
			</table>	
		</body>
	</html>';
	$mail->MsgHTML($message); 
	if(!$mail->Send()) {
		
	} else {
		
	}	
}

function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>