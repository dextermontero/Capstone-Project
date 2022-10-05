<?php
if($_SESSION['roles'] == 'client'){
	$user = $_SESSION['login_id'];
}else{
	header("location: ../../");
}
?>
<!-- jQuery -->
<script src="<?php echo web_root; ?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo web_root; ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo web_root; ?>dist/js/adminlte.min.js"></script>
<!-- Datatables -->
<script src="<?php echo web_root; ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo web_root; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo web_root; ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo web_root; ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Sweet Alert -->
<script src="<?php echo web_root; ?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Datatables Information -->	
<script src="<?php echo web_root; ?>js/datatables/client/datatables_info.js"></script>
<script src="<?php echo web_root; ?>veterinarian/js/notification.js"></script>