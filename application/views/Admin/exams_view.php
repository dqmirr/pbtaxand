<form method="POST">
	<div class="row">
		<div class="table-responsive">
			<table class="table table-striped">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Code</th>
						<th scope="col">Label</th>
						<th scope="col">Group?</th>
						<th scope="col">Description</th>
						<th scope="col" class="text-center">Jadwal</th>
						<th scope="col">Status</th>
						<!-- <th scope="col">Is Debug</th> -->
					</tr>
				</thead>
				<tbody>
				<?php foreach ($list as $row):?>
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
						<td class="text-center">
							<label for="quiz-<?php echo $row->id;?>">
							<?php if (isset($jadwal_lookup[$row->id])):?>
							<?php echo implode("<hr />", $jadwal_lookup[$row->id]);?>
							<?php endif;?>
							</label>
						</td>
						<td><input name="id[]" value="<?php echo $row->id;?>" <?php echo in_array($row->id, $user_exams) ? 'checked="checked"' : '';?> id="quiz-<?php echo $row->id;?>" type="checkbox" /></td>
						<!-- <td>
							<?php //if($row->library_code == 'multiplechoice'):?>
								<input name="is_debugs[]" value="<?php //echo $row->id;?>" <?php //echo in_array($row->id, $user_debugs) ? 'checked="checked"' : '';?> id="quiz-debugs-<?php //echo $row->id?>" type="checkbox">
							<?php //endif; ?>
						</td> -->
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-6">
			<a href="<?php echo $users_url;?>" class="btn btn-warning btn-block">Back</a>
		</div>
		<div class="col-6">
			<button type="submit" class="btn btn-primary btn-block">Save</button>
		</div>
	</div>
	<div class="row mb-5"></div>
</form>
