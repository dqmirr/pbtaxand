<div class="container mt-2">
	<div class="row">
		<div class="col">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Jenis Soal</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
			<?php 
			if(isset($list_jenis_soal))
			{
				foreach($list_jenis_soal as $row)
				{
			?>
			<tr>
				<td><?=$row['jenis_soal'] ?></td>
				<td><a class="btn btn-primary" href="<?= $row['link'] ?>">Pilih</a></td>
			</tr>
			<?php

				}
			}
			?>
				</tbody>
			</table>
		</div>
	</div>
</div>

