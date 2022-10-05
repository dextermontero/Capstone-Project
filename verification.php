<?php
require_once('./include/initialize.php');
session_start();
$status = 'active';
$ipadd = getIpAddress();

if(isset($_GET['code'])){
	$code = $_GET['code'];
	$chk = "SELECT code, verification FROM login_tbl WHERE code = '$code'";
	$result = $conn->query($chk);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		
		if($row['verification'] == 'active'){
			echo '<span id="check" hidden>failed</span>';
			header('Refresh:3; url='.web_root);
		}else{
			$sql = $conn->prepare("UPDATE login_tbl SET verification = ? WHERE code = ?");
			$sql->bind_param("ss", $status, $code);
			if($sql->execute()){
				$aa = "SELECT uid, roles FROM login_tbl WHERE code = '$code'";
				$b = $conn->query($aa);
				if($b -> num_rows > 0){
					$c = $b -> fetch_assoc();
					if($c['roles'] == 'administrator' || $c['roles'] == 'superadmin'){
						$_SESSION['roles'] = $c['roles'];
						$_SESSION['login_id'] = $c['uid'];
						$i = $c['uid'];
						$a = "SELECT admin_id, firstname, lastname FROM admin_profile WHERE admin_id = '$i'";
						$ar = $conn->query($a);
						if($ar -> num_rows > 0){
							$arr = $ar -> fetch_assoc();
							$id = $arr['admin_id'];
							$fullname = ucfirst($arr['firstname']) .' '. ucfirst($arr['lastname']);
							$date = date("Y-m-d");
							$time = date("H:i:s");
							$activity = "Log on at administrator portal";
							$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
							$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
							if($ab->execute()){
								echo '<span id="check" hidden>success</span>';
								header("refresh:3;url=".web_root.'admin');
								mysqli_query($conn, "DELETE FROM tbl_login_attempts WHERE ip_address = '$ipadd'");
							}else {
								echo 'failed';
								$ip = getIpAddress();
								$time = time();
								$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
								$result = $conn->query($sqlTempt);										
							}
						}
					}elseif($c['roles'] == 'veterinarian'){
						$_SESSION['login_id'] = $c['uid'];
						$_SESSION['roles'] = $c['roles'];
						$i = $c['uid'];
						$a = "SELECT vet_id, firstname, lastname FROM vet_profile WHERE vet_id = '$i'";
						$ar = $conn->query($a);
						if($ar -> num_rows > 0){
							$arr = $ar -> fetch_assoc();
							$id = $arr['vet_id'];
							$fullname = ucfirst($arr['firstname']) .' '. ucfirst($arr['lastname']);
							$date = date("Y-m-d");
							$time = date("H:i:s");
							$activity = "Log on at vet clinic portal";
							$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
							$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
							if($ab->execute()){
								echo '<span id="check" hidden>success</span>';
								header("refresh:3;url=".web_root.'veterinarian');
								mysqli_query($conn, "DELETE FROM tbl_login_attempts WHERE ip_address = '$ipadd'");
							}else {
								echo 'failed';
								$ip = getIpAddress();
								$time = time();
								$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
								$result = $conn->query($sqlTempt);					
							}
						}			
					}else{
						$_SESSION['login_id'] = $c['uid'];
						$_SESSION['roles'] = $c['roles'];
						$i = $c['uid'];
						$a = "SELECT user_id, firstname, lastname FROM user_profile WHERE user_id = '$i'";
						$ar = $conn->query($a);
						if($ar -> num_rows > 0){
							$arr = $ar -> fetch_assoc();
							$id = $arr['user_id'];
							$fullname = ucfirst($arr['firstname']) .' '. ucfirst($arr['lastname']);
							$date = date("Y-m-d");
							$time = date("H:i:s");
							$activity = "Log on at client portal";
							$ab = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
							$ab -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
							if($ab->execute()){
								echo '<span id="check" hidden>success</span>';
								header('Refresh:3; url='.web_root.'client');
								mysqli_query($conn, "DELETE FROM tbl_login_attempts WHERE ip_address = '$ipadd'");
							}else {
								echo 'failed';
								$ip = getIpAddress();
								$time = time();
								$sqlTempt = "INSERT INTO tbl_login_attempts(ip_address, counter)VALUES('$ip','$time')";
								$result = $conn->query($sqlTempt);										
							}
						}				
					}
				}else{
					echo 'failed';
				}
			}else{
				echo 'failed';
			}			
		}	
	}else{
		echo 'invalid';
	}
}else{
	header("location:".$web_root);
}
?>

