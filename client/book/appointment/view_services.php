<?php
require_once("../../../include/initialize.php");

session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}

$output = "";
if(isset($_POST['id'])){
	$id = $_POST['id'];
	$sql = "SELECT service_id, service_title FROM services WHERE branch_id = '$id' AND status = '1' AND archive_status = '0' OR branch_id = 'all' AND status = '1' AND archive_status = '0'";
	$result = $conn->query($sql);
	if($result -> num_rows > 0){
		$output .= '
		<div class="form-group pull-right">
			<label>Services: <span class="text-danger">*</span></label>
			<select name="service" class="form-control" id="book_service">
				<option value="" selected disabled>--SELECT SERVICES HERE--</option>';
			while($row = $result -> fetch_assoc()){
				$output .= '<option value="'.$row['service_id'].'" class="text-uppercase">'.$row['service_title'].'</option>';
			}
		$output .= '
			</select>
		</div>		<script>
			$(document).ready(function() {
				$("#book_service").change(function(e) {
					e.preventDefault();
					$(".btnClick").removeAttr("disabled", "disabled");
				});
			});
		</script>
		';
	}
	echo $output;
}

?>
<div class="form-group" id="timeSelect" disabled>
	<label for="timeselector"  class="d-flex">Available Time: <span class="text-danger">*</span>
		<div class="ml-4">
			<div class="d-flex">
				<div class="justify-content-center align-self-center" style="height:20px;width:20px;margin-right:5px;border:1px solid #28a745;display: inline-block;vertical-align: middle;"></div>Available
				<div class="justify-content-center align-self-center" style="height:20px;width:20px;margin-right:5px;border:1px solid #dc3545;display: inline-block;background-color: #dc3545;margin-left:20px;"></div>Reserved
				<div class="justify-content-center align-self-center" style="height:20px;width:20px;margin-right:5px;border:1px solid #28a745;display: inline-block;background-color: #28a745;margin-left:20px;"></div>Selected
			</div>
		</div>
	</label>
	<div class="row">
			<?php
				if(isset($_POST['date'])){
					$date = date("Y-m-d", strtotime($_POST['date']));
					$sql = "SELECT * FROM appointments WHERE date = '$date' AND branch_id = '$id' AND shows = '1'";
					$result = $conn->query($sql);
					$bookings = array();
					if($result -> num_rows > 0){
						while($row = $result->fetch_assoc()){
							$bookings[] = $row['timeslot'];
						}											
					}
					$sql1 = "SELECT * FROM time_schedule WHERE branch_id = '$id' ORDER BY time ASC";
					$result1 = $conn->query($sql1);
					$branchTime = array();
					if($result1 -> num_rows > 0){
						while($row1 = $result1->fetch_assoc()){
							$branchTime[] = date("g:i A", strtotime($row1['time']));
						}											
					}else {
				?>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 mb-2">
				<p class="text-center h4 text-secondary">No Available Time</p>
			</div>
				<?php
					}
					if(!empty($bookings)){
						foreach($branchTime as $ts){
							if(in_array($ts, $bookings)){
							?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 mb-2">
									<button type="button" class="btn btn-danger btn-block" id="timeselector" value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></button>
								</div>
							<?php
							}else {
								$t = date("g:i A");
								$today = strtotime($t);
								$app = strtotime($ts);
								if($today > $app && $date == date("Y-m-d")){
								?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 mb-2">
									<button type="button" class="btn btn-danger btn-block" id="timeselector" value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></button>
								</div>
								<?php
								}else{
								?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 mb-2">
									<button type="button" class="btn btn-outline-success btn-block btnClick" id="timeselector" value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></button>
								</div>
								<?php
								}
							}
						}
					}else {
						foreach($branchTime as $ts){
							if(!in_array($ts, $bookings)){
								$t = date("g:i A");
								$today = strtotime($t);
								if($today > strtotime($ts) && $date == date("Y-m-d")){
								?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 mb-2">
									<button type="button" class="btn btn-danger btn-block" id="timeselector" value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></button>
								</div>
								<?php
								}else{
								?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-4 mb-2">
									<button type="button" class="btn btn-outline-success btn-block btnClick" id="timeselector" value="<?php echo $ts; ?>" disabled><?php echo $ts; ?></button>
								</div>
								<?php
								}								
							}
						}
					}
				}
			?>	

	</div>
</div>	
<script>
$(function() {
	var $btn = $(".btnClick").click(function() {
		$btn.not(this).removeClass("selectedTime");
		// removing `active` class from images except clicked
		$(this).toggleClass("selectedTime");
		$("#book_btn").removeAttr("disabled", "disabled");
	});
});	
</script>