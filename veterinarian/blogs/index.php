<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Blogs Post | Vets at Work Veterinary Clinic</title>
		<?php include('../include/header.php'); ?>
			<style type="text/css">
			#viewIMG {
				height : 80%;
				width: 100%;
			}
			@media only screen and (max-width: 768px) { 
				#viewIMG {
					height: 50%;
				}	
			}
			@media screen and (max-width: 800px) {
				#viewIMG {
					height: 50%;
				}	
			}
			@media screen and (max-width: 1000px) {
				#viewIMG {
					height: 50%;
				}
			}			
			</style>		
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
							<div class="col-sm-6">
								<h1 class="m-0">Blogs Information</h1>
							</div>
							<div class="col-sm-6">
								<button type="button" name="add-blog" id="add-blog" class="btn btn-outline-success float-right" data-toggle="modal" data-target=".add-blog-modal"><i class="fas fa-plus"></i> &nbsp;Add Blog</button>
							</div>							
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<?php
								$sql = "SELECT * FROM blogs WHERE author = '$user' AND archive_status = '0' LIMIT 6";
								$result = $conn->query($sql);
								if($result -> num_rows > 0){
									while($row = $result -> fetch_assoc()){
							?>
								<div class="col-lg-6 col-12">
									<div class="card">
										<div class="card-header">									
											<h3 class="card-title"><b><?php echo $row['blog_title']; ?></b></h3>
											<div class="card-tools">
											<?php
												if($row['status'] == 0){
											?>
												<span class="bg-warning p-1 m-2">Unpublished Post</span>								
											<?php
												}else {
											?>
												<span class="bg-success p-1 m-2">Published Posted</span>												
											<?php
												}
											?>												
												<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
													<i class="fas fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-4 col-4">
													<img src="<?php echo web_root?>dist/img/blogs/<?php echo $row['blog_photo']; ?>" class="img-fluid w-100" alt="">
												</div>
												<div class="col-lg-8 col-8">
													<p class="h5"><?php echo $row['blog_description']; ?></p>
													<span class="h4"></span>
												</div>
											</div>
										</div>
										<div class="card-footer">
											<div class="row">
												<div class="col-lg-6 col-6">
													<a class="btn btn-primary btn-sm float-left view-blog" href="" id="<?php echo $row['blog_id']; ?>" data-toggle="modal" data-target=".view-blog-modal">
														<i class="fas fa-edit"></i>
														Edit
													</a>
													<?php
														if($row['status'] == '1'){
													?>
													<a class="btn btn-warning btn-sm float-left update-status ml-2" href="" id="<?php echo $row['blog_id']; ?>">
														<i class="fas fa-eye-slash"></i>
														Unpublished
													</a>													
													<?php
														}else {
													?>
													<a class="btn btn-success btn-sm float-left update-status ml-2" href="" id="<?php echo $row['blog_id']; ?>">
														<i class="fas fa-eye"></i>
														Published
													</a>
													<?php
														}
													?>													
												</div>
												<div class="col-lg-6 col-6">
													<a class="btn btn-danger btn-sm float-right archive-blog" href="#" id="<?php echo $row['blog_id']; ?>">
														<i class="fas fa-archive"></i>
														Archive
													</a>										
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
					</div><!-- /.container-fluid -->
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->

			<div class="modal fade view-blog-modal" tabindex="-1" role="dialog" aria-labelledby="updateBlog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="updateBlog">Blogs Information</h5>
							<button type="button" class="close" id="update-blog-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div id="view_blog_modal"></div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" id="update_blog">Update Blog</button>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="modal fade add-blog-modal" tabindex="-1" role="dialog" aria-labelledby="AddBlog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="AddBlog">Add Blog Post</h5>
							<button type="button" class="close" id="add-blog-close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="" method="POST">
								<div class="row">
									<div class="col-lg-4 col-4">
										<img src="<?php echo web_root; ?>dist/img/blogs/default.png" class="img-fluid w-100" id="viewIMG">
										<input type="file" class="form-control-file pt-3" accept="image/*" id="prevIMG">
									</div>
									<div class="col-lg-8 col-8">
										<div class="form-group">
											<label for="blog_title">Blog Title</label>
											<input type="text" class="form-control" id="blog_title" placeholder="Enter Blog Title">
										</div>							
										<div class="form-group">
											<label for="blog_description">Blog Description</label>
											<textarea class="form-control" id="blog_description" rows="7" placeholder="Enter Blog Description"></textarea>
										</div>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" id="post_blog">Post Blog</button>
						</div>
					</div>
				</div>
			</div>			
			
			<footer class="main-footer">
				<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 3.2.0
				</div>
			</footer>
		</div>

		<?php include('../include/footer.php'); ?>
		<script src="<?php echo web_root; ?>veterinarian/blogs/blogs.js"></script>
	</body>
</html>
