var web_root = $('#web_root').html();

$(document).ready(function() {
	$('#login-btn-close').click(function() {
		location.reload();
	});	
	$('#index-btn-close').click(function() {
		location.reload();
	});	
	$('#register-btn-close').click(function() {
		location.reload();
	});
	$('#forgot-btn-close').click(function() {
		location.reload();
	});	
});	

$(document).ready(function() {
	$("#login_password_show").click(function(e) {
		if($('#admin-password').attr('type') == 'text') {
			$('#admin-password').attr('type', 'password');
		} else {
			$('#admin-password').attr('type', 'text');
		}
	});
	$("#create_password_show").click(function(e) {
		if($('#password').attr('type') == 'text') {
			$('#password').attr('type', 'password');
		} else {
			$('#password').attr('type', 'text');
		}
	});
});	


$(document).ready(function() {
	$('#register-btn').click(function() {
		$('#login').modal('hide');
	});
	$('#forgot-btn').click(function() {
		$('#login').modal('hide');
	});
	$('#log-btn').click(function() {
		$('#register').modal('hide');
	});		
	$('#reg-btn').click(function() {
		$('#forgot').modal('hide');
	});	
	$('#login-btn').click(function() {
		$('#forgot').modal('hide');
	});
	
	$('#index-login').click(function() {
		$('#appointment').modal('hide');
	});		
	
	$('#admin-login').click(function() {
		$('#login').modal('hide');
	});	

	$('#index-register-btn').click(function() {
		$('#appointment').modal('hide');
	});
	$('#index-forgot-btn').click(function() {
		$('#appointment').modal('hide');
	});
	$('#terms-btn-login').click(function() {
		$('#login').modal('hide');
	});
	$('#terms-btn-register').click(function() {
		$('#register').modal('hide');
	});
	$('#terms-btn-forgot').click(function() {
		$('#forgot').modal('hide');
	});
	$('#terms-btn-index').click(function() {
		$('#appointment').modal('hide');
	});
	
});

