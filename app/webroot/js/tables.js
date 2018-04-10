$(document).ready(function(){
	var table_id_for_delete;

	$(document).on( "click", ".btn-delete", function(){
		table_id_for_delete = $(this).val();
	});

	$(document).on( "click", ".btn-delete-confirmed", function(){
		$.ajax({
			url : "/admin/tables/delete",
			method: 'POST',
			cache: false,
			data: { 
				table_id: table_id_for_delete
			},
			success:function(res) {
				if( res ) {
					location.reload();
				}
			}
		});
	});

	$('#deleteModal').on('hidden.bs.modal', function (e) {
		table_id_for_delete = "";
	});
});