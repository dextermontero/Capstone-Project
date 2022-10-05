<?php
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
	$sql = "SELECT archive_status FROM login_tbl WHERE uid = '$user'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$row = $result -> fetch_assoc();
		if($row['archive_status'] == '1'){
			session_unset();
			session_destroy();
			header("location: ../");
		}
	}
}else{
	header("location: ../");
}
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
	</ul>
<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!--<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="far fa-comments"></i>
				<span class="badge badge-danger navbar-badge">3</span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="#" class="dropdown-item">
					<div class="media">
						<img src="<?php echo web_root; ?>dist/img/profiles/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
						<div class="media-body">
							<h3 class="dropdown-item-title">
								Brad Diesel
								<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm">Call me whenever you can...</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
						</div>
					</div>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<div class="media">
						<img src="<?php echo web_root; ?>dist/img/profiles/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
						<div class="media-body">
							<h3 class="dropdown-item-title">
								John Pierce
								<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm">I got your message bro</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
						</div>
					</div>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<div class="media">
						<img src="<?php echo web_root; ?>dist/img/profiles/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
						<div class="media-body">
							<h3 class="dropdown-item-title">
								Nora Silvester
								<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
							</h3>
							<p class="text-sm">The subject goes here</p>
							<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
						</div>
					</div>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
			</div>
		</li>-->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="far fa-bell" style="font-size:22px;"></i>
				<span class="badge badge-danger navbar-badge font-weight-bold" id="notify"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header text-left disabled" style="font-size:20px;">Notifications <a href="#" class="float-right text-dark"><i class="fa fa-ellipsis-h"></i></a></span>
				<span id="data_notify"></span>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fas fa-caret-down" style="font-size:22px;"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="<?php echo web_root; ?>client/profile" class="dropdown-item">
					<i class="far fa-id-card mr-2"></i> Profile
					<span class="float-right text-muted text-sm"><i class="fas fa-caret-right"></i></span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo web_root; ?>client/logout.php" class="dropdown-item">
					<i class="fas fa-power-off mr-2"></i> Logout
				</a>
			</div>
		</li>					
	</ul>
</nav>
<!-- /.navbar -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo web_root; ?>client/dashboard" class="brand-link">
		<img src="<?php echo web_root; ?>dist/img/vaw-logo.jpg" alt="Vets at Work Veterinary Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Vets at Work Veterinary</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<?php
				$sql = "SELECT firstname, lastname, photo, position FROM user_profile WHERE user_id = '$user'";
				$result = $conn->query($sql);
				if($result -> num_rows > 0){
					while($row = $result->fetch_assoc()){
						
						$fullname = ucfirst($row['firstname']) .' '. substr(ucfirst($row['lastname']), 0, 1).'.';
						$photoname = ucfirst($row['firstname']) .' '. ucfirst($row['lastname']);
						$photo = $row['photo'];
						
			?>
			<div class="image">
				<img src="<?php echo web_root; ?>dist/img/profiles/<?php echo $photo; ?>" class="img-circle mt-2 elevation-2" alt="<?php echo $photoname; ?>">
			</div>
			<div class="info">
				<a href="<?php echo web_root; ?>client/profile/"><?php echo $fullname; ?></a>
				<span class="text-warning d-block">Pet Owner</span>
			</div>			
			<?php
					}
				}
			?>		
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/dashboard" class="nav-link">
						<i class="nav-icon fas fa-tasks"></i>
						<p>
							Activity
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/book" class="nav-link">
						<i class="nav-icon fas fa-book"></i>
						<p>
							Appointments
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>				
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/meeting" class="nav-link">
						<i class="nav-icon fas fa-video"></i>
						<p>
							Video Consultation
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<!--<li class="nav-item">
					<a href="<?php echo web_root; ?>client/profile" class="nav-link">
						<i class="nav-icon fas fa-portrait"></i>
						<p>
							Account Information
							<span class="right badge badge-danger">New</span>
						</p>
					</a>
				</li>-->				
	
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/pets" class="nav-link">
						<i class="nav-icon fas fa-paw"></i>
						<p>Pet Information</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/calendar" class="nav-link">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							Calendar
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/reviews" class="nav-link">
						<i class="nav-icon fas fa-star"></i>
						<p>
							Reviews
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/services" class="nav-link">
						<i class="nav-icon fas fa-stethoscope"></i>
						<p>
							Services
						</p>
					</a>
				</li>
				<!--
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/informations" class="nav-link">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							Information
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/informations/clients" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Client Information</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/informations/pets" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Pet Information</p>
							</a>
						</li>									
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/products_and_services" class="nav-link">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							Products and Services
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/products_and_services/weekly_sales" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Sales this week</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/products_and_services/monthly_sales" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Sales this month</p>
							</a>
						</li>									
					</ul>
				</li>-->
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/payments" class="nav-link">
						<i class="nav-icon fas fa-cash-register"></i>
						<p>
							Payment
							<?php
								$sql = "SELECT count(*) as total_pending FROM invoice WHERE user_id = '$user' AND payment_status = 'pending'";
								$result = $conn->query($sql);
								if($result -> num_rows > 0){
									$row = $result -> fetch_assoc();
									if($row['total_pending'] > 0){
										echo '<span class="right badge badge-danger">'.$row['total_pending'].'</span>';
									}
								}
							?>
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>client/" class="nav-link">
						<i class="nav-icon fas fa-archive"></i>
						
						<p>
							Archive
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>client/archived/pets" class="nav-link">
								<i class="nav-icon fas fa-paw"></i>
								<p>Pet Information</p>
							</a>
						</li>                      
						<li class="nav-item">
							<a href="<?php echo web_root; ?>client/archived/reviews" class="nav-link">
								<i class="nav-icon fas fa-star"></i>
								<p>Reviews</p>
							</a>
						</li>						
					</ul>
				</li>				
			</ul>	
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.logout -->
	<div class="sidebar-custom">
		<a href="<?php echo web_root; ?>client/logout.php" class="btn btn-outline-danger d-block text-danger">
			<i class="nav-icon fas fa-power-off"></i> &nbsp; Logout
		</a>
    </div>	
	<!-- /.sidebar -->
</aside>
