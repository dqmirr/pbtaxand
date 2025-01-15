<a class="btn btn-primary my-2" href="<?=base_url("/admin442e17d83025ac7201c9b487db03fe226f67808ad2912247d72fac704c624d7b/soal/multiplechoice") ?>">Kembali Ke Soal</a>
<table class="table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Code</th>
			<th style="width: 200px; overflow:auto;">Story</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($list)): ?>
			<?php foreach($list as $item): ?>
					<tr>
						<td><?= $item["key"] ?></td>
						<td><?= $item["code"] ?></td>
						<td>
							<div style="max-width:50vw; max-height:50px; overflow: auto;">
								<?= $item["story"] ?>
							</div>
						</td>
						<td><a class="" href="">Show Data</a></td>
					</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
