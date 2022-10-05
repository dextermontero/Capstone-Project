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
    <div class="containerbg-primary py-0 mb-0">
		<img src="<?php echo web_root;?>dist/img/banner.png" alt="..." class="img-fluid" style="background-size:cover;">	
    </div>
    <!-- Hero End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row gx-5">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100 rounded" src="<?php echo web_root; ?>dist/img/about.png" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="border-start border-5 border-primary ps-5 mb-5">
                        <h6 class="text-info text-uppercase">About Us</h6>
                        <h1 class="display-6 text-uppercase mb-0">We Keep Your Pets Happy All Time</h1>
                    </div>
                    <h4 class="text-body mb-4"></h4>
                    <div class="bg-light p-4">
						Vets at Work Veterinary Clinic Formerly Avenue Vets’ Veterinary Clinic started on February 8, 2020. The clinic offers services and provides vaccines like deworming, anti-rabies, vitamins, and more. The clinic also offers Ultrasound, surgical purposes, test testosterone test, an incubator for puppies and kittens, oxygen in case of emergency purposes only.
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
                <h1 class="display-6 text-uppercase mb-0">Our Excellent Pet Care Services</h1>
            </div>
            <div class="row g-5">
				<?php
					$sql = "SELECT service_id, service_title, service_description, service_cost, service_photo FROM services WHERE status = 1 AND archive_status = 0";
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
								<p><?php echo substr($description, 0, 104); ?>...</p>
								<a class="text-warning text-uppercase view-service-modal" href="" id="<?php echo $sid; ?>" data-bs-toggle="modal" data-bs-target=".view-service">Read More<i class="bi bi-chevron-right"></i></a>
							</div>
						</div>
					</div>
				<?php
						}
					}
				?>
				<div class="col-md-6">
					<div class="service-item bg-light d-flex p-4">
						<img src="<?php echo web_root?>dist/img/services/complete_blood_count.jpg" class="img-fluid h-25 w-25">
						<div class="px-3">
							<h5 class="text-uppercase mb-3">Confinement</h5>
							<p><?php echo substr('commonly after surgery vet may require confinement to thoroughly examine the patient’s condition<br>• 2000 overnight confinement<br>• 1000 9:00 am – 4:00 pm<br>* Professional fee starts at 350', 0, 104); ?></p>
							<a class="text-warning text-uppercase" href="" data-bs-toggle="modal" data-bs-target=".view-confinement">Read More<i class="bi bi-chevron-right"></i></a>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="service-item bg-light d-flex p-4">
						<img src="<?php echo web_root?>dist/img/services/complete_blood_count.jpg" class="img-fluid h-25 w-25">
						<div class="px-3">
							<h5 class="text-uppercase mb-3">Online Consultation</h5>
							<p><?php echo substr('Online Consultation offers virtual check up without the hassle of traveling. The consultation is perfomed with the use of video conferencing via Zoom.', 0, 104); ?></p>
							<a class="text-warning text-uppercase" href="" data-bs-toggle="modal" data-bs-target=".view-onlineconsultation">Read More<i class="bi bi-chevron-right"></i></a>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
    <!-- Services End -->

    <!-- Client Pets -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-warning ps-5 mb-5" style="max-width: 600px;">
                <h1 class="display-6 text-uppercase mb-0">Pets</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding-right: 25px;">
				<?php
					$sql = "SELECT * FROM pet_profile WHERE archive_status = '0' ORDER BY rand()";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
				?>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" style="height:30vh;" src="<?php echo web_root; ?>dist/img/pet_profile/<?php echo $row['pet_photo']; ?>" alt="<?php echo $row['pet_name']; ?>" height="500" width="500">
                    </div>
                    <div class="bg-light text-center p-4">
                        <h5 class="text-uppercase"><?php echo $row['pet_name']; ?></h5>
						<?php
							if($row['pet_breed'] == '' || $row['pet_breed'] == null) {
						?>
								<p class="m-0"><i>Not Set</i></p>
						<?php
							}else{
						?>
								<p class="m-0"><?php echo ucfirst($row['pet_breed']); ?></p>
						<?php
							}
						?>
                    </div>
                </div>
				<?php
						}
					}else{
                 ?>
                  <div class="team-item">
                      <div class="position-relative overflow-hidden">
                          <img class="img-fluid w-100" src="<?php echo web_root; ?>dist/img/pet_profile/default.png" alt="">
                      </div>
                      <div class="bg-light text-center p-4">
                          <h5 class="text-uppercase">NO PETS</h5>
                          <p class="m-0">NO BREED</p>
                      </div>
                  </div>              		
              	<?php
                    }
				?>
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
						<?php 
							$sql = "SELECT reviews.review_id, reviews.review_description, user_profile.firstname, user_profile.lastname, user_profile.photo FROM reviews INNER JOIN user_profile ON user_profile.user_id = reviews.user_id WHERE reviews.status = 1 AND reviews.archive_status = '0'";
							$result = $conn->query($sql);
							if($result -> num_rows > 0){
								while($row = $result -> fetch_assoc()){
						?>
							<div class="testimonial-item text-center">
								<div class="position-relative mb-4">
									<img class="img-fluid mx-auto" src="<?php echo web_root; ?>dist/img/profiles/<?php echo $row['photo']; ?>" alt="">
									<div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
										<i class="bi bi-chat-square-quote text-primary"></i>
									</div>
								</div>
								<p><?php echo $row['review_description']; ?></p>
								<hr class="w-25 mx-auto">
								<!--<h5 class="text-uppercase">Client 1</h5>-->
								<span><?php echo ucfirst($row['firstname']) .' '. ucfirst($row['lastname']); ?></span>
							</div>
						<?php
								}
							}else {
                         ?>
							<div class="testimonial-item text-center">
								<div class="position-relative mb-4">
									<img class="img-fluid mx-auto" src="<?php echo web_root; ?>dist/img/profiles/default.png" alt="">
									<div class="position-absolute top-100 start-50 translate-middle d-flex align-items-center justify-content-center bg-white" style="width: 45px; height: 45px;">
										<i class="bi bi-chat-square-quote text-primary"></i>
									</div>
								</div>
								<p>NO REVIEW AVAILABLE</p>
								<hr class="w-25 mx-auto">
								<!--<h5 class="text-uppercase">Client 1</h5>-->
								<span>NO REVIEWS</span>
							</div>                      
                      	<?php
                            }
						?>
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
                <h1 class="display-6 text-uppercase mb-0">Latest Articles From Our Blog Post</h1>
            </div>
            <div class="row g-5">
				<?php
					$sql = "SELECT blogs.blog_id, blogs.blog_photo, blogs.blog_title, blogs.blog_description, blogs.blog_date, vet_profile.firstname, vet_profile.lastname FROM blogs INNER JOIN vet_profile ON vet_profile.vet_id = blogs.author WHERE blogs.status = 1 AND blogs.archive_status = 0 ORDER BY blog_id DESC LIMIT 2";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
				?>
                <div class="col-lg-6">
                    <div class="blog-item">
                        <div class="row g-0 bg-light overflow-hidden">
                            <div class="col-12 col-sm-5 h-100">
                                <img class="img-fluid h-100" src="<?php echo web_root; ?>dist/img/blogs/<?php echo $row['blog_photo']; ?>" style="object-fit: cover;width:100%">
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
							<img src="<?php echo web_root; ?>dist/img/vaw-logo.jpg" class="img-fluid rounded mx-auto bg-background-image">
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
									<span class="text-secondary">Vets at Work Veterinary Clinic &copy; <?php echo date("Y"); ?></span>
								</div>
								<div class="text-left font-weight-light">
									<span class="text-left" style="font-size: 15px;">By using this service, you understand and agree to the Vets at Work Veterinary Clinic Online Services <a href="#" id="terms-btn-index" data-bs-toggle="modal" data-bs-target="#terms">Terms of Use</a> and <a href="#" id="index-btn-register" data-bs-toggle="modal" data-bs-target="#privacy">Privacy Statement</a></span>
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
	<div class="modal fade view-confinement" tabindex="-1" role="dialog" aria-labelledby="AddService" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="title_service">Confinement</h5>
					<button type="button" class="btn-close" id="btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="" method="POST">
						<div class="row">
							<div class="col-lg-4 col-12" style="height:200px;margin-bottom:2%;">
								<img src="<?php echo web_root?>dist/img/services/complete_blood_count.jpg" class="img-fluid mx-auto d-block w-100" style="height: 100%;width: 90%;">
							</div>
							<div class="col-lg-8 col-12">
								<p>commonly after surgery vet may require confinement to thoroughly examine the patient’s condition<br>• 2000 overnight confinement<br>• 1000 9:00 am – 4:00 pm<br>* Professional fee starts at 350</p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade view-onlineconsultation" tabindex="-1" role="dialog" aria-labelledby="AddService" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="title_service">Online Consultation</h5>
					<button type="button" class="btn-close" id="btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="" method="POST">
						<div class="row">
							<div class="col-lg-4 col-12" style="height:200px;margin-bottom:2%;">
								<img src="<?php echo web_root?>dist/img/services/complete_blood_count.jpg" class="img-fluid mx-auto d-block w-100" style="height: 100%;width: 90%;">
							</div>
							<div class="col-lg-8 col-12">
								<p>Online Consultation offers virtual check up without the hassle of traveling. The consultation is perfomed with the use of video conferencing via Zoom.</p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>    
	<?php include('include/footer.php'); ?>
	<script src="<?php echo web_root; ?>modal.js"></script>
	<script src="<?php echo web_root; ?>index.js"></script>
	<script src="<?php echo web_root; ?>activation.js"></script>
</body>

</html>