$(document).ready(function() {
	var first_counts = 0;
	var last_counts = 0;
	var email_counts = 0;
	var pass_length_counts = 0;
	var pass_capital_counts = 0;
	var pass_number_counts = 0;
	var pass_symbol_counts = 0;
	$('#firstname').keyup(function(){
		var firstname = $(this).val();
		if(firstname.length >= 2){
			document.getElementById('err_firstname').innerHTML = "";
			first_counts = 1;
		}else{
			document.getElementById('err_firstname').innerHTML = "<code>First name must be more than 2 characters</code>";
			first_counts = 0;
		}
	});
	$('#lastname').keyup(function(){
		var lastname = $(this).val();
		if(lastname.length >= 2){
			document.getElementById('err_lastname').innerHTML = "";
			last_counts = 1;
		}else{
			document.getElementById('err_lastname').innerHTML = "<code>Last name must be more than 2 characters</code>";
			last_counts = 0;
		}
	});	
	$('#register-email').keyup(function() {
		if(this.value != ''){
			if(validateEmail(this.value)){
				document.getElementById('err_email').innerHTML = "";
				email_counts = 1;
			}else{
				document.getElementById('err_email').innerHTML = "<code>Email address is invalid.</code>";
				email_counts = 0;
			}			
		}else{
			document.getElementById('err_email').innerHTML = "<code>Please enter your email address.</code>";
			email_counts = 0;
		}
	});
	
	function validateEmail(email) {
		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		return emailReg.test( email );
	}
	
	$('#password').keyup(function() {
		$('#pass_valid').removeAttr('hidden', 'hidden');
		var pass = $(this).val();
		if(pass.length >= 3){
			document.getElementById('pass_letter').innerHTML = '<span class="text-success"><i class="bi bi-check"></i> contains at least 3 characters</span><br>';
			pass_length_counts = 1;
		}else{
			document.getElementById('pass_letter').innerHTML = '<span class="text-danger"><i class="bi bi-x"></i> contains at least 3 characters</span><br>';
			pass_length_counts = 0;
		}
		var capitalLetters = /[A-Z]/;
		if(pass.search(capitalLetters) < 0){
			document.getElementById('pass_capital').innerHTML = '<span class="text-danger"><i class="bi bi-x"></i> contains at least 1 uppercase letters</span><br>';
			pass_capital_counts = 0;
		}else{
			document.getElementById('pass_capital').innerHTML = '<span class="text-success"><i class="bi bi-check"></i> contains at least 1 uppercase letters</span><br>';
			pass_capital_counts = 1;
		}
		var digits = /[0-9]/;
		if(pass.search(digits) < 0){
			document.getElementById('pass_digit').innerHTML = '<span class="text-danger"><i class="bi bi-x"></i> contains at least 1 Number</span><br>';
			pass_number_counts = 0;
		}else{
			document.getElementById('pass_digit').innerHTML = '<span class="text-success"><i class="bi bi-check"></i> contains at least 1 Number</span><br>';
			pass_number_counts = 1;
		}
		var symbols = /[_~\-!@#\$%\^&\*\(\)]/;
		if(pass.search(symbols) < 0){
			document.getElementById('pass_symbol').innerHTML = '<span class="text-danger"><i class="bi bi-x"></i> contains at least 1 Special Symbols with only : _ ~ - ! @ # $ % ^ & * ( )</span><br>';
			pass_symbol_counts = 0;
		}else{
			document.getElementById('pass_symbol').innerHTML = '<span class="text-success"><i class="bi bi-check"></i> contains at least 1 Special Symbols with only : _ ~ - ! @ # $ % ^ & * ( )</span><br>';
			pass_symbol_counts = 1;
		}
	});

	$('#firstname').keyup(function(){
		if(first_counts == 1 && last_counts == 1 && email_counts == 1&& pass_length_counts == 1 && pass_capital_counts == 1 && pass_number_counts == 1 && pass_symbol_counts == 1){
			$('#register-login').removeAttr('disabled', 'disabled');
		}else{
			$('#register-login').attr('disabled', 'disabled');
		}
	});
	$('#lastname').keyup(function(){
		if(first_counts == 1 && last_counts == 1 && email_counts == 1&& pass_length_counts == 1 && pass_capital_counts == 1 && pass_number_counts == 1 && pass_symbol_counts == 1){
			$('#register-login').removeAttr('disabled', 'disabled');
		}else{
			$('#register-login').attr('disabled', 'disabled');
		}
	});
	$('#register-email').keyup(function(){
		if(first_counts == 1 && last_counts == 1 && email_counts == 1&& pass_length_counts == 1 && pass_capital_counts == 1 && pass_number_counts == 1 && pass_symbol_counts == 1){
			$('#register-login').removeAttr('disabled', 'disabled');
		}else{
			$('#register-login').attr('disabled', 'disabled');
		}
	});
	
	$('#password').keyup(function(){
		if(first_counts == 1 && last_counts == 1 && email_counts == 1&& pass_length_counts == 1 && pass_capital_counts == 1 && pass_number_counts == 1 && pass_symbol_counts == 1){
			$('#register-login').removeAttr('disabled', 'disabled');
		}else{
			$('#register-login').attr('disabled', 'disabled');
		}
	});
});

// Forgot Password 
$(document).ready(function() {
	$('#forgot-login').click(function(e) {
		e.preventDefault();
		var email = $('#forgot-email').val();
		$('#forgot-login').attr('disabled', 'disabled');
		if(email != ''){
			$.post("forgot-password.php", {email : email})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Reset Password",
						icon : "success",
						html: "Successfully reset your password. Please check your email for new password",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
						$('#forgot-login').removeAttr('disabled', 'disabled');
					});
				}else if(data == "no_data"){
					Swal.fire({
						title : "Reset Password",
						icon : "warning",
						html: "Cannot find email adress",
						showCloseButton: true,
						showConfirmButton:false						
					}).then(function() {
						$('#forgot-login').removeAttr('disabled', 'disabled');
					});					
				}else{
					Swal.fire({
						title : "Reset Password",
						icon : "warning",
						text: "Something wrong in reset password.",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						$('#forgot-login').removeAttr('disabled', 'disabled');
					});	
				}
			});
		}else {
			Swal.fire({
				title : "Reset Password",
				icon : "info",
				html: "Please enter a valid email address",
				showCloseButton: true,
				showConfirmButton:false						
			}).then(function() {
				$('#forgot-login').removeAttr('disabled', 'disabled');
			});			
		}
	});
});

