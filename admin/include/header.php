<?php
if($_SESSION['roles'] == 'administrator' || $_SESSION['roles'] == 'superadmin'){
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
<!-- Data Tables -->
<link rel="stylesheet" href="<?php echo web_root; ?>dist/css/adminlte.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<!-- Sweet Alert 2 -->
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/sweetalert2/sweetalert2.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="<?php echo web_root; ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo web_root; ?>dist/css/custom.css">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo web_root; ?>dist/img/icons/logo.ico" />