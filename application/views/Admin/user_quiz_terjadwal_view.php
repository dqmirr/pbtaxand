<?php if ($error):?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	Line Error karena format:<br /><?php echo $error;?>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php endif;?>
<?php if ($success):?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
	Berhasil disimpan: <?php echo $success;?>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php endif;?>
<form method="POST" enctype="multipart/form-data">
	<div class="row mt-3">
		<div class="col-lg-8">
			<h4 class="mb-3">
				<i class="text-secondary">System &gt;</i>
				Users Quiz Terjadwal
			</h4>
			<div class="">
				<table class="table table-striped">
					<thead>
						<tr>
							<th style="min-width: 200px;">Overwrite</th>
							<th>Code</th>
							<th>Label</th>
							<th>Group?</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($arr_quiz as $quiz):?>
						<tr>
							<td>
								<div class="row">
									<div class="col">
										<div>
											<input type="checkbox" name="overwrite[<?php echo $quiz->id;?>]" id="overwrite_<?php echo $quiz->id;?>" value="1" />
											<label for="overwrite_<?php echo $quiz->id;?>">Overwrite</label>
										</div>
										<div>Date:</div>
										<div class="input-group date">
											<input type="text" id="date_<?php echo $quiz->id;?>" name="date[<?php echo $quiz->id;?>]" class="form-control" maxlength="10" style="width: 120px;" disabled="disabled" value="" data-toggle="datetimepicker" />
											<div class="input-group-append" data-target="#date_<?php echo $quiz->id;?>" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="oi oi-calendar"></i></div>
											</div>
										</div>

										<div>Time From:</div>
										<div class="input-group time">
											<input type="text" id="time_from_<?php echo $quiz->id;?>" name="time_from[<?php echo $quiz->id;?>]" class="form-control" maxlength="5" style="width: 100px;" disabled="disabled" value="" data-toggle="datetimepicker" />
											<div class="input-group-append" data-target="#time_from_<?php echo $quiz->id;?>" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="oi oi-calendar"></i></div>
											</div>
										</div>
									
										<div>Time To:</div>
										<div class="input-group time">
											<input type="text" id="time_to_<?php echo $quiz->id;?>" name="time_to[<?php echo $quiz->id;?>]" class="form-control" maxlength="5" style="width: 100px;" disabled="disabled" value="" data-toggle="datetimepicker" />
											<div class="input-group-append" data-target="#time_to_<?php echo $quiz->id;?>" data-toggle="datetimepicker">
												<div class="input-group-text"><i class="oi oi-calendar"></i></div>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td><?php echo $quiz->code;?></td>
							<td><?php echo $quiz->label;?></td>
							<td><?php echo $quiz->group_quiz_code == '' ? '' : 'Ya';?></td>
							<td><?php echo $quiz->description;?></td>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="row">
				<div class="col text-right">
					<a href="<?php echo $csv_sample_url;?>"><i class="oi oi-data-transfer-download mr-2"></i> Download Sample CSV</a>
				</div>
			</div>
			<hr />
			<div class="row">
				<div class="col form-group">
					<input type="file" name="file" class="form-control" required="required" />
				</div>
			</div>
			<div class="row mb-3">
				<div class="col">
					<div class="custom-control custom-checkbox my-1 mr-sm-2">
						<input type="checkbox" class="custom-control-input" id="customControlInline" name="unset_quiz" value="1" checked="checked">
						<label class="custom-control-label" for="customControlInline">Set Inactive Semua Quiz</label>
					</div>
					<em><small>Jika ini dipilih, maka semua quiz yang saat ini sedang aktif akan diset menjadi inactive dan tidak akan muncul di dashboard.</small></em>
				</div>
			</div>
			<div class="row">
				<div class="col form-group">
					<button type="submit" class="btn btn-primary btn-block">
						<i class="oi oi-data-transfer-upload mr-2"></i> Upload
					</button>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="alert alert-info">
						<strong>Keterangan</strong>
						<hr />
						<ul>
							<li>Format Date: YYYY-MM-DD
								<br />Contoh:
								<ul>
									<li>2019-01-31 <em class="text-secondary">&rarr;<small> 31 Januari 2019</small></em></li>
									<li>2019-02-01 <em class="text-secondary">&rarr;<small> 1 Februari 2019</small></em></li>
								</ul>
							</li>
							<li>Time From dan Time To harus kelipatan 5 menit. Format Time: HH.mm
								<br />Valid:
								<ul>
									<li>08:00</li>
									<li>09:45</li>
									<li>14:30</li>
								</ul>
								Invalid:
								<ul>
									<li>8:00</li>
									<li>11:01</li>
									<li>15:47</li>
									<li>20:19</li>
								</ul>
							</li>
							<li>Time From dan Time To minimal adalah 00:00 dan maksimal 23:55.</li>
							<li>Email, Quiz Code, dan Date bersifat unik.</li>
							<li>Jika ada Email, Quiz Code, dan Date yang sama maka Time To dan Time From akan direplace.</li>
							<li>Change Sesi Code dipilih dari code yang ada di menu <a href="sesi" target="sesi">sesi</a>.</li>
							<li>Untuk email yang sama harus diisi sesi code yang sama (karena akan diupdate per-row).</li>
							<li>Change Sesi Code boleh kosong.</li>
							<li>Overwrite, untuk mengganti (atau menambah jika tidak ada di daftar) quiz yang ada di dalam file CSV.</li>
							<li>Aturan overwrite sama untuk Date, Time From, dan Time To.</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<style>
/* overwrite */
.bootstrap-datetimepicker-widget.dropdown-menu {
	z-index: 9000;
}
</style>
<script>
$(function() {
	$('input[name^="overwrite["]').on('click', function(){
		if ($(this).is(':checked')) {
			$(this).parent().parent().parent().find('input').prop('disabled',false)
		}
		else {
			$(this).parent().parent().parent().find('input').not('[type=checkbox]').prop('disabled',true)
		}
	})
	
	$('input[name^="date["]').datetimepicker({
		format: 'YYYY-MM-DD'
	})
	
	$('input[name^="time_from["], input[name^="time_to["]').datetimepicker({
		format: 'HH:mm'
	})
})
</script>
