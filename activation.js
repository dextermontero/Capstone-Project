$(document).ready(function() {
	$('#activate-login').click(function(e) {
		e.preventDefault();
		var code = $('#activation-code').val();
		if(code != ''){
			$.post("activation.php", {code : code})
			.done(function(data) {
				if(data == "administrator"){
					Swal.fire({
						title : "Activation Code",
						icon : "success",
						html: "<strong>Success! </strong>Activation of account <b>Please Wait...</b>",
						timer: 5000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"admin/";
					});
				}else if(data == 'veterinarian'){
					Swal.fire({
						title : "Activation Code",
						icon : "success",
						html: "<strong>Success! </strong>Activation of account <b>Please Wait...</b>",
						timer: 5000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"veterinarian/";
					});
				}else if(data == 'client'){
					Swal.fire({
						title : "Activation Code",
						icon : "success",
						html: "<strong>Success! </strong>Activation of account <b>Please Wait...</b>",
						timer: 5000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"client/";
					});
				}else{
					Swal.fire({
						title : "Activation Code",
						icon : "error",
						html: "<strong>Failed! </strong>invalid activation code",
						timer: 1500,
						showConfirmButton:false							
					});
					alert(data);
				}
			});
		}else{
			Swal.fire({
				title : "Activation Code",
				icon : "info",
				html: "<strong>Information! </strong>enter the activation code from send to your email!",
				timer: 1500,
				showConfirmButton:false							
			});			
		}
	});
});