<form onsubmit="return false;" id="form_change_password">
	<div class="row">
		<div class="offset-lg-3 col-lg-10 col-sm-12">
			<div class="row mb-3 mt-3">
				<div class="col-lg-2 col-sm-12">Password Lama</div>
				<div class="col-lg-4 col-sm-12">
					<input type="password" name="current_password" class="form-control" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-2 col-sm-12">Password Baru</div>
				<div class="col-lg-4 col-sm-12">
					<input type="password" name="new_password" class="form-control" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-2 col-sm-12">Password Baru (Ulangi)</div>
				<div class="col-lg-4 col-sm-12">
					<input type="password" name="new_password_repeat" class="form-control" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-lg-4 offset-lg-2">
					<button type="button" class="btn btn-primary btn-block" id="change_password">Ganti Password</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
$(window).ready(function(){
	$('#change_password').on('click', function() {
		$.ajax({
			data: $('#form_change_password').serialize(),
			dataType: 'JSON',
			success: function(data) {
				if (data.error) {
					alert(data.msg)
				}
				else {
					alert(data.msg)
				}
			},
			type: 'POST',
			url: '<?php echo $change_password_url;?>',
		})
	})
})
</script>
