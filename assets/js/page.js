var kick_session;

$(function(){
	$('form').on('submit', function(e){

		if ($('#sudah_membaca').length > 0) {
			if (! $('#sudah_membaca').is(':checked')) {
				return false;
			}
		}
		
		$.ajax({
			data: $('form').serialize(),
			dataType: 'JSON',
			success: function(data) {
				if (data.error) {
					$('#modal_title').html('Alert')
					$('#msg').html(data.msg)
					$('#modal').modal('show')
				}
				else if (data.redirect) {
					window.location.href = data.redirect
				}
				else {
					location.reload();
				}
                $('input[name="kick"]').val(0);
			},
			error: function(){
				$('#modal_title').html('Alert')
				$('#msg').html("Silahkan coba beberapa saat lagi.")
				$('#modal').modal('show')   
                $('input[name="kick"]').val(0);   
		   },
			type: 'POST',
			url: loginUrl
		})
	})
    
    kick_session = function() {
        $('input[name="kick"]').val(1);
        $('form').submit();
    }
})