// Index Login
$(document).ready(function() {
	$('#index-login').click(function(e) {
		e.preventDefault();
		var email = $('#client-email').val();
		var pass = $('#client-password').val();
		if(email != '' && pass != ''){
			$.post("book.php", {email : email, pass : pass})
			.done(function(data) {
				if(data == "client"){
					Swal.fire({
						title : "Account Credential",
						icon : "success",
						html: "Successfully logged in to your account.",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"client/";
					});
				}else if(data == "attempt"){
					Swal.fire({
						title: "Account Credential",
						icon: "info",
						text: 'Login Exceed Limit Wait 1 minute to login',
						showCloseButton: true,
						showConfirmButton:false
					}).then(function() {
						startTimer();
					});
				}else if(data == "no_account"){
					Swal.fire({
						title : "Account Credential",
						icon : "info",
						html: "Email address or Password is incorrect! Please Try Again.",
						showCloseButton: true,
						showConfirmButton:false							
					});	                  
				}else if(data == 'verify'){
					$("#verify").modal("show");
				}else if(data == 'archive'){
					Swal.fire({
						title : "Account Credential",
						icon : "warning",
						text: "Something wrong in your account credentials. Please contact the administrator.",
						showCloseButton: true,
						showConfirmButton:false								
					});	 
				}else if(data == 'error'){
					Swal.fire({
						title : "Account Credential",
						icon : "info",
						html: "Only the Pet Owner can Schedule an Appointment ",
						showCloseButton: true,
						showConfirmButton:false							
					});
				}else{
					Swal.fire({
						title : "Account Credential",
						icon : "error",
						html: "Invalid Email and Password Please try again",
						showCloseButton: true,
						showConfirmButton:false							
					});
				}
			});			
		}else {
			Swal.fire({
				title : "Account Credential",
				icon : "info",
				html: "Please enter a valid password and email address and password",
				showCloseButton: true,
				showConfirmButton:false						
			});
		}		
	});
});

// create account
$(document).ready(function() {
	$('#register-login').click(function(e) {
		e.preventDefault();
		$('#register-login').attr('disabled', 'disabled');
		document.getElementById("msg").innerHTML = "<p class='text-success'>Creating an account... Please Wait</p>";
		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var email = $('#register-email').val();
		var pass = $('#password').val();
		if(firstname != '' && lastname != '' && email != '' && pass != ''){
			$.post("create-account.php", {firstname : firstname, lastname : lastname, email : email, pass : pass})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Account Created Successfully",
						icon : "success",
						html: "A verification code has been sent to your email address to activate your account.",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});			
				}else if(data == "error_create"){
					Swal.fire({
						title : "Create Account",
						icon : "error",
						html: "Failed to create account",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						$('#register-login').removeAttr('disabled', 'disabled');
						$('#msg').attr('hidden', 'hidden');
					});	
				}else if(data == "exist"){
					Swal.fire({
						title : "Account Creation Failed",
						icon : "warning",
						html: "Email address is already exists!",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						$('#register-login').removeAttr('disabled', 'disabled');
						$('#msg').attr('hidden', 'hidden');
					});		
				}else {
					Swal.fire({
						title : "Create Account",
						icon : "error",
						html: "Failed to create account",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						$('#register-login').removeAttr('disabled', 'disabled');
						$('#msg').attr('hidden', 'hidden');
					});
				}
			});
		}else {
			Swal.fire({
				title : "Create Account",
				icon : "error",
				html: "Please fill-up all required forms",
				showCloseButton: true,
				showConfirmButton:false							
			}).then(function() {
				$('#register-login').removeAttr('disabled', 'disabled');
				$('#msg').attr('hidden', 'hidden');
			});
		}
	});
});

