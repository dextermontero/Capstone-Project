<?php
class DB {
    // Database credentials
    private $dbHost     = "mysql5047.site4now.net";
    private $dbUsername = "a7d59c_embat";
    private $dbPassword = "Embat@143";
    private $dbName     = "db_a7d59c_embat";
 
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }
  
    // Check is table empty
    public function is_table_empty() {
        $result = $this->db->query("SELECT id FROM token");
        if($result->num_rows) {
            return false;
        }
  
        return true;
    }
  
    // Get access token
    public function get_access_token() {
        $sql = $this->db->query("SELECT access_token FROM token");
        $result = $sql->fetch_assoc();
        return json_decode($result['access_token']);
    }
  
    // Get referesh token
    public function get_refersh_token() {
        $result = $this->get_access_token();
        return $result->refresh_token;
    }
	
    // Update access token
    public function update_access_token($token) {
		$sql = $this->db->query("DELETE FROM token");
		if($sql){
			 $this->db->query("INSERT INTO token(access_token) VALUES('$token')");
		}else {
			$this->db->query("INSERT INTO token(access_token) VALUES('$token')");
		}
		
		
		
        /*if($this->is_table_empty()) {
            $this->db->query("INSERT INTO token(access_token) VALUES('$token')");
        } else {
            $this->db->query("UPDATE token SET access_token = '$token' WHERE id = (SELECT id FROM token)");
        }*/
    }
	/*
    public function upd	ate_token($token) {
    	$this->db->query("UPDATE token SET access_token = '$token' WHERE id = (SELECT id FROM token)");
    }*/  

	// Insert Meeting Database

	public function save_meetings($user, $to, $topic, $meeting_id, $url, $pass, $date, $time){
		$result = $this->db->query("INSERT INTO zoom_meeting(login_id, to_client, topic, meeting_id, link, password, date, time)VALUES('$user', '$to', '$topic', '$meeting_id', '$url', '$pass', '$date', '$time')");
		if($result){
			//NOTIFICATION
			$category = 'appointment';
			$services = 'Online Consultation';
			$icon = 'fas fa-video';
			$title = 'Update Video Consultation';
			$nstatus = 'scheduled';
			$ndate = date("Y-m-d");
			$vID = time();
			$ntime = date("H:i");
			$notif_status = '1';
			$url = web_root.'client/meeting/?notif_id='.$vID.'&category='.$category.'&services='.$services.'&appointment_id='.$vID.'&date='.$date.'&time='.$time;
			$result2 = $this->db->query("INSERT INTO notification(id, sender, receiver, category, services, icon, url, title, date, time, status)VALUES('$vID', '$user', '$to', '$category', '$services', '$icon', '$url', '$title', '$ndate', '$ntime', '$notif_status')");
			if($result2){
				echo 'success';
			}else{
				echo 'failed';
			}
		}else{
			echo 'failed';
		}		
	}	
	// Update Meeting Database
	public function update_meetings($meeting_id, $topic, $date, $time){
		$result = $this->db->query("UPDATE zoom_meeting SET topic = '$topic', date = '$date', time = '$time' WHERE meeting_id = '$meeting_id'");
		if($result){
			echo 'success';
		}else{
			echo 'failed';
		}
	}
	
	// Delete Meeting Database
	public function delete_meeting($meeting_id){
		$result = $this->db->query("DELETE FROM zoom_meeting WHERE meeting_id = '$meeting_id'");
		if($result){
			echo 'success';
		}else{
			echo 'failed';
		}
	}
}