<?php
require_once("include/initialize.php");
$visit = "visited";
setcookie($visit, "1-Day", time() + (86400 * 30), "/");

$ipadd = getIpAddress();
$date = date("Y-m-d");
if(!isset($_COOKIE[$visit])){
	$sql = "INSERT INTO visitors(ip_address, date)VALUES('$ipadd','$date')";
	$result = $conn->query($sql);
}

// Get IP Address
function getIpAddress(){
	if(!empty($_SERVER['HTTP_CLIENT_IP'])){
		$ipAddr = $_SERVER['HTTP_CLIENT_IP'];
	}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ipAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else {
		$ipAddr = $_SERVER['REMOTE_ADDR'];
	}
	return $ipAddr;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Vets at Work Veterinary Clinic</title>
	<?php include('include/header.php'); ?>
</head>

<body>
	<?php include('include/topnav.php'); ?>
    <!-- Hero Start -->
    <div class="container-fluid bg-primary py-5 mb-5 hero-header">
        <div class="container py-5">
            <div class="row justify-content-start">
                <div class="col-lg-8 text-center text-lg-start">
                    <h1 class="display-1 text-uppercase text-dark mb-lg-4">Punzalan Vet Clinic</h1>
                    <h1 class="text-uppercase text-white mb-lg-4">Health is Wealth</h1>
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start pt-5">
                        <a href="#" class="btn btn-light py-md-3 px-md-5 me-3" data-bs-toggle="modal" data-bs-target="#appointment">Book Now</a>
                        <!-- <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h5 class="font-weight-normal text-white m-0 ms-4 d-none d-sm-block">Play Video</h5> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->


    <!-- Video Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen allowscriptaccess="always"
                            allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="<?php echo web_root; ?>dist/img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 border-primary ps-5 mb-5">
                        <h6 class="text-info text-uppercase">About Us</h6>
                        <h1 class="display-5 text-uppercase mb-0">We Keep Your Pets Happy All Time</h1>
                    </div>
                    <h4 class="text-body mb-4"></h4>
                    <div class="bg-light p-4">
                        <ul class="nav nav-pills justify-content-between mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100 active" id="pills-1-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-1" type="button" role="tab" aria-controls="pills-1"
                                    aria-selected="true">Our Mission</button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-uppercase w-100" id="pills-2-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-2" type="button" role="tab" aria-controls="pills-2"
                                    aria-selected="false">Our Vision</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="pills-1-tab">
                                <p class="mb-0">To deliver safe, efficient, reliable and quality animal healthcare services in the Philippine pet care industry through innovations, continuous education and training.</p>
                            </div>
                            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="pills-2-tab">
                                <p class="mb-0">To be the leading provider of animal health care in the Philippines.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
    

    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-info">Services</h6>
                <h1 class="display-5 text-uppercase mb-0">Our Excellent Pet Care Services</h1>
            </div>
            <div class="row g-5">
				<?php
					$sql = "SELECT service_id, service_title, service_description, service_cost, service_photo FROM services WHERE status = 1";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
							$sid = $row['service_id'];
							$title = strtoupper($row['service_title']);
							$photo = $row['service_photo'];
							$description = $row['service_description'];
							$cost = number_format($row['service_cost'], 2);							
				?>
					<div class="col-md-6">
						<div class="service-item bg-light d-flex p-4">
							<img src="<?php echo web_root?>dist/img/services/<?php echo $photo; ?>" class="img-fluid h-25 w-25">
							<div class="px-3">
								<h5 class="text-uppercase mb-3"><?php echo $title; ?></h5>
								<p><?php echo $description; ?>.</p>
								<a class="text-warning text-uppercase view-service-modal" href="" id="<?php echo $sid; ?>" data-bs-toggle="modal" data-bs-target=".view-service">Read More<i class="bi bi-chevron-right"></i></a>
							</div>
						</div>
					</div>
				<?php
						}
					}
				?>
            </div>
        </div>
    </div>
    <!-- Services End -->

	
    <!-- Products Start -->
	<!--
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-info text-uppercase">Products</h6>
                <h1 class="display-5 text-uppercase mb-0">Products For Your Best Friends</h1>
            </div>
            <div class="owl-carousel product-carousel">
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo web_root; ?>dist/img/products/product-1.png" alt="">
                        <h6 class="text-uppercase">Quality Pet Foods</h6>
                        <h5 class="text-secondary mb-0">$199.00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo web_root; ?>dist/img/products/product-2.png" alt="">
                        <h6 class="text-uppercase">Quality Pet Foods</h6>
                        <h5 class="text-secondary mb-0">$199.00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo web_root; ?>dist/img/products/product-3.png" alt="">
                        <h6 class="text-uppercase">Quality Pet Foods</h6>
                        <h5 class="text-secondary mb-0">$199.00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo web_root; ?>dist/img/products/product-4.png" alt="">
                        <h6 class="text-uppercase">Quality Pet Foods</h6>
                        <h5 class="text-secondary mb-0">$199.00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="pb-5">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo web_root; ?>dist/img/products/product-2.png" alt="">
                        <h6 class="text-uppercase">Quality Pet Foods</h6>
                        <h5 class="text-secondary mb-0">$199.00</h5>
                        <div class="btn-action d-flex justify-content-center">
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-cart"></i></a>
                            <a class="btn btn-primary py-2 px-3" href=""><i class="bi bi-eye"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	-->
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid bg-offer my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5 justify-content-start">
                <div class="col-lg-7">
                    <div class="border-start border-5 border-primary ps-5 mb-5">
                        <h6 class="text-info text-uppercase">Special Offer</h6>
                        <h1 class="display-5 text-uppercase text-white mb-0">Save 50% on all items your first order</h1>
                    </div>
                    <p class="text-white mb-4">Eirmod sed tempor lorem ut dolores sit kasd ipsum. Dolor ea et dolore et at sea ea at dolor justo ipsum duo rebum sea. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo lorem. Elitr ut dolores magna sit. Sea dolore sed et.</p>
                    <a href="" class="btn btn-light py-md-3 px-md-5 me-3">Shop Now</a>
                    <a href="" class="btn btn-outline-light py-md-3 px-md-5">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    
    <!-- Client Pets -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-warning ps-5 mb-5" style="max-width: 600px;">
                <h1 class="display-5 text-uppercase mb-0">Clients Pets</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding-right: 25px;">
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?php echo web_root; ?>dist/img/pet-owners/team-1.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Full Name</h5>
                        <p class="m-0">BREED NG PET</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?php echo web_root; ?>dist/img/pet-owners/team-2.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Full Name</h5>
                        <p class="m-0">BREED NG PET</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?php echo web_root; ?>dist/img/pet-owners/team-3.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Full Name</h5>
                        <p class="m-0">BREED NG PET</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?php echo web_root; ?>dist/img/pet-owners/team-4.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Full Name</h5>
                        <p class="m-0">BREED NG PET</p>
                    </div>
                </div>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="<?php echo web_root; ?>dist/img/pet-owners/team-5.jpg" alt="">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase">Full Name</h5>
                        <p class="m-0">BREED NG PET</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Client Pets -->


    <!-- Testimonial Start -->
    <div class="container-fluid bg-testimonial py-5" style="margin: 45px 0;">
        <div class="container py-5">
            <div class="row justify-content-end">
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel bg-white p-5">
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-4">
                                <img class="img-fluid mx-auto" src="<?php echo web_root; ?>dist/img/Elitechlogo.png" alt="">
                                <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
                                    <i class="bi bi-chat-square-quote text-primary"></i>
                                </div>
                            </div>
                            <p>GOODS NA GOODS</p>
                            <hr class="w-25 mx-auto">
                            <h5 class="text-uppercase">Client 1</h5>
                            <span>Name 1</span>
                        </div>
                        <div class="testimonial-item text-center">
                            <div class="position-relative mb-4">
                                <img class="img-fluid mx-auto" src="<?php echo web_root; ?>dist/img/qculogo.jpg" alt="">
                                <div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
                                    <i class="bi bi-chat-square-quote text-primary"></i>
                                </div>
                            </div>
                            <p>SOLID, GEGET AKO ULIT</p>
                            <hr class="w-25 mx-auto">
                            <h5 class="text-uppercase">Client 2</h5>
                            <span>Name 2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Blog Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Latest Blog</h6>
                <h1 class="display-5 text-uppercase mb-0">Latest Articles From Our Blog Post</h1>
            </div>
            <div class="row g-5">
				<?php
					$sql = "SELECT blogs.blog_id, blogs.blog_photo, blogs.blog_title, blogs.blog_description, blogs.blog_date, vet_profile.firstname, vet_profile.lastname FROM blogs INNER JOIN vet_profile ON vet_profile.vet_id = blogs.author WHERE blogs.status = 1 ORDER BY blog_id DESC LIMIT 2";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
				?>
                <div class="col-lg-6">
                    <div class="blog-item">
                        <div class="row g-0 bg-light overflow-hidden">
                            <div class="col-12 col-sm-5 h-100">
                                <img class="img-fluid h-100" src="<?php echo web_root; ?>dist/img/blogs/<?php echo $row['blog_photo']; ?>" style="object-fit: cover;">
                            </div>
                            <div class="col-12 col-sm-7 h-100 d-flex flex-column justify-content-center">
                                <div class="p-4">
                                    <div class="d-flex mb-3">
                                        <small class="me-3"><i class="bi bi-bookmarks me-2"></i><?php echo ucfirst($row['lastname']).' '. substr(ucfirst($row['firstname']), 0, 1); ?>.</small>
                                        <small><i class="bi bi-calendar-date me-2"></i><?php echo date("d M, Y", strtotime($row['blog_date'])); ?></small>
                                    </div>
                                    <h5 class="text-uppercase mb-3"><?php echo strtoupper($row['blog_title']);?></h5>
                                    <p><?php echo substr($row['blog_description'], 0, 104); ?>...</p>
                                    <a class="text-primary text-uppercase" href="<?php echo web_root; ?>detail.php?blog_id=<?php echo $row['blog_id'];?>">Read More<i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php
						}
					}
				?>
            </div>
        </div>
    </div>
    <!-- Blog End -->
	<div class="modal fade" id="appointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Book Appointment</h5>
					<button type="button" class="btn-close" id="index-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6 col-12">
							<img src="<?php echo web_root; ?>dist/img/login-logo.png" class="img-fluid rounded mx-auto bg-background-image">
						</div>
						<div class="col-lg-6 col-12">
							<h4>Book now!</h4>
							<span>Login to your account</span>
							<br>
							<br>
							<div class="d-flex flex-column">
								<form action="" method="post">
									<div class="form-group" style="padding-bottom: 3px">
										<label for="client-email" class="form-label">Email Address</label>
										<input type="email" class="form-control" id="client-email" placeholder="Email Address">
									</div>
									<div class="form-group" style="padding-bottom: 10px">
										<label for="client-password" class="form-label">Password</label>
										<input type="password" class="form-control" id="client-password" placeholder="Password">
									</div>							
									<!-- Login Button -->
									<div class="d-grid">
										<button type="submit" class="btn btn-outline-success" id="index-login">Login</button>
										<div class="text-danger text-center mt-3"><span id="exceed1"></span></div>
									</div>
									<div class="row my-2">
										<div class="col-lg-6 col-6">
											<a href="#" id="index-register-btn" class="auth-link text-secondary text-left" data-bs-toggle="modal" data-bs-target="#register">Create an account</a>
										</div>
										<div class="col-lg-6 col-6 text-end">
											<a href="#" id="index-forgot-btn" class="auth-link text-secondary" data-bs-toggle="modal" data-bs-target="#forgot">Forgot Password?</a>
										</div>									
									</div>
								</form>
								<div class="text-center mt-4 font-weight-light">
									<span class="text-secondary">Punzalan Vet Clinic &copy; <?php echo date("Y"); ?></span>
								</div>
							</div>					
						</div>
					</div>				
				</div>
			</div>
		</div>
	</div>	
	<div class="modal fade view-service" tabindex="-1" role="dialog" aria-labelledby="AddService" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div id="view_modal_services"></div>
		</div>
	</div>	
    
	<?php include('include/footer.php'); ?>
	<script>
		$(document).ready(function() {
			var check = $('#check').html();
			if(check == 'success'){
				Swal.fire({
					title : "Account Activation",
					icon : "success",
					html: "<strong>Success! </strong>activation of account <b>Please Wait!</b>.",
					timer: 3000,
					showConfirmButton:false							
				});								
			}else{
				Swal.fire({
					title : "Account Activation",
					icon : "error",
					html: "<strong>Failed! </strong>Already Activated <b>Please Wait!</b>.",
					timer: 3000,
					showConfirmButton:false							
				});				
			}
		});
	</script>
</body>
</html>