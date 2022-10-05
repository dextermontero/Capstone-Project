<?php
require_once("../../../include/initialize.php");
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}
if(!isset($_GET['date'])){
	
}else{
	$actual_link = $_SERVER['REQUEST_URI'];
	if (strpos($actual_link, '%27') !== false) {
		$new_link = str_replace("%27","",$actual_link);
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: $new_link");
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Appointment Schedule | Vets at Work Veterinary</title>
		<?php include('../../include/header.php'); ?>
		<link rel="stylesheet" href="<?php echo web_root; ?>plugins/select2/css/select2.css">
		<style type="text/css">
			.selectedTime {
				color:#fff;background-color:#28a745;border-color:#28a745
			}
			.selectedPayment {
				color:#fff;background-color:#28a745;border-color:#28a745
			}
			.foo { color: #808080; text-size: smaller; }
		</style>
	</head>
	<body class="hold-transition sidebar-mini layout-fixed">
		<div class="wrapper">
			<?php include('../../include/sidebar.php'); ?>
			<div class="content-wrapper">

				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-4 d-flex">
								<a href="javascript: history.go(-1)"><i class="fas fa-arrow-left px-2 text-dark" style="font-size: 30px;"></i></a>
								<h1 class="m-0">Appointment Schedule</h1>
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container-fluid">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 col-12">								
										<div class="form-group pull-right">
											<label>Select Preferred Branch: <span class="text-danger">*</span></label>
											<select name="preferred_branch" class="form-control select2"id="preferred_branch">
												<?php
													if(!isset($_GET['branchID'])){
												?>
													<option disabled selected data-foo="Preferred Branch">Select Preferred Branch</option>
												<?php
													}else{
														$getBranch = $_GET['branchID'];
														$sql = "SELECT * FROM branch WHERE branch_id = '$getBranch'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															$row = $result -> fetch_assoc();
												?>
														<option value="<?php echo $row['branch_id']; ?>" data-foo="<?php echo $row['address']; ?>"><?php echo $row['name']; ?></option>
												<?php
														}
													}
												?>
												
												<?php
													$sql = "SELECT * FROM branch WHERE status = '1' AND archive_status = '0'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														while($row = $result -> fetch_assoc()){
												?>
														<option value="<?php echo $row['branch_id']; ?>" data-foo="<?php echo $row['address']; ?>"><?php echo $row['name']; ?></option>
												<?php
														}
													}else{
												?>
														<option disabled selected data-foo="No Branch Available">No Branch Available</option>
												<?php
													}
												?>																	
											</select>
											<?php
												if(!isset($_GET['branchID'])){
													$date = date("Y-m-d");
													$dateComponents = getdate(); 
													if(isset($_GET['month'])&& isset($_GET['year'])){
														$month=$_GET['month'];
														$year=$_GET['year'];
													}else{
														if(isset($_GET['date'])){
															$month = date("n", strtotime($_GET['date'])); 
															$year = date("Y", strtotime($_GET['date']));
														}else {
															$month = date("n", strtotime($date)); 
															$year = date("Y", strtotime($date));
														}
													}
													echo build_calendar_no_branch($month, $year); 													
												}else{
													$sBranch = $_GET['branchID'];
													$date = date("Y-m-d");
													$dateComponents = getdate(); 
													if(isset($_GET['month'])&& isset($_GET['year'])){
														$month=$_GET['month'];
														$year=$_GET['year'];
													}else{
														if(isset($_GET['date'])){
															$month = date("n", strtotime($_GET['date'])); 
															$year = date("Y", strtotime($_GET['date']));
														}else {
															$month = date("n", strtotime($date)); 
															$year = date("Y", strtotime($date));
														}
													}
													echo build_calendar($month, $year, $conn, $sBranch); 													
												}
											?>												
										</div>									
									</div>
									<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 col-12">
										<div class="container">
											<div class="form-group">
												<label for="book_fullname">Name</label>
												<?php
													$sql = "SELECT firstname, lastname FROM user_profile WHERE user_id = '$user'";
													$result = $conn->query($sql);
													if($result -> num_rows > 0){
														$row = $result -> fetch_assoc();
												?>
													<input type="text" class="form-control" name="book_fullname" id="book_fullname" value="<?php echo ucfirst($row['firstname']).' '. ucfirst($row['lastname']);?>" disabled>
												<?php	
													}
												?>
											</div>										
											<div class="form-group pull-right">
												<label>Pet Name: <span class="text-danger">*</span></label>
												<select name="pet_name" class="form-control" id="pet_name" <?php if(!isset($_GET['date'])){ echo 'disabled';} ?>>
													<option value="" selected disabled>--SELECT PET NAME HERE--</option>
													<?php
														$sql = "SELECT * FROM pet_profile WHERE user_id = '$user' AND archive_status = '0'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															while($row = $result -> fetch_assoc()){
													?>
															<option value="<?php echo $row['pet_name']; ?>"><?php echo $row['pet_name']; ?></option>
													<?php
															}
														}
													?>
												</select>
											</div>
											<div class="form-group pull-right">
												<label>Branch:</label>
												<?php
													if(!isset($_GET['branchID'])){
												?>
													<input type="text" class="form-control" id="branches" name="branches" value="No Selected Branch" disabled>
												<?php
													}else{
														$aBranch = $_GET['branchID'];
														$sql = "SELECT * FROM branch WHERE branch_id = '$aBranch' AND status = '1' AND archive_status = '0'";
														$result = $conn->query($sql);
														if($result -> num_rows > 0){
															$row = $result -> fetch_assoc();
													?>
														<input type="text" class="form-control branches" id="<?php echo $aBranch; ?>" name="branches" value="<?php echo $row['name']; ?>" disabled>
													<?php
														}
													}
												?>
											</div>											
											<div class="form-group">
												<label for="book_date">Appointment Date</label>
												<?php
													if(!isset($_GET['date'])){
												?>
													<input type="text" class="form-control" id="book_date" name="book_date" value="No Selected Branch" disabled>
												<?php
													}else{
												?>
														<input type="text" class="form-control" id="book_date" name="book_date" value="<?php echo date("F d, Y", strtotime($_GET['date']));?>" disabled>
												<?php
													}
												?>
												
											</div>
											<div class="form-group pull-right" id="hide_services_disabled">
												<label>Services: <span class="text-danger">*</span></label>
												<select name="service" class="form-control" id="hide_book_service" disabled>
													<option value="" selected disabled>--SELECT SERVICES HERE--</option>
												</select>
											</div>
											<div id="display_services"></div>
											<button name="submit" type="submit" class="btn btn-primary mt-3 btn-block" id="book_btn" disabled>Set Appointment</button>
											<span id="msg_request"></span>
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
		<?php include('../../include/footer.php');?>
		<script src="<?php echo $web_root; ?>client/book/appointment/js/appointment.js"></script>
		<script src="<?php echo web_root; ?>plugins/select2/js/select2.js"></script>
	</body>
