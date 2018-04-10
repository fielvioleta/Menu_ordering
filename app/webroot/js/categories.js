$(document).ready(function(){
	var category_id_for_delete;

	$(document).on( "click", ".btn-delete", function(){
		category_id_for_delete = $(this).val();
	});

	$(document).on( "click", ".btn-delete-confirmed", function(){
		$.ajax({
			url : "/admin/categories/delete",
			method: 'POST',
			cache: false,
			data: { 
				cateogry_id: category_id_for_delete
			},
			success:function(res) {
				if( res ) {
					location.reload();
				}
			}
		});
	});

	$('#deleteModal').on('hidden.bs.modal', function (e) {
		category_id_for_delete = "";
	});
});