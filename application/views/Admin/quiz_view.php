<div class="row flex-xl-nowrap">
	<table class="table table-striped">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Code</th>
				<th scope="col">Label</th>
				<th scope="col">Description</th>
				<th scope="col">Library</th>
				<th scope="col">Group</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($list as $row):?>
			<tr>
				<td><?php echo $row->code;?></td>
				<td><?php echo $row->label;?></td>
				<td><?php echo $row->description;?></td>
				<td><?php echo $row->library;?></td>
				<td><?php echo $row->group_quiz_code;?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>

<div class="row mb-3 mt-2">
	<div class="col">
		<form method="post">
			<div class="row">
				<div class="col">
					<label>Username</label>
					<input type="text" class="form-control" name="username" required="required" />
				</div>
				<div class="col">
					<label>Password</label>
					<input type="text" class="form-control" name="password" required="required" />
				</div>
				<div class="col">
					<label>Fullname</label>
					<input type="text" class="form-control" name="fullname" required="required" />
				</div>
				<div class="col">
					<label>Email</label>
					<input type="text" class="form-control" name="email" required="required" />
				</div>
				<div class="col">
					<label>&nbsp;</label>
					<button type="submit" class="btn btn-primary btn-block">Add New</button>
				</div>
			</div>
		</form>
	</div>
</div>
