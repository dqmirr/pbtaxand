<div class="row">
	<div class="col">
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>3 Menit ke:</th>
						<?php foreach ($part as $row):?>
						<th style="text-align: right;"><?php echo $row;?></th>
						<?php endforeach;?>
						<th style="text-align: right;">Jumlah</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($data as $label => $rows):?>
					<tr>
						<td><strong><?php echo $label;?></strong></td>
						<?php foreach ($rows as $row):?>
						<td style="text-align: right;">
							<?php echo $row->num;?>
						</td>
						<?php endforeach;?>
						<td style="text-align: right;">
							<?php echo $jumlah->{$label};?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<?php foreach ($rows as $row):?>
						<td style="text-align: right; font-weight: bold; font-style: italic;"><?php echo $row->max == 0 ? '' : 'Max'; echo $row->min == 0 ? '' : 'Min'?></td>
						<?php endforeach;?>
						<td>&nbsp;</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</div>
</div>
