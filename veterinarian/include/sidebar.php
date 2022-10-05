<?php
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}
?>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
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
						<img src="<?php echo web_root; ?>dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
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
						<img src="<?php echo web_root; ?>dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
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
						<img src="<?php echo web_root; ?>dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
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
			<a class="nav-link" data-toggle="dropdown" href="" id="notify_click">
				<i class="far fa-bell" style="font-size:22px;"></i>
				<span class="badge badge-danger navbar-badge font-weight-bold" id="notify"></span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="scrolly">
				<span class="dropdown-item dropdown-header text-left disabled" style="font-size:20px;">Notifications <a href="#" class="float-right text-dark"><i class="fa fa-ellipsis-h"></i></a></span>
				<span id="data_notify"></span>
				<div class="dropdown-divider"></div>
				<a href="<?php echo web_root;?>veterinarian/notifications/all.php" class="dropdown-item dropdown-footer">See All Notifications</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fas fa-caret-down" style="font-size:22px;"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<a href="<?php echo web_root; ?>veterinarian/profile" class="dropdown-item">
					<i class="far fa-id-card mr-2"></i> Profile
					<span class="float-right text-muted text-sm"><i class="fas fa-caret-right"></i></span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo web_root; ?>veterinarian/logout.php" class="dropdown-item">
					<i class="fas fa-power-off mr-2"></i> Logout
				</a>
			</div>
		</li>
	</ul>
</nav>
<!-- /.navbar -->
			

<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo web_root; ?>veterinarian/dashboard" class="brand-link">
		<img src="<?php echo web_root; ?>dist/img/vaw-logo.jpg" alt="Vets at Work Veterinary Clinic Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Vets at Work Veterinary</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<?php
				$sql = "SELECT firstname, lastname, photo, position FROM vet_profile WHERE vet_id = '$user'";
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
				<a href="<?php echo web_root; ?>veterinarian/profile" class="d-block"><?php echo $fullname; ?></a>
				<?php
					if($row['position'] == 'administrator'){?>
						<span class="text-success"><?php echo ucfirst($row['position']);?></span>
				<?php		
					}elseif($row['position'] == 'veterinarian'){?>
						<span class="text-primary"><?php echo ucfirst($row['position']);?></span>
				<?php
					}else{?>
						<span class="text-warning"><?php echo ucfirst($row['position']);?></span>
				<?php
					}
				?>
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
					<a href="<?php echo web_root; ?>veterinarian/dashboard" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>				
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/appointments/scheduled" class="nav-link">
						<i class="nav-icon far fa-calendar-check"></i>
						<p>
							Appointments
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/appointments/scheduled" class="nav-link">
								<i class="nav-icon fas fa-calendar-day"></i>
								<p>Schedule / Reservation</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/appointments/cancelled" class="nav-link">
								<i class="nav-icon far fa-calendar-times"></i>
								<p>Cancelled Schedule</p>
							</a>
						</li>						
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/meeting" class="nav-link">
						<i class="nav-icon fas fa-video"></i>
						<p>
							Video Consultation
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>              
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian" class="nav-link">
						<i class="nav-icon fas fa-info-circle"></i>
						
						<p>
							Information
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/informations/clients" class="nav-link">
								<i class="nav-icon fas fa-portrait"></i>
								<p>Pet Owner Information</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/informations/pets" class="nav-link">
								<i class="nav-icon fas fa-paw"></i>
								<p>Pet Information</p>
							</a>
						</li>
						<!--<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/informations/treatments" class="nav-link">
								<i class="nav-icon fas fa-book-medical"></i>
								<p>Pet Treatment</p>
							</a>
						</li>-->				
					</ul>
				</li>
				
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/services" class="nav-link">
						<i class="nav-icon fas fa-stethoscope"></i>
						<p>
							Services
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/time_management" class="nav-link">
						<i class="nav-icon fa fa-solid fa-clock"></i>
						<p>
							Time Management
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>				
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/calendar" class="nav-link">
						<i class="nav-icon far fa-calendar-alt"></i>
						<p>
							Calendar
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/blogs" class="nav-link">
						<i class="nav-icon fas fa-blog"></i>
						<p>
							Blog Posts
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/reviews" class="nav-link">
						<i class="nav-icon fas fa-star"></i>
						<p>
							Reviews
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<!--
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/inventory" class="nav-link">
						<i class="nav-icon fas fa-copy"></i>
						<p>
							Inventory
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/inventory/products" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Product</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/inventory/services" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Services</p>
							</a>
						</li>									
					</ul>
				</li>-->
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/payments" class="nav-link">
						<i class="nav-icon fas fa-receipt"></i>
						<p>
							Payment
							<?php
								$sql = "SELECT count(*) as total_pending FROM invoice WHERE payment_status = 'pending'";
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
				<!--<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/profile" class="nav-link">
						<i class="nav-icon far fa-id-card"></i>
						<p>
							Account Information
							<span class="right badge badge-danger">New</span>
						</p>
					</a>
				</li>-->
				<li class="nav-item">
					<a href="<?php echo web_root; ?>veterinarian/" class="nav-link">
						<i class="nav-icon fas fa-archive"></i>
						<p>
							Archive
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/archived/pet_owners" class="nav-link">
								<i class="nav-icon fas fa-portrait"></i>
								<p>Pet Owner</p>
							</a>
						</li>                      
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/archived/pets" class="nav-link">
								<i class="nav-icon fas fa-paw"></i>
								<p>Pets</p>
							</a>
						</li>
						<!--<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/archived/treatments" class="nav-link">
								<i class="nav-icon fas fa-book-medical"></i>
								<p>Pet Medication</p>
							</a>
						</li>-->
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/archived/services" class="nav-link">
								<i class="nav-icon fas fa-stethoscope"></i>
								<p>Services</p>
							</a>
						</li>						
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/archived/blogs" class="nav-link">
								<i class="nav-icon fas fa-blog"></i>
								<p>Blog Posts</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>veterinarian/archived/reviews" class="nav-link">
								<i class="nav-icon fas fa-star"></i>
								<p>
									Reviews
									<!--<span class="right badge badge-danger">New</span>-->
								</p>
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
		<a href="<?php echo web_root; ?>veterinarian/logout.php" class="btn btn-outline-danger d-block text-danger">
			<i class="nav-icon fas fa-power-off"></i> &nbsp; Logout
		</a>
    </div>	
	<!-- /.sidebar -->
</aside>
