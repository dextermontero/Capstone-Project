<?php
if($_SESSION['roles'] == 'veterinarian'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../");
}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/fontawesome-free/css/all.min.css">
<!-- Ionicons -->
<!-- Data Tables -->
<link rel="stylesheet" href="<?php echo web_root; ?>dist/css/adminlte.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo web_root; ?>dist/css/adminlte.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Sweet Alert 2 -->
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/sweetalert2/sweetalert2.min.css">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo web_root; ?>dist/img/icons/logo.ico" />	
