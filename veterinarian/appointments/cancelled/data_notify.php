<?php
require_once("../../../include/initialize.php");

$sql = "SELECT icon, url, title, date, time, status FROM notification WHERE receiver = 'veterinarian' AND archive_status = '0' ORDER BY notify_id DESC LIMIT 10";
$result = $conn->query($sql);
$output = '';
if($result -> num_rows > 0){
	while($row = $result-> fetch_assoc()){
		$time = strtotime($row['date'] .' '. $row['time']);
		
		if($row['status'] == '1'){
			$output .=
				'<div class="dropdown-divider"></div>
				<a href="'.$row['url'].'" class="dropdown-item">
					<div class="row">
						<div class="col-lg-2 col-2">
							<i class="fa '.$row['icon'].' mr-2 mt-2" style="font-size:30px;"></i>
						</div>
						<div class="col-lg-8 col-8">
							'.$row['title'].'<br>
							<span class="text-muted text-sm">'.humanTiming($time).'</span>
						</div>
						<div class="col-lg-2 col-2 align-self-center">
							<span style="font-size:7px;color:rgba(44, 105, 201);"><i class="fa fa-circle"></i></span>
						</div>
					</div>
				</a>';			
		}else{
			$output .=
				'<div class="dropdown-divider"></div>
				<a href="'.$row['url'].'" class="dropdown-item">
					<div class="row">
						<div class="col-lg-2 col-2">
							<i class="fa '.$row['icon'].' mr-2 mt-2" style="font-size:30px;"></i>
						</div>
						<div class="col-lg-8 col-8">
							'.$row['title'].'<br>
							<span class="text-muted text-sm">'.humanTiming($time).'</span>
						</div>
						<div class="col-lg-2 col-2" hidden>
							<i class="fa fa-circle mr-2 mt-3" style="font-size:7px;color:rgba(44, 105, 201);"></i>
						</div>
					</div>
				</a>';			
		}
	}
}else{
	$output .=
	'<div class="dropdown-divider"></div>
	<a class="dropdown-item">
		<i class="fa fa-bell-slash mr-2"></i> No Notification
	</a>';	
}
echo $output;

function humanTiming ($time){
	$time = time() - $time; // to get the time since that moment
	$time = ($time<1)? 1 : $time;
	$tokens = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
	);

	foreach ($tokens as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s ago':'');
	}
}
?>