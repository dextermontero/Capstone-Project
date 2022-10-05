$(document).ready(function() {
	$('.archive-branch').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Branch',
			html: "Are you sure to archive this branch information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_branch.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Branch",
							icon : "success",
							html: "Successfully archived branch information",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Branch",
							icon : "error",
							html: "Failed archived branch information",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Branch",
							icon : "warning",
							text: "Something wrong in archiving branch information.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Branch",
					icon : "error",
					html: "Cancelling archive branch information",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});					
	});
});

$(document).ready(function() {
	$('#edit_branch').click(function(e) {
		e.preventDefault();
		var id = $('#branchID').html();
		var name = $('#edit_branch_name').val();
		var address = $('#edit_branch_address').val();
		if(name != '' && address != ''){
			$.post("update_branch.php", {id: id, name : name, address : address})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Branch",
						icon : "success",
						html: "Successfully updated branch information",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});								
				}else{
					Swal.fire({
						title : "Update Branch",
						icon : "error",
						html: "Failed updated branch information",
						timer: 3000,
						showConfirmButton:false							
					});								
				}
			});
		}else{
			Swal.fire({
				title : "Add Branch",
				icon : "info",
				html: "Fill out all required fields!",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});
});

document.onreadystatechange = function () {
	if (document.readyState === 'interactive' || document.readyState === 'loading') {
		document.getElementById("view_branch_modal").innerHTML = '<div class="mx-auto text-center"><img src="http://vawvetclinic.info/dist/img/loading-buffering.gif" class="h-100 w-50 p-4"></div>';
	}else if (document.readyState === 'complete') {
		$('.view-branch').click(function(e) {
			var bid = $(this).attr('id');
			$.ajax({
				url : "view_branch.php",
				method : "POST",
				data : {bid : bid},
				success:function(data){
					$('#view_branch_modal').html(data);
				}
			});
		});
	}
}

$(document).ready(function() {
	$('#add_branch').click(function(e) {
		e.preventDefault();
		var name = $('#branch_name').val();
		var address = $('#branch_address').val();
		if(name != '' && address != ''){
			$.post("add_branch.php", {name : name, address : address})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Add Branch",
						icon : "success",
						html: "Successfully added branch",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});								
				}else{
					Swal.fire({
						title : "Add Branch",
						icon : "error",
						html: "Failed add branch",
						timer: 3000,
						showConfirmButton:false							
					});								
				}
			});
		}else{
			Swal.fire({
				title : "Add Branch",
				icon : "info",
				html: "Fill out all required fields!",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});
});