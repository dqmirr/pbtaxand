<div class="row mt-3">
	<div class="col-lg-9 col-md-8 col-sm-12">
		<h4><i class="text-secondary">System &gt;</i> Upload Users</h4>
	</div>
	<div class="col-lg-3 col-md-4 col-sm-12">
		<a href="<?php echo $download_url;?>" class="btn btn-outline-secondary btn-block">
			<span class="oi oi-data-transfer-download mr-2"></span> Sample CSV Data
		</a>
	</div>
</div>
<?php if ($this->session->flashdata('success') != ''):?>
<div class="row mt-3 mb-3">
	<div class="col">
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<?php echo $this->session->flashdata('success');?>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	</div>
</div>
<?php endif;?>
<hr />
<form method="POST" enctype="multipart/form-data">
	<div class="row mt-3">
		<div class="col-lg-8">
			<div class="row">
				<div class="col">
					<h5>Select Quiz</h5>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Code</th>
									<th>Label</th>
									<th>Group?</th>
									<th>Description</th>
									<th>Select</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach ($arr_quiz as $row):?>
								<tr>
									<td>
										<label for="quiz-<?php echo $row->id;?>">
											<?php echo $row->code;?>
										</label>
									</td>
									<td>
										<label for="quiz-<?php echo $row->id;?>">
											<?php echo $row->label;?>
										</label>
									</td>
									<td>
										<label for="quiz-<?php echo $row->id;?>">
											<?php echo $row->group_quiz_code == '' ? '' : 'Ya';?>
										</label>
									</td>
									<td>
										<label for="quiz-<?php echo $row->id;?>">
											<?php echo $row->description;?>
										</label>
									</td>
									<td>
										<input id="quiz-<?php echo $row->id;?>" type="checkbox" name="quiz[<?php echo $row->id;?>]" value="<?php echo $row->id;?>" <?php echo set_value('quiz['.$row->id.']','') == '' ? '' : 'checked="checked"';?> />
									</td>
								</tr>
							<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
				
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			
				<div class="row">
					<div class="col">
						<h5>Upload Data</h5>
						<input type="file" name="file" class="btn btn-outline-primary btn-block" required="required" />
					</div>
				</div>
				<div class="row mt-1">
					<div class="col-lg-6 offset-lg-6">
						<button type="submit" class="btn btn-primary btn-block">
							<span class="oi oi-data-transfer-upload mr-2"></span> Upload
						</button>
					</div>
				</div>
			
		</div>
	</div>
</form>
