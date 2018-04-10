$(document).ready(function(){
	var user_id_for_delete;

	$(document).on( "click", ".btn-delete", function(){
		user_id_for_delete = $(this).val();
	});

	$(document).on( "click", ".btn-delete-confirmed", function(){
		$.ajax({
			url : "/admin/users/delete",
			method: 'POST',
			cache: false,
			data: { 
				user_id: user_id_for_delete
			},
			success:function(res) {
				if( res ) {
					location.reload();
				}
			}
		});
	});

	$('#deleteModal').on('hidden.bs.modal', function (e) {
		user_id_for_delete = "";
	});

});