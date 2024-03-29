<?php
require_once("include/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Services | Vets at Work Veterinary Clinic</title>
	<?php include('include/header.php'); ?>
</head>

<body>
    <?php include('include/topnav.php'); ?>

    <!-- Services Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Services</h6>
                <h1 class="display-5 text-uppercase mb-0">Our Excellent Pet Care Services</h1>
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
							}else{
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
	<div class="modal fade view-service" tabindex="-1" role="dialog" aria-labelledby="ViewService" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
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
	<script src="<?php echo web_root; ?>timer.js"></script>
</body>

</html>