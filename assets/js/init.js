$.ajaxSetup({
	error: function(jqXHR, textStatus, errorThrown){
		$('#modal_title').html('Error')
		$('#msg').html('<div class="alert alert-danger" role="alert">\
		An Error Occured: <b>' + errorThrown + '</b></div>')
		$('#modal').modal('show')
	},
})