// login admin
$(document).ready(function() {
	$('#admin-email').focus();
	$('#admin-login').click(function(e) {
		e.preventDefault();
		var email = $('#admin-email').val();
		var pass  = $('#admin-password').val();
		if(email != '' && pass != ''){
			$.post("login.php", {email : email, pass : pass})
			.done(function(data) {
				if(data == "administrator"){
					Swal.fire({
						title : "Login Successfully",
						icon : "success",
						html: "Successfully logged in to your account.",
						timer: 5000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"admin/";
					});
				}else if(data == 'veterinarian'){
					Swal.fire({
						title : "Login Successfully",
						icon : "success",
						html: "Successfully logged in to your account.",
						timer: 5000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"veterinarian/";
					});
				}else if(data == "attempt"){
					Swal.fire({
						title: "Login Limit",
						icon: "info",
						text: 'Login Exceed Limit Wait 1 minute to login',
						showCloseButton: true,
						showConfirmButton:false
					}).then(function() {
						startTimer();
					});
				}else if(data == "no_account"){
					Swal.fire({
						title : "Authentication failed",
						icon : "info",
						html: "You have entered an invalid email or password.",
						timer: 5000,
						showConfirmButton:false							
					});                  
				}else if(data == 'client'){
					Swal.fire({
						title : "Login Successfully",
						icon : "success",
						html: "Successfully logged in to your account.",
						timer: 5000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"client/";
					});
				}else if(data == 'verify'){
					$("#verify").modal("show");
				}else if(data == 'archive'){
					Swal.fire({
						title : "Account Credential",
						icon : "warning",
						text: "Something wrong in your account credentials. Please contact the administrator.",
						showCloseButton: true,
						showConfirmButton:false								
					});	                  
				}else{
					Swal.fire({
						title : "Login Failed",
						icon : "error",
						html: "Invalid Email address or password",
						showCloseButton: true,
						showConfirmButton:false							
					});
				}
			});			
		}else {
			Swal.fire({
				title : "Login Failed",
				icon : "info",
				html: "Please enter a valid password and email address and password",
				showCloseButton: true,
				showConfirmButton:false							
			});
		}
	});
});

$(document).ready(function() {
	$('#activate-login').click(function(e) {
		e.preventDefault();
		var code = $('#activation-code').val();
		if(code != ''){
			$.post("activation.php", {code : code})
			.done(function(data) {
				if(data == "administrator"){
					Swal.fire({
						title : "Account Activated",
						icon : "success",
						html: "Your account has been successfully activated! Please wait..",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"admin/";
					});
				}else if(data == 'veterinarian'){
					Swal.fire({
						title : "Account Activated",
						icon : "success",
						html: "Your account has been successfully activated! Please wait..",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"veterinarian/";
					});
				}else if(data == 'client'){
					Swal.fire({
						title : "Account Activated",
						icon : "success",
						html: "Your account has been successfully activated! Please wait..",
						showCloseButton: true,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"client/";
					});
				}else{
					Swal.fire({
						title : "Failed",
						icon : "error",
						html: "You have entered an invalid activation code! Please try again.",
						timer: 1500,
						showCloseButton: true,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Activation Code",
				icon : "info",
				html: "Enter the valid activation code",
				showCloseButton: true,
				showConfirmButton:false							
			});			
		}
	});
});