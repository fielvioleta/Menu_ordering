$(document).ready(function(){
	var product_id_for_delete;

	$(document).on( "click", ".btn-delete", function(){
		product_id_for_delete = $(this).val();
	});

	$(document).on( "click", ".btn-delete-confirmed", function(){
		$.ajax({
			url : "/admin/products/delete",
			method: 'POST',
			cache: false,
			data: { 
				user_id: product_id_for_delete
			},
			success:function(res) {
				if( res ) {
					location.reload();
				}
			}
		});
	});

	$('#deleteModal').on('hidden.bs.modal', function (e) {
		product_id_for_delete = "";
	});

});