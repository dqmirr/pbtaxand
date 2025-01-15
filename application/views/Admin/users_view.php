<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Edit</th>
					<th scope="col">Username</th>
					<th scope="col">Password</th>
					<th scope="col">Fullname</th>
					<th scope="col">Email</th>
					<th scope="col">Formasi</th>
					<th scope="col">Sesi</th>
					<th scope="col">First Login</th>
					<th scope="col">Agree Code</th>
					<th scope="col">Agree Time</th>
					<th scope="col">Quiz</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $row):?>
				<tr>
					<td>
						<a href="<?php echo $user_url.'/'.$row->username.'/'.$row->id;?>" class="btn btn-warning btn-sm">
							<span class="oi oi-pencil"></span>
						</a>
					</td>
					<td><?php echo $row->username;?></td>
					<td><?php echo $row->password;?></td>
					<td><?php echo $row->fullname;?></td>
					<td><?php echo $row->email;?></td>
					<td><?php echo $arr_formasi[$row->formasi_code];?></td>
					<td><?php echo $arr_sesi[$row->sesi_code];?></td>
					<td><?php echo $row->first_login;?></td>
					<td><?php echo $row->agree_code;?></td>
					<td><?php echo $row->agree_time;?></td>
					<td><a href="<?php echo $user_quiz_url.$row->id;?>">Set &hellip;</a></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>

<div class="row mb-3 mt-2">
	<div class="col">
		<div class="card">
			<div class="card-body">
				<form method="post">
					<div class="row mb-2">
						<div class="col-lg-4 col-sm-12">
							<label>Username</label>
							<?php
							$username_array = array(
								'name'=>'username',
								'class'=>'form-control',
								'required'=>'required',
								'value'=> (isset($data->username)) ? $data->username : '',
							);
							
							if (isset($data->username))
								$username_array['disabled'] = true;
							
							echo form_input($username_array);
							?>
						</div>
						<div class="col-lg-4 col-sm-12">
							<label>Password</label>
							<?php echo form_input(array(
								'name'=>'password',
								'class'=>'form-control',
								'required'=>'required',
								'value'=> (isset($data->password)) ? $data->password : '',
							));?>
						</div>
						<div class="col-lg-4 col-sm-12">
							<label>Fullname</label>
							<?php echo form_input(array(
								'name'=>'fullname',
								'class'=>'form-control',
								'required'=>'required',
								'value'=> (isset($data->fullname)) ? $data->fullname : '',
							));?>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 col-sm-12">
							<label>Email</label>
							<?php echo form_input(array(
								'name'=>'email',
								'class'=>'form-control',
								'required'=>'required',
								'value'=> (isset($data->email)) ? $data->email : '',
							));?>
						</div>
						<div class="col-lg-4 col-sm-12">
							<label>Formasi</label>
							<?php echo form_dropdown(
								'formasi_code', 
								$arr_formasi,
								(isset($data->formasi_code)) ? $data->formasi_code : '',
								'class="form-control" required="required"'
							);?>
						</div>
						<div class="col-lg-4 col-sm-12">
							<label>Sesi</label>
							<?php echo form_dropdown(
								'sesi_code', 
								$arr_sesi,
								(isset($data->sesi_code)) ? $data->sesi_code : '',
								'class="form-control"'
							);?>
						</div>
					</div>
					<div class="row mt-3">
						<?php if (isset($data->id)):?>
						<div class="col">
							<a href="<?php echo $user_url;?>" class="btn btn-warning btn-block">Cancel</a>
						</div>
						<div class="col">
							<button type="submit" class="btn btn-primary btn-block">Update</button>
						</div>
						<?php else:?>
						<div class="col">
							<button type="submit" class="btn btn-primary btn-block">Add New</button>
						</div>
						<?php endif;?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
