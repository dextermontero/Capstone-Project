<?php
require_once("include/initialize.php");


if(isset($_GET['blog_id'])){
	
	$get = $_GET['blog_id'];
	$chkGet = "SELECT blog_id FROM blogs WHERE blog_id = '$get'";
	$resGet = $conn->query($chkGet);
	if($resGet -> num_rows > 0) {
		$ids = $_GET['blog_id'];
	}else {
		header('location: '.web_root);
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog Details | Vets at Work Veterinary Clinic</title>
	<?php include('include/header.php'); ?>
</head>

<body>
    <?php include('include/topnav.php'); ?>

    <!-- Blog Start -->
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-8">
				<?php
					$sql = "SELECT * FROM blogs WHERE blog_id = '$ids' AND archive_status = '0'";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						$row = $result -> fetch_assoc();
				?>
					<div class="mb-5">
						<img class="img-fluid w-100 rounded mb-5" src="<?php echo web_root; ?>dist/img/blogs/<?php echo $row['blog_photo']; ?>" alt="">
						<h1 class="text-uppercase mb-4"><?php echo $row['blog_title']; ?></h1>
						<p><?php echo $row['blog_description']; ?></p>
					</div>				
                <!-- Blog Detail End -->
				<?php
					}
				?>
            </div>
            <div class="col-lg-4">
                <div class="mb-5">
                    <h3 class="text-uppercase border-start border-5 border-primary ps-3 mb-4">Recent Post</h3>
					<?php
						$sql = "SELECT blog_id, blog_photo, blog_title FROM blogs WHERE status = 1 AND archive_status = 0 ORDER BY blog_id DESC LIMIT 5";
						$result = $conn->query($sql);
						if($result -> num_rows > 0){
							while($row = $result -> fetch_assoc()){
					?>
						<div class="d-flex overflow-hidden mb-3">
							<img class="img-fluid" src="<?php echo web_root; ?>dist/img/blogs/<?php echo $row['blog_photo']; ?>" style="width: 156px; height: 100px; object-fit: cover;" alt="">
							<a href="<?php echo web_root; ?>detail.php?blog_id=<?php echo $row['blog_id']; ?>" class="h5 d-flex align-items-center bg-light px-3 mb-0" style="width:100%;"><?php echo $row['blog_title']; ?>
							</a>
						</div>
					<?php
							}
						}
					?>
                </div>
            </div>
        </div>
    </div>

    <?php include('include/footer.php'); ?>
	<script src="<?php echo web_root; ?>timer.js"></script>
</body>

</html>