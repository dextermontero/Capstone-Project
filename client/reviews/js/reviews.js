$(document).ready(function() {
	$('#reviewlist tbody').on('click', '.archive-status', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Review',
			html: "<b>Are you sure?</b> you want to review this pet?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive.php", {id:id})
				.done(function(data){
					if(data == "success"){
						Swal.fire({
							title : "Archive",
							icon : "success",
							html: "Successfully archive your review information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Review Status",
							icon : "warning",
							html: "Something wrong in archive review information.",
							timer: 3000,
							showConfirmButton:false							
						});							
					}
				});
			}else {
				Swal.fire({
					title : "Archive Review",
					icon : "error",
					html: "Failed archive your review information",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});
	});
	// UPDATE REVIEW
	$('#reviewlist tbody').on('click', '.update-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_review.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#update_review_modal').html(data);
			}
		});
	});
	// UPDATE STATUS
	$('#reviewlist tbody').on('click', '.update-status', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("update_status.php", {id:id})
		.done(function(data){
			if(data == "publish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "Successfully publish review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});								
			}else if(data == "unpublish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "Successfully unpublish review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});															
			}else{
				Swal.fire({
					title : "Review Status",
					icon : "warning",
					html: "Something wrong in update review status.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
	
	// PUBLISH
	$('#reviewPublish tbody').on('click', '.archive-status', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Review',
			html: "<b>Are you sure?</b> you want to archive this review information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive.php", {id:id})
				.done(function(data){
					if(data == "success"){
						Swal.fire({
							title : "Archive",
							icon : "success",
							html: "Successfully archive your review information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Review Status",
							icon : "warning",
							html: "Something wrong in archive review information.",
							timer: 3000,
							showConfirmButton:false							
						});							
					}
				});
			}else {
				Swal.fire({
					title : "Archive Review",
					icon : "error",
					html: "Failed archive your review information",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});
	});
	// UPDATE REVIEW
	$('#reviewPublish tbody').on('click', '.update-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_review.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#update_review_modal').html(data);
			}
		});
	});
	// UPDATE STATUS
	$('#reviewPublish tbody').on('click', '.update-status', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("update_status.php", {id:id})
		.done(function(data){
			if(data == "publish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "Successfully publish review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});								
			}else if(data == "unpublish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "Successfully unpublish review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});															
			}else{
				Swal.fire({
					title : "Review Status",
					icon : "warning",
					html: "Something wrong in update review status.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
	
	// UNPUBLISH
	$('#reviewUnpublish tbody').on('click', '.archive-status', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		Swal.fire({
			title: 'Archive Review',
			html: "<b>Are you sure?</b> you want to archive this review information?",
			icon: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: 'No',
			confirmButtonText: 'Yes'
		}).then((result) => {
			if (result.isConfirmed) {
				$.post("archive.php", {id:id})
				.done(function(data){
					if(data == "success"){
						Swal.fire({
							title : "Archive",
							icon : "success",
							html: "Successfully archive your review information.",
							timer: 3000,
							showConfirmButton:false							
						}).then(function() {
							location.reload();
						});														
					}else{
						Swal.fire({
							title : "Review Status",
							icon : "warning",
							html: "Something wrong in archive review information.",
							timer: 3000,
							showConfirmButton:false							
						});							
					}
				});
			}else {
				Swal.fire({
					title : "Archive Review",
					icon : "error",
					html: "Failed archive your review information",
					timer: 3000,
					showConfirmButton:false							
				});						
			}
		});
	});
	// UPDATE REVIEW
	$('#reviewUnpublish tbody').on('click', '.update-review', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.ajax({
			url : "view_review.php",
			method : "POST",
			data : {id : id},
			success:function(data){
				$('#update_review_modal').html(data);
			}
		});
	});
	// UPDATE STATUS
	$('#reviewUnpublish tbody').on('click', '.update-status', function (e) {
		e.preventDefault();
		var id = $(this).attr('id');
		$.post("update_status.php", {id:id})
		.done(function(data){
			if(data == "publish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "Successfully publish review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});								
			}else if(data == "unpublish"){
				Swal.fire({
					title : "Review Status",
					icon : "success",
					html: "Successfully unpublish review information.",
					timer: 3000,
					showConfirmButton:false							
				}).then(function() {
					location.reload();
				});															
			}else{
				Swal.fire({
					title : "Review Status",
					icon : "warning",
					html: "Something wrong in update review status.",
					timer: 3000,
					showConfirmButton:false							
				});							
			}
		});
	});
});

$(document).ready(function() {
	$('#update_feedback').click(function(e) {
		e.preventDefault();
		var id = $('#review_id').html();
		var description = $('#review_description_edit').val();
		if(description != ''){
			$.post("update_review.php", {id : id, description : description})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Update Review",
						icon : "success",
						html: "Successfully update review information.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});								
				}else{
					Swal.fire({
						title : "Update Review",
						icon : "warning",
						html: "Something wrong in update review information.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else{
			Swal.fire({
				title : "Update Review",
				icon : "info",
				html: "Fill out required field",
				timer: 3000,
				showConfirmButton:false							
			});						
		}
	});
});

$(document).ready(function() {
	$('#review_title').change(function(e) {
		e.preventDefault();
		$('#review_description').removeAttr('disabled', 'disabled');
		$('#add_feedback').removeAttr('disabled', 'disabled');
	});
	$('#add_feedback').click(function(e) {
		e.preventDefault();
		var title = $('#review_title').val();
		var description = $('#review_description').val();
		$('#add_feedback').attr('disabled', 'disabled');
		if(description != ''){
			$.post('add_review.php', {title:title, description:description})
			.done(function(data) {
				if(data == "success"){
					Swal.fire({
						title : "Add Review",
						icon : "success",
						html: "Successfully add feedback review.",
						timer: 3000,
						showConfirmButton:false							
					}).then(function() {
						location.reload();
					});
				}else if(data == "failed"){
					Swal.fire({
						title : "Add Review",
						icon : "error",
						html: "failed add feedback review.",
						timer: 3000,
						showConfirmButton:false							
					});
				}else{
					Swal.fire({
						title : "Add Review",
						icon : "warning",
						html: "Something wrong in add feedback review.",
						timer: 3000,
						showConfirmButton:false							
					});
				}
			});
		}else {
			Swal.fire({
				title : "Add Review",
				icon : "info",
				html: "Description field cannot be empty!",
				timer: 3000,
				showConfirmButton:false							
			});
		}
	});
});