<?php
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
	$user = $_SESSION['login_id'];
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
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="far fa-bell"></i>
				<span class="badge badge-warning navbar-badge">15</span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">15 Notifications</span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-envelope mr-2"></i> 4 new messages
					<span class="float-right text-muted text-sm">3 mins</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-users mr-2"></i> 8 friend requests
					<span class="float-right text-muted text-sm">12 hours</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fas fa-file mr-2"></i> 3 new reports
					<span class="float-right text-muted text-sm">2 days</span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
			</div>
		</li>-->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fas fa-caret-down"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<!--<span class="dropdown-item dropdown-header"></span>
				<div class="dropdown-divider"></div>-->
				<a href="<?php echo web_root; ?>admin/profile" class="dropdown-item">
					<i class="far fa-id-card mr-2"></i> Account Profile
					<span class="float-right text-muted text-sm"><i class="fas fa-caret-right"></i></span>
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo web_root; ?>admin/logout.php" class="dropdown-item">
					<i class="fas fa-power-off mr-2"></i> Logout
				</a>
			</div>
		</li>					
	</ul>
</nav>
<!-- /.navbar -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo web_root; ?>admin/dashboard" class="brand-link">
		<img src="<?php echo web_root; ?>dist/img/vaw-logo.jpg" alt="Vets at Work Veterinary Clinic Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Vets at Work Veterinary</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<?php
				$sql = "SELECT firstname, lastname, photo, position FROM admin_profile WHERE admin_id = '$user'";
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
				<a href="<?php echo web_root; ?>admin/profile/" class="d-block"><?php echo $fullname; ?></a>
				<?php
					if($row['position'] == 'administrator'){?>
						<span class="text-success"><?php echo ucfirst($row['position']);?></span>
				<?php		
					}elseif($row['position'] == 'superadmin'){?>
						<span class="text-danger"><?php echo ucfirst($row['position']);?></span>
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
					<a href="<?php echo web_root; ?>admin/dashboard" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<!--<li class="nav-item">
					<a href="<?php echo web_root; ?>admin" class="nav-link">
						<i class="nav-icon far fa-calendar-check"></i>
						<p>
							Appointments
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/appointments/scheduled" class="nav-link">
								<i class="nav-icon fas fa-calendar-day"></i>
								<p>Schedule / Reservation</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/appointments/cancelled" class="nav-link">
								<i class="nav-icon far fa-calendar-times"></i>
								<p>Cancelled Schedule</p>
							</a>
						</li>						
					</ul>
				</li>-->			
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/meeting" class="nav-link">
						<i class="nav-icon fas fa-video"></i>
						<p>
							Video Consultation
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>				
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/services" class="nav-link">
						<i class="nav-icon fas fa-stethoscope"></i>
						<p>
							Services
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/branches" class="nav-link">
						<i class="nav-icon fas fa-code-branch"></i>
						<p>
							Branches
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin" class="nav-link">
						<i class="nav-icon far fa-clipboard"></i>
						<p>
							Sales Report
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/sales_report/weekly_sales" class="nav-link">
								<i class="nav-icon fas fa-chart-bar"></i>
								<p>Sales this Week</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/sales_report/monthly_sales" class="nav-link">
								<i class="nav-icon fas fa-chart-bar"></i>
								<p>Sales this Month</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/sales_report/yearly_sales" class="nav-link">
								<i class="nav-icon fas fa-chart-bar"></i>
								<p>Sales this Year</p>
							</a>
						</li>						
					</ul>
				</li>				
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin" class="nav-link">
						<i class="nav-icon fas fa-info-circle"></i>
						
						<p>
							Information
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/informations/clients" class="nav-link">
								<i class="nav-icon fas fa-portrait"></i>
								<p>Pet Owner Information</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/informations/pets" class="nav-link">
								<i class="nav-icon fas fa-paw"></i>
								<p>Pet Information</p>
							</a>
						</li>									
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/veterinarian" class="nav-link">
						<i class="nav-icon fas fa-user-md"></i>
						<p>Veterinarian</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/administrator" class="nav-link">
						<i class="nav-icon fas fa-users-cog"></i>
						<p>Administrator</p>
					</a>
				</li>
				<!--<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/account_management/" class="nav-link">
						<i class="nav-icon fas fa-user-alt"></i>
						<p>
							Account Management
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/account_management/veterinarian" class="nav-link">
								<i class="nav-icon fas fa-user-md"></i>
								<p>Veterinarian</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/account_management/administrator" class="nav-link">
								<i class="nav-icon fas fa-users-cog"></i>
								<p>Administrator</p>
							</a>
						</li>									
					</ul>
				</li>-->
				
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
					<a href="<?php echo web_root; ?>admin/audits" class="nav-link">
						<i class="nav-icon fas fa-book-reader"></i>
						<p>
							Audit Logs
							<!--<span class="right badge badge-danger">New</span>-->
						</p>
					</a>
				</li>
              	<li class="nav-item">
					<a href="<?php echo web_root; ?>admin/" class="nav-link">
						<i class="nav-icon fas fa-archive"></i>
						<p>
							Archive
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/pet_owners" class="nav-link">
								<i class="nav-icon fas fa-portrait"></i>
								<p>Pet Owner</p>
							</a>
						</li>					
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/pets" class="nav-link">
								<i class="nav-icon fas fa-paw"></i>
								<p>Pets</p>
							</a>
						</li>						
						<!--<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/treatments" class="nav-link">
								<i class="nav-icon fas fa-book-medical"></i>
								<p>Pet Medication</p>
							</a>
						</li>-->
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/services" class="nav-link">
								<i class="nav-icon fas fa-stethoscope"></i>
								<p>Services</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/branches" class="nav-link">
								<i class="nav-icon fas fa-code-branch"></i>
								<p>Branches</p>
							</a>
						</li>						
						<!--<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/blogs" class="nav-link">
								<i class="nav-icon fas fa-blog"></i>
								<p>Blog Posts</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo web_root; ?>admin/archived/reviews" class="nav-link">
								<i class="nav-icon fas fa-star"></i>
								<p>
									Reviews
								</p>
							</a>
						</li>-->					
					</ul>
				</li>
			</ul>	
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.logout -->
	<div class="sidebar-custom">
		<a href="<?php echo web_root; ?>admin/logout.php" class="btn btn-outline-danger d-block text-danger">
			<i class="nav-icon fas fa-power-off"></i> &nbsp; Logout
		</a>
    </div>	
	<!-- /.sidebar -->
</aside>
