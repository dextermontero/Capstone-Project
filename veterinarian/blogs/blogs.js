// VIEW IMAGE
prevIMG.onchange = evt => {
	const[file] = prevIMG.files
	if(file) {
		viewIMG.src = URL.createObjectURL(file);
	}
}

$(document).ready(function() {
	$('.view-blog').click(function(e) {
		var sid = $(this).attr('id');
		$.ajax({
			url : "view_blogs.php",
			method : "POST",
			data : {sid : sid},
			success:function(data){
				$('#view_blog_modal').html(data);
			}
		});
	});				
});

// Update Status
$(document).ready(function() {
	$('.update-status').click(function(e) {
		e.preventDefault();
		var sid = $(this).attr('id');
		$.post("update_status_blogs.php", {sid : sid})
		.done(function(data) {
			if(data == "unpublish"){
				Swal.fire({
					title : "Blog Unpublished",
					icon : "success",
					html: "<strong>Success! </strong>unpublish blog",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});
			}else if(data == "publish"){
				Swal.fire({
					title : "Blog Published",
					icon : "success",
					html: "<strong>Success! </strong>publish blog",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});							
			}else {
				Swal.fire({
					title : "Blog Published",
					icon : "info",
					text: "Something wrong in blog.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});

// Archive Blog
$(document).ready(function() {
	$('.archive-blog').click(function(e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Blog',
			html: "<b>Are you sure?</b> you want to archive this blog?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive_blogs.php", {id : id})
				.done(function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Archive Blog",
							icon : "success",
							html: "<strong>Success! </strong>archive Blog.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "failed"){
						Swal.fire({
							title : "Archive Blog",
							icon : "error",
							html: "<b>Failed!</b> archive Blog",
							timer: 3000,
							showConfirmButton:false							
						});
					}else {
						Swal.fire({
							title : "Archive Blog",
							icon : "warning",
							text: "Something wrong in archive Blog.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				});
			}else {
				Swal.fire({
					title : "Archive Blog",
					icon : "error",
					html: "<b>Failed!</b> archive Blog",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});						
			}
		});						
	});
});


// Update Blog
$(document).ready(function() {
	$('#update_blog').click(function(e) {
		e.preventDefault();
		var file_data = $('#preveditIMG').prop('files')[0];
		var form_data = new FormData();					
		var id = $('#edit_blog_id').html();
		var title = $('#blog_title_edit').val();
		var description = $('#blog_description_edit').val();
		
		form_data.append('file', file_data);
		form_data.append('id', id);
		form_data.append('title', title);
		form_data.append('description', description);
		
		if(file_data != null){
			$.ajax({
				url : 'update_blogs.php',
				method : "POST",
				dataType : "text",
				cache : false,
				contentType : false,
				processData : false,
				data : form_data,
				success : function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Update Blog",
							icon : "success",
							html: "<strong>Success! </strong>updating blogs.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "format"){
						Swal.fire({
							title : "Update Blog",
							icon : "info",
							html: "<strong>Invalid Format! </strong>please upload JPG, JPEG, PNG Format.",
							timer: 3000,
							showConfirmButton:false							
						});						
					}else {
						Swal.fire({
							title : "Update Blog",
							icon : "error",
							text: "Something wrong in updating blog.",
							timer: 3000,
							showConfirmButton:false							
						});
					}
				}						
			});
		}else {
			$.post("update_blogs_nopic.php", {id : id, title : title, description : description})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Blog",
						icon : "success",
						html: "<strong>Success! </strong>updating blogs.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else if(data == "format"){
					Swal.fire({
						title : "Update Blog",
						icon : "info",
						html: "<strong>Invalid Format! </strong>please upload JPG, JPEG, PNG Format.",
						timer: 3000,
						showConfirmButton:false							
					});						
				}else {
					Swal.fire({
						title : "Update Blog",
						icon : "error",
						text: "Something wrong in updating blog.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}
	});
});

// Add Blog
$(document).ready(function() {
	$('#post_blog').click(function(e) {
		e.preventDefault();
		var file_data = $('#prevIMG').prop('files')[0];
		var form_data = new FormData();					
		var title = $('#blog_title').val();
		var description = $('#blog_description').val();
		form_data.append('file', file_data);
		form_data.append('title', title);
		form_data.append('description', description);
		
		if(file_data != null && title != '' && description != ''){
			$.ajax({
				url : 'add_blogs.php',
				method : "POST",
				dataType : "text",
				cache : false,
				contentType : false,
				processData : false,
				data : form_data,
				success : function(data) {
					if(data == "success"){
						Swal.fire({
							title : "Add Blog",
							icon : "success",
							html: "<strong>Success! </strong>adding blogs.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});
					}else if(data == "format"){
						Swal.fire({
							title : "Add Blog",
							icon : "info",
							html: "<strong>Invalid Format! </strong>please upload JPG, JPEG, PNG Format.",
							timer: 3000,
							showConfirmButton:false							
						});						
					}else {
						Swal.fire({
							title : "Add Blog",
							icon : "error",
							text: "Something wrong in adding blog.",
							timer: 3000,
							showConfirmButton:false							
						});
						alert(data);
					}
				}						
			});						
		}else{
			Swal.fire({
				title : "Update Blog",
				icon : "info",
				html: "<strong>Invalid Format! </strong>please upload JPG, JPEG, PNG Format.",
				timer: 3000,
				showConfirmButton:false							
			});	
		}
	});
});