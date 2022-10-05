$(document).ready(function() {
	$('#add_treatment').click(function(e) {
		e.preventDefault();
		var id = $('#treatment_id').html();
		var title = $('#treatment_title').val();
		var f_procedure = $('#f_procedure').val();
		var treatment_cost = $('#treatment_cost').val();
		if(title != '' && f_procedure != '' && treatment_cost != ''){
			$.post("treatment.php", {id:id, title:title,f_procedure:f_procedure,treatment_cost:treatment_cost})
			.done(function(data){
				if(data == "success"){
					Swal.fire({
						title : "Add Pet Treatment",
						icon : "success",
						html: "<strong>Success! </strong>add pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});					
				}else{
					Swal.fire({
						title : "Add Pet Treatment",
						icon : "error",
						html: "<strong>Failed! </strong>add pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Add Pet Treatment",
				icon : "info",
				html: "<b>Invalid! </b>Fill out all fields basic information.",
				timer: 3000,
				showConfirmButton:false							
			});				
		}
	});
});
// VIEW TREATMENT
$(document).ready(function(){
	$('.view-treatment').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url: "view_treatment.php",
			method: "POST",
			data: {id:id},
			success: function(data) {
				$('#view_treatment_modal').html(data);
			}
		});
	});
});
// EDIT TREATMENT
$(document).ready(function() {
	$('.edit-treatment').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url: "edit_treatment.php",
			method: "POST",
			data: {id:id},
			success: function(data) {
				$('#edit_treatment_modal').html(data);
			}
		});		
	});
});

$(document).ready(function() {
	$('.archive-treatment').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Treatment',
			html: "<b>Are you sure?</b> you want to archive this treatment?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_treatment.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Treatment",
							icon : "success",
							html: "<strong>Success! </strong>archive treatment.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Treatment",
							icon : "error",
							html: "<b>Failed!</b> archive treatment",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Treatment",
							icon : "warning",
							text: "Something wrong in archive treatment.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Treatment",
					icon : "error",
					html: "<b>Failed!</b> archive treatment",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});		
	});
});

// EDIT SAVE 
$(document).ready(function() {
	$('#edit_treatment').click(function(e) {
		e.preventDefault();
		var id = $('#etreatment_id').html();
		var title = $('#etreatment_title').val();
		var f_procedure = $('#ef_procedure').val();
		var n_procedure = $('#en_procedure').val();
		var cost = $('#etreatment_cost').val();
		if(title != '' && f_procedure != '' && n_procedure == undefined && cost != ''){
			$.post("edit_treatment_data_np.php", {id:id,title:title,f_procedure:f_procedure,cost:cost})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Edit Pet Treatment",
						icon : "success",
						html: "<strong>Success! </strong>edit pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});						
				}else{
					Swal.fire({
						title : "Edit Pet Treatment",
						icon : "error",
						html: "<strong>Failed! </strong>edit pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					});					
				}
			});
		}else{	
			$.post("edit_treatment_data.php", {id:id,title:title,f_procedure:f_procedure,n_procedure:n_procedure,cost:cost})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Edit Pet Treatment",
						icon : "success",
						html: "<strong>Success! </strong>edit pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});						
				}else{
					Swal.fire({
						title : "Edit Pet Treatment",
						icon : "error",
						html: "<strong>Failed! </strong>edit pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					});
					alert(data);
				}
			});
		}
	});
});
// UPDATE TREATMENT
$(document).ready(function() {
	$('#update_treatment').click(function(e) {
		e.preventDefault();
		var id = $('#utreatment_id').html();
		var title = $('#utreatment_title').val();
		var f_procedure = $('#uf_procedure').val();
		var n_procedure = $('#n_procedure').val();
		var cost = $('#utreatment_cost').val();
		var status = $('#treatment_status').val();
		if(title != '' && n_procedure != '' && cost != '' && status != null){
			$.post("update_treatment.php", {id:id,title:title,f_procedure:f_procedure,n_procedure:n_procedure,cost:cost,status:status})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Pet Treatment",
						icon : "success",
						html: "<strong>Success! </strong>update pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});					
				}else{
					Swal.fire({
						title : "Update Pet Treatment",
						icon : "error",
						html: "<strong>Failed! </strong>update pet treatment.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Update Pet Treatment",
				icon : "info",
				html: "<b>Invalid! </b>Fill out all fields basic information.",
				timer: 3000,
				showConfirmButton:false							
			});				
		}
	});
});

$('#treatment_cost').keypress(function(e) {
	$(this).val($(this).val().replace(/[^\d].+/, ""));
	if ((event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
});	

