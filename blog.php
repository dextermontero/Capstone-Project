<?php
require_once("include/initialize.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Blog Posts | Vets at Work Veterinary Clinic</title>
	<?php include('include/header.php'); ?>
</head>

<body>
	<?php include('include/topnav.php'); ?>
	<!-- Navbar End -->
	<span id="web_root" hidden><?php echo web_root; ?></span>
    <!-- Blog Start -->
    <div class="container py-5">
        <div class="row g-5">
            <!-- Blog list Start -->
            <div class="col-lg-8">
				<?php
					$sql = "SELECT blogs.blog_id, blogs.blog_photo, blogs.blog_title, blogs.blog_description, blogs.blog_date, vet_profile.firstname, vet_profile.lastname FROM blogs INNER JOIN vet_profile ON vet_profile.vet_id = blogs.author WHERE blogs.status = 1 AND blogs.archive_status = 0 ORDER BY blog_id DESC LIMIT 5";
					$result = $conn->query($sql);
					if($result -> num_rows > 0){
						while($row = $result -> fetch_assoc()){
				?>
					<div class="blog-item mb-5">
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
				<?php
						}
					}
				?>
                <!--<div class="col-12">
                    <nav aria-label="Page navigation">
                      <ul class="pagination pagination-lg m-0">
                        <li class="page-item disabled">
                          <a class="page-link rounded-0" href="#" aria-label="Previous">
                            <span aria-hidden="true"><i class="bi bi-arrow-left"></i></span>
                          </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                          <a class="page-link rounded-0" href="#" aria-label="Next">
                            <span aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                          </a>
                        </li>
                      </ul>
                    </nav>
                </div>-->
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