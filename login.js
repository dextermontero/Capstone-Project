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
});

$('#registration_form').bootstrapValidator({
	feedbackIcons: {
		valid: 'fa fa-check',
		invalid: 'fa fa-times',
		validating: 'fa fa-refresh'
	},
	fields: {
		firstname: {
			validators: {
				notEmpty: {
					message: 'The first name is required and cannot be empty'
				}
			}
		},
		lastname : {
			validators : {
				notEmpty: {
					message: 'The last name is required and cannot be empty'
				}
			}
		},
		email: {
			validators: {
				notEmpty: {
					message: '<code>The email address is required</code>'
				},
				regexp: {
					regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
					message: '<code>The email address is not a valid </code>'
				}
			}
		},
		password : {
			validators : {
				notEmpty: {
					message: 'The password is required and cannot be empty'
				}
			}
		},		
	}
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
						html: "<strong>Success! </strong>Check you email for your password",
						timer: 1500,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
						$('#forgot-login').removeAttr('disabled', 'disabled');
					});
				}else if(data == "no_data"){
					Swal.fire({
						title : "Reset Password",
						icon : "warning",
						html: "<strong>Not Found! </strong>email address you enter can't find. Please enter correctly",
						timer: 3000,
						showConfirmButton:false						
					}).then(function() {
						$('#forgot-login').removeAttr('disabled', 'disabled');
					});					
				}else{
					Swal.fire({
						title : "Reset Password",
						icon : "warning",
						text: "Something wrong in reset password.",
						timer: 1500,
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
				html: "<strong>Failed! </strong>enter your email address!",
				timer: 1500,
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
						title : "Login Successfully",
						icon : "success",
						html: "<strong>Success! </strong>login credentials",
						timer: 1000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"client/";
					});
				}else if(data == "attempt"){
					Swal.fire({
						title: "Login Limit",
						icon: "info",
						text: 'Login Exceed Limit Wait 1 minute to login',
						timer: 3000,
						showConfirmButton:false
					}).then(function() {
						startTimer();
					});
				}else if(data == "no_account"){
					Swal.fire({
						title : "No Account",
						icon : "info",
						html: "<strong>Info! </strong>you don't have an account",
						timer: 1500,
						showConfirmButton:false							
					});	                  
				}else if(data == 'verify'){
					$("#verify").modal("show");
				}else if(data == 'archive'){
					Swal.fire({
						title : "Account Credential",
						icon : "warning",
						text: "Something wrong in your account credentials. Please contact the administrator.",
						timer: 3000,
						showConfirmButton:false								
					});	 
				}else if(data == 'error'){
					Swal.fire({
						title : "Login Failed",
						icon : "error",
						html: "<strong>Failed! </strong>only customer can login this book appointment",
						timer: 1500,
						showConfirmButton:false							
					});
				}else{
					Swal.fire({
						title : "Login Failed",
						icon : "error",
						html: "<strong>Failed! </strong>invalid credentials",
						timer: 1500,
						showConfirmButton:false							
					});
				}
			});			
		}else {
			Swal.fire({
				title : "Login Failed",
				icon : "info",
				html: "<strong>Failed! </strong>enter your email and password!",
				timer: 1500,
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
		var pass = $('#register-password').val();
		if(firstname != '' && lastname != '' && email != '' && pass != ''){
			$.post("create-account.php", {firstname : firstname, lastname : lastname, email : email, pass : pass})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Create Account",
						icon : "success",
						html: "<strong>Success! </strong>An Email verification code has been send to your email to verify your account",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});			
				}else if(data == "error_create"){
					Swal.fire({
						title : "Create Account",
						icon : "error",
						html: "<strong>Failed! </strong>creation of account",
						timer: 1500,
						showConfirmButton:false							
					}).then(function() {
						$('#register-login').removeAttr('disabled', 'disabled');
						$('#msg').attr('hidden', 'hidden');
					});	
				}else if(data == "exist"){
					Swal.fire({
						title : "Create Account",
						icon : "warning",
						html: "<strong>Email Address! </strong>is already exist!",
						timer: 2000,
						showConfirmButton:false							
					}).then(function() {
						$('#register-login').removeAttr('disabled', 'disabled');
						$('#msg').attr('hidden', 'hidden');
					});		
				}else {
					Swal.fire({
						title : "Create Account",
						icon : "error",
						html: "<strong>Failed! </strong>creation of account",
						timer: 1500,
						showConfirmButton:false							
					}).then(function() {
						$('#register-login').removeAttr('disabled', 'disabled');
						$('#msg').attr('hidden', 'hidden');
					});
				}
			});
		}else {
			Swal.fire({
				title : "Create Account Failed",
				icon : "error",
				html: "<strong>Failed! </strong>creation of account",
				timer: 1500,
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
						html: "<strong>Success! </strong>login credentials",
						timer: 1000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"admin/";
					});
				}else if(data == 'veterinarian'){
					Swal.fire({
						title : "Login Successfully",
						icon : "success",
						html: "<strong>Success! </strong>login credentials",
						timer: 1000,
						showConfirmButton:false							
					}).then(function() {
						window.location = web_root+"veterinarian/";
					});
				}else if(data == "attempt"){
					Swal.fire({
						title: "Login Limit",
						icon: "info",
						text: 'Login Exceed Limit Wait 1 minute to login',
						timer: 3000,
						showConfirmButton:false
					}).then(function() {
						startTimer();
					});
				}else if(data == "no_account"){
					Swal.fire({
						title : "No Account",
						icon : "info",
						html: "<strong>Info! </strong>you don't have an account",
						timer: 1500,
						showConfirmButton:false							
					});                  
				}else if(data == 'client'){
					Swal.fire({
						title : "Login Successfully",
						icon : "success",
						html: "<strong>Success! </strong>login credentials",
						timer: 1000,
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
						timer: 3000,
						showConfirmButton:false								
					});	                  
				}else{
					Swal.fire({
						title : "Login Failed",
						icon : "error",
						html: "<strong>Failed! </strong>invalid credentials",
						timer: 1500,
						showConfirmButton:false							
					});
				}
			});			
		}else {
			Swal.fire({
				title : "Login Failed",
				icon : "info",
				html: "<strong>Failed! </strong>enter your email and password!",
				timer: 1500,
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