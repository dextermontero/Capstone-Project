<?php
require_once("../../../include/initialize.php");
include("../../../include/ImageResize.php");
use \Gumlet\ImageResize;
session_start();
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../../");
}


$pet_name = verify($_POST['pet_name']);
$pet_type = verify($_POST['pet_type']);
$pet_breed = verify($_POST['pet_breed']);
$pet_birthdate = $_POST['pet_birthdate'];

if($pet_birthdate == ''){
  $save_location = '../../../dist/img/pet_profile/';
  $file = time().'_'.$_FILES['file']['name'];
  $path = $save_location.$file;
  $file_extension = pathinfo($path, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);	
  $valid_ext = array("jpeg","jpg","png");
  $resizeImage = $path;
  if(in_array($file_extension, $valid_ext)){
      if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
          $image = new ImageResize($path);
          $image->resize(516,515);
          $image->save($resizeImage);
          $sql = $conn->prepare("INSERT INTO pet_profile(user_id, pet_photo, pet_name, pet_type, pet_breed)VALUES(?, ?, ?, ?, ?)");
          $sql -> bind_param("sssss", $user, $file, $pet_name, $pet_type, $pet_breed);
          if($sql->execute()){
              $s = "SELECT user_id, firstname, lastname FROM user_profile WHERE user_id = '$user'";
              $r = $conn->query($s);
              if($r -> num_rows > 0){
                  $ro = $r -> fetch_assoc();
                  $id = $ro['user_id'];
                  $fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
                  $date = date("Y-m-d");
                  $time = date("H:i:s");
                  $activity = "<b>$fullname</b> adding new pet information at [Pet Name : $pet_name]";
                  $ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
                  $ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
                  if($ss->execute()){
                      echo 'success';
                  }else{
                      echo 'failed';
                  }
              }
          }else {
              echo 'failed';
          }				
      }
  }else {
      echo 'invalid';
  }  
  
  
}else{
  $save_location = '../../../dist/img/pet_profile/';
  $file = time().'_'.$_FILES['file']['name'];
  $path = $save_location.$file;
  $file_extension = pathinfo($path, PATHINFO_EXTENSION);
  $file_extension = strtolower($file_extension);	
  $valid_ext = array("jpeg","jpg","png");
  $resizeImage = $path;
  if(in_array($file_extension, $valid_ext)){
      if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
          $image = new ImageResize($path);
          $image->resize(516,515);
          $image->save($resizeImage);
          $sql = $conn->prepare("INSERT INTO pet_profile(user_id, pet_photo, pet_name, pet_type, pet_breed, pet_birthdate)VALUES(?, ?, ?, ?, ?, ?)");
          $sql -> bind_param("ssssss", $user, $file, $pet_name, $pet_type, $pet_breed, $pet_birthdate);
          if($sql->execute()){
              $s = "SELECT user_id, firstname, lastname FROM user_profile WHERE user_id = '$user'";
              $r = $conn->query($s);
              if($r -> num_rows > 0){
                  $ro = $r -> fetch_assoc();
                  $id = $ro['user_id'];
                  $fullname = ucfirst($ro['firstname']) .' '. ucfirst($ro['lastname']);
                  $date = date("Y-m-d");
                  $time = date("H:i:s");
                  $activity = "<b>$fullname</b> adding new pet information at [Pet Name : $pet_name]";
                  $ss = $conn->prepare("INSERT INTO audit_logs(login_id, name, date, time, activity) VALUES (?, ?, ?, ?, ?)");
                  $ss -> bind_param("sssss", $id, $fullname, $date, $time, $activity);
                  if($ss->execute()){
                      echo 'success';
                  }else{
                      echo 'failed';
                  }
              }
          }else {
              echo 'failed';
          }				
      }
  }else {
      echo 'invalid';
  }
}




function verify($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>