</html>
<?php 
function build_calendar_no_branch($month, $year) {
	$daysOfWeek = array('Sunday', 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	// How many days does this month contain?
	$numberDays = date('t',$firstDayOfMonth);
	// Retrieve some information about the first day of the
	// month in question.
	$dateComponents = getdate($firstDayOfMonth);
	// What is the name of the month in question?
	$monthName = $dateComponents['month'];
	// What is the index value (0-6) of the first day of the
	// month in question.
	$dayOfWeek = $dateComponents['wday'];
	// Create the table tag opener and day headers
	
	$datetoday = date('Y-m-d');
	$calendar = "<div class='table-responsive'><div class='text-center'>";
	$calendar .= "<table class='table table-bordered'>";
	$calendar .= "<div class='group'>
	<h2>$monthName $year</h2>";
	$calendar.= " <a href='index.php' class='btn btn-xs btn-primary text-center' data-month='".date('m')."' data-year='".date('Y')."'>Current Month</a> ";
	$calendar.= "<a href='index.php?month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."' class='btn btn-xs btn-primary'>Next Month</a><br></div>";
	$calendar .= "
	<div class='d-flex justify-content-center mt-3'>
			<div style='height:20px;width:20px;margin-right:5px;border:1px solid #dc3545;display: inline-block;background-color: #dc3545;margin-left:20px;'></div>Closed
			<div style='height:20px;width:20px;margin-right:5px;border:1px solid #28a745;display: inline-block;background-color: #28a745;margin-left:20px;'></div>Available Date
	</div>";
	$calendar .= "<tr><br>";

	// Create the calendar headers
	foreach($daysOfWeek as $day) {
		$calendar .= "<th  class='header'>$day</th>";
	} 
	
	// Create the rest of the calendar
	// Initiate the day counter, starting with the 1st.
	$currentDay = 1;
	$calendar .= "</tr><tr align='left'>";
	 // The variable $dayOfWeek is used to
	 // ensure that the calendar
	 // display consists of exactly 7 columns.
	if($dayOfWeek > 0) { 
		for($k=0;$k<$dayOfWeek;$k++){
			$calendar .= "<td  class='empty'></td>"; 
		}
	}
	
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	while ($currentDay <= $numberDays) {
		 //Seventh column (Saturday) reached. Start a new row.
		 if ($dayOfWeek == 7) {
			 $dayOfWeek = 0;
			 $calendar .= "</tr><tr align='left'>";
		 }
		  
		 $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		 $date = "$year-$month-$currentDayRel";
		 $dayname = strtolower(date('l', strtotime($date)));
		 $eventNum = 0;
		 $today = $date==date('Y-m-d')? "today" : "";
		 if($dayname == "sunday"){
			 $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs text-uppercase' disabled>Closed</button>";
		 }elseif($date<date('Y-m-d')){
			 $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs text-uppercase' disabled>Closed</button>";
		 }else{
			 $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='?date=".$date."' class='btn btn-success btn-xs text-uppercase text-left test' id='$date' style='pointer-events: none; background-color: #28a745;'>Select Branch</a>";
		 }
		 $calendar .="</td>";
		 //Increment counters
		 $currentDay++;
		 $dayOfWeek++;
	 }
	 
	 //Complete the row of the last week in month, if necessary
	 if ($dayOfWeek != 7) { 
		$remainingDays = 7 - $dayOfWeek;
		for($l=0;$l<$remainingDays;$l++){
			$calendar .= "<td class='empty'></td>"; 
		}
	 }
	 
	$calendar .= "</tr>";
	$calendar .= "</table></div></div>";
	return $calendar;
}

function build_calendar($month, $year, $conn, $branch) {
	$daysOfWeek = array('Sunday', 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	// How many days does this month contain?
	$numberDays = date('t',$firstDayOfMonth);
	// Retrieve some information about the first day of the
	// month in question.
	$dateComponents = getdate($firstDayOfMonth);
	// What is the name of the month in question?
	$monthName = $dateComponents['month'];
	// What is the index value (0-6) of the first day of the
	// month in question.
	$dayOfWeek = $dateComponents['wday'];
	// Create the table tag opener and day headers
	
	$datetoday = date('Y-m-d');
	$calendar = "<div class='table-responsive'><div class='text-center'>";
	$calendar .= "<table class='table table-bordered'>";
	$calendar .= "<div class='group'>
	<h2>$monthName $year</h2>";
	$calendar.= " <a href='?branchID=".$branch."' class='btn btn-xs btn-primary text-center' data-month='".date('m')."' data-year='".date('Y')."'>Current Month</a> ";
	$calendar.= "<a href='?branchID=".$branch."&month=".date('m', mktime(0, 0, 0, $month+1, 1, $year))."&year=".date('Y', mktime(0, 0, 0, $month+1, 1, $year))."' class='btn btn-xs btn-primary'>Next Month</a><br></div>";
	$calendar .= "
	<div class='d-flex justify-content-center mt-3'>
			<div style='height:20px;width:20px;margin-right:5px;border:1px solid #dc3545;display: inline-block;background-color: #dc3545;margin-left:20px;'></div>Closed
			<div style='height:20px;width:20px;margin-right:5px;border:1px solid #28a745;display: inline-block;background-color: #28a745;margin-left:20px;'></div>Available Date
	</div>";
	$calendar .= "<tr><br>";

	// Create the calendar headers
	foreach($daysOfWeek as $day) {
		$calendar .= "<th  class='header'>$day</th>";
	} 
	
	// Create the rest of the calendar
	// Initiate the day counter, starting with the 1st.
	$currentDay = 1;
	$calendar .= "</tr><tr align='left'>";
	 // The variable $dayOfWeek is used to
	 // ensure that the calendar
	 // display consists of exactly 7 columns.
	if($dayOfWeek > 0) { 
		for($k=0;$k<$dayOfWeek;$k++){
			$calendar .= "<td  class='empty'></td>"; 
		}
	}
	
	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	while ($currentDay <= $numberDays) {
		 //Seventh column (Saturday) reached. Start a new row.
		 if ($dayOfWeek == 7) {
			 $dayOfWeek = 0;
			 $calendar .= "</tr><tr align='left'>";
		 }
		  
		 $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
		 $date = "$year-$month-$currentDayRel";
		 $dayname = strtolower(date('l', strtotime($date)));
		 $eventNum = 0;
		 $today = $date==date('Y-m-d')? "today" : "";
		 if($dayname == "sunday"){
			 $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs text-uppercase' disabled>Closed</button>";
		 }elseif($date<date('Y-m-d')){
			 $calendar.="<td><h4>$currentDay</h4> <button class='btn btn-danger btn-xs text-uppercase' disabled>Closed</button>";
		 }else{
			 $totalbook = checkSlot($conn, $date, $branch);
			  $getallTime = getTotalTime($conn, $branch);
			 if($getallTime == 0){
				 $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='?branchID=".$branch."&date=".$date."' class='btn btn-danger btn-xs text-uppercase text-left test' id='$date' style='pointer-events: none; background-color: grey;border:1px solid grey;'>No Available Time</a>";
			 }elseif($totalbook == $getallTime){
				 $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='?branchID=".$branch."&date=".$date."' class='btn btn-danger btn-xs text-uppercase text-left test' id='$date' style='pointer-events: none; background-color: red;'>Fully Booked</a>";
			 }else{
				 $availableSlot = $getallTime - $totalbook;
				 $calendar.="<td class='$today'><h4>$currentDay</h4> <a href='?branchID=".$branch."&date=".$date."' class='btn btn-success btn-xs text-uppercase text-left test' id='$date'>Book</a> <br>$availableSlot Slot Left";
			 }
		 }
		 $calendar .="</td>";
		 //Increment counters
		 $currentDay++;
		 $dayOfWeek++;
	 }
	 
	 //Complete the row of the last week in month, if necessary
	 if ($dayOfWeek != 7) { 
		$remainingDays = 7 - $dayOfWeek;
		for($l=0;$l<$remainingDays;$l++){
			$calendar .= "<td class='empty'></td>"; 
		}
	 }
	 
	$calendar .= "</tr>";
	$calendar .= "</table></div></div>";
	return $calendar;
}

function checkSlot($conn, $date, $branch){
	$sql = "SELECT * FROM appointments WHERE date = '$date' AND branch_id = '$branch' AND shows = '1'";
	$result = $conn->query($sql);
	$totalbook = 0;
	if($result -> num_rows > 0){
		while($row = $result -> fetch_assoc()){
			$totalbook++;
		}
	}
	return $totalbook;
}

function getTotalTime($conn, $branch){
	$sql = "SELECT * FROM time_schedule WHERE branch_id = '$branch' AND status = '1' AND archive_status = '0'";
	$result = $conn->query($sql);
	$allTime = 0;
	if($result -> num_rows > 0){
		while($row = $result -> fetch_assoc()){
			$allTime++;
		}
	}
	return $allTime;
}
?> 