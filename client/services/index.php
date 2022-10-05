<?php
require_once("../../include/initialize.php");
session_start();
setlocale(LC_MONETARY, 'en_US');
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Services | Vets at Work Veterinary Clinic</title>
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
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1>Services</h1>
							</div>						
						</div>
					</div>
				</section>
				
				<section class="content">
					<div class="container-fluid">
						<div class="row">
							<?php
								$sql = "SELECT service_id, service_title, service_description, service_cost, service_photo FROM services WHERE status = 1 AND archive_status = '0'";
								$result = $conn->query($sql);
								if($result -> num_rows > 0) {
									while($row = $result -> fetch_assoc()){
										$sid = $row['service_id'];
										$title = strtoupper($row['service_title']);
										$photo = $row['service_photo'];
										$description = $row['service_description'];
										$cost = number_format($row['service_cost'], 2);

							?>
								<div class="col-lg-6 col-12">
									<div class="card">
										<div class="card-header">
											<h3 class="card-title"><b><?php echo $title; ?></b></h3>
											<div class="card-tools">
												<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
													<i class="fas fa-minus"></i>
												</button>
											</div>
										</div>
										<div class="card-body">
											<div class="row">
												<div class="col-lg-4 col-4">
													<img src="<?php echo web_root; ?>dist/img/services/<?php echo $photo; ?>" class="img-fluid w-100" alt="<?php echo $photo; ?>">
												</div>
												<div class="col-lg-8 col-8">
													<p class="h5"><?php echo substr($description, 0, 301); ?>...</p>
													<a class="text-primary text-uppercase view-service-modal" href="" id="<?php echo $sid; ?>" data-toggle="modal" data-target=".view-service">Read More<i class="bi bi-chevron-right"></i></a><br>
													<span class="h4">₱ <?php echo $cost; ?></span>
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
				</section>
			</div>

			<footer class="main-footer">
				<strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
				All rights reserved.
				<div class="float-right d-none d-sm-inline-block">
					<b>Version</b> 3.2.0
				</div>
			</footer>
		</div>
		<div class="modal fade view-service" tabindex="-1" role="dialog" aria-labelledby="ViewService" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div id="view_modal_services"></div>
			</div>
		</div>
		
		<?php include('../include/footer.php'); ?>
		<script>
		$(document).ready(function() {
			$('.view-service-modal').click(function(e) {
				e.preventDefault();
				var sid = $(this).attr('id');
				$.ajax({
					url : "modal.php",
					method : "POST",
					data : {sid : sid},
					success:function(data){
						$('#view_modal_services').html(data);
					}
				});
			});
		});		
		</script>
	</body>
</html>
