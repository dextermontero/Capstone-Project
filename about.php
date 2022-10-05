<?php
require_once("include/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>About | Vets at Work Veterinary Clinic</title>
	<?php include('include/header.php'); ?>
</head>

<body>
	<?php include('include/topnav.php'); ?>

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

    <!-- Client Pets -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h1 class="display-6 text-uppercase mb-0">PETs</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding-right: 25px;">
                <?php
					$sql = "SELECT * FROM pet_profile WHERE archive_status = '0'";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
				?>
                <div class="team-item">
                    <div class="position-relative overflow-hidden">
                        <img class="img-fluid w-100" style="height:30vh;" src="<?php echo web_root; ?>dist/img/pet_profile/<?php echo $row['pet_photo']; ?>" alt="">
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

    <?php include('include/footer.php'); ?>
	<script src="<?php echo web_root; ?>timer.js"></script>
</body>

</html>