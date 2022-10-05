<?php
require_once("../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$gnotify_id = $_GET['notif_id'];
if(isset($_GET['notif_id'])){
	$actual_link = $_SERVER['REQUEST_URI'];
	if (strpos($actual_link, '%27') !== false) {
		$new_link = str_replace("%27", "", $actual_link) ;
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: $new_link");
		exit;
	}else{
		$sql = "SELECT status FROM notification WHERE id = '$gnotify_id' AND receiver = '$user'";
		$result = $conn->query($sql);
		if($result -> num_rows > 0){
			$row = $result -> fetch_assoc();
			$status = $row['status'];
			if($status == '1'){
				$sql = $conn->prepare("UPDATE notification SET status = '0' WHERE id = ?");
				$sql -> bind_param("s", $gnotify_id);
				if($sql->execute()){
					
				}
			}else{
				
			}
		}
	}	
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Video Consultation | Vets at Work Veterinary</title>
		<?php include('../include/header.php'); ?>
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
								<h1 class="m-0">Video Consultation</h1>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>

				<section class="content">
					<div class="container-fluid">
						
						<div class="row">
							<div class="col-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Meeting Link</h3>
									</div><!-- /.card-header -->
									<div class="card-body">
										<div class="table-responsive">
											<table id="meeting" class="table table-borderedless table-striped table-hover table-sm">
												<thead>
													<tr>
														<th class="py-1 px-2">Meeting ID</th>
														<th class="py-1 px-2">Topic</th>
														<th class="py-1 px-2">Meeting Link</th>
														<th class="py-1 px-2">Meeting Password</th>
														<th class="py-1 px-2">Date</th>
														<th class="py-1 px-2">Time</th>
													</tr>
												</thead>
												<tbody>
													<?php 
														$sql = "SELECT * FROM zoom_meeting WHERE to_client = '$user'";
														$result = $conn->query($sql);
														$meetid = '';
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
																$meetid = $row['meeting_id'];
													?>
													<tr>
														<td class="py-1 px-2"><?php echo $row['meeting_id']; ?></td>
														<td class="py-1 px-2"><?php echo $row['topic']; ?></td>
														<td class="py-1 px-2"><a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['link']; ?></a></td>
														<td class="py-1 px-2"><?php echo $row['password']; ?></td>
														<td class="py-1 px-2"><?php echo date("F d, Y", strtotime($row['date'])); ?></td>
														<td class="py-1 px-2"><?php echo date("g:i A", strtotime($row['time'])); ?></td>
													</tr>
			
													<?php
															}
														}
													?>
													<?php if($result->num_rows <=0): ?>
														<tr>
															<th class="text-center" colspan="7">No Meeting link to display.</th>
														</tr>
													<?php endif; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>							
							</div>
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

		<?php include('../include/footer.php'); ?>
	</body>
</html>
