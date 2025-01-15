<div class="row mt-3 mb-3">
	<div class="col-1">
		<a class="btn btn-primary" href="<?php echo site_url($this->admin_url.'/users');?>">Back</a>
	</div>
	<div class="col-9">
		<h3><?php echo $user_data;?></h3>
	</div>
	<div class="col-2">
		<button id="toggle_delete" class="btn btn-outline-danger" type="button">Enable Delete</button>
	</div>
</div>
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Code</th>
					<th>Label</th>
					<th>Seconds</th>
					<th>Seconds Used</th>
					<th>Time Start</th>
					<th>Time End</th>
					<th>Last Updated</th>
					<th><span class="delete-button" style="display: none;">Delete</span></th>
<!-- <th>Soal</th> -->
					<th>Jawaban</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($data as $row):?>
				<tr>
					<td><?php echo $row->quiz_code;?></td>
					<td><?php echo $row->label;?></td>
					<td><?php echo $row->seconds;?></td>
					<td><?php echo $row->seconds_used;?></td>
					<td><?php echo $row->time_start;?></td>
					<td><?php echo $row->time_end;?></td>
					<td><?php echo $row->last_update;?></td>
					<td><a style="display: none;" href="javascript:void(0)"  onclick="delete_quiz_data(this)" data-userid="<?php echo $row->users_id;?>" data-quizcode="<?php echo $row->quiz_code;?>" class="delete-button text-danger">Delete</a></td>
<!-- <td>
						<a href="<?php echo site_url($this->admin_url.'/user_quiz_log_data/'.$row->users_id.'/'.$row->quiz_code);?>">Soal</a>
					</td> -->
					<td>
						<a href="<?php echo site_url($this->admin_url.'/user_quiz_jawaban/'.$row->users_id.'/'.$row->quiz_code);?>">Jawaban</a>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>
<script>
var delete_quiz_data;
$(function(){
	delete_quiz_data = function(obj) {
		var users_id = $(obj).data('userid')
		var quiz_code = $(obj).data('quizcode')
		
		var yes = confirm('Anda yakin akan menghapus user id: '+users_id+', quiz code: '+quiz_code+'? Tekan OK jika ingin melanjutkan');
		
		if (yes) {
			$.post('<?php echo site_url($this->admin_url.'/user_quiz_delete');?>', {'users_id':users_id, 'quiz_code':quiz_code}, function(data) {
				if (data.success) {
					$(obj).parent().parent().fadeOut(function(){
						$(this).remove();
					})
				} else if (data.msg) {
					alert(data.msg)
				} else {
					alert('Unknown Error')
				}
			},'json').fail(function(data) {
				alert(data.statusText+':'+data.status)
			})
		}
	}
	
	$('#toggle_delete').on('click', function(){
		var status = $(this).data('on')
		
		if (status == 1) {
			$('.delete-button').hide()
			$(this).data('on', 0)
			$(this).removeClass('btn-danger').addClass('btn-outline-danger')
			$(this).text('Enable Delete')
		} else {
			$('.delete-button').show()
			$(this).data('on', 1)
			$(this).addClass('btn-danger').removeClass('btn-outline-danger')
			$(this).text('Disable Delete')
		}
	})
})
</script>
