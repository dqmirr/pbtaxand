<div class="row mt-3">
	<div class="col-1">
		<a class="btn btn-primary" href="<?php echo site_url($back_url);?>">Back</a>
	</div>
	<div class="col-3">
		<h3><?php echo $title;?></h3>
	</div>
	<div class="col-8 text-right">
		<h3><?php echo $user_data;?></h3>
	</div>
</div>
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<thead class="thead-dark">
				<tr>
					<th>Total: <?php echo count($data);?></th>
					<th>Status: <?php echo $status;?></th>
					<th colspan="2">&nbsp;</th>
				</tr>
				<?php if ($type == 'pauli'):?>
				<tr>
					<th>Part</th>
					<th>Total</th>
					<th>Benar</th>
					<th>Salah</th>
				</tr>
				<?php elseif ($type == 'essay'):?>
				<tr>
					<th>Nomor</th>
					<th>Pertanyaan</th>
					<th>Jawaban</th>
				</tr>
				<?php else:?>
				<tr>
					<th>Nomor</th>
					<th>Jawaban</th>
					<th>Jawaban <?php echo $benar;?></th>
					<th>Status</th>
				</tr>
				<?php endif;?>
			</thead>
			<tbody>
			<?php 
				$total_benar = 0;
				$total_salah = 0;
				$total_selesai = 0;
				$total_belum = 0;
				foreach ($data as $row):
			?>
				<?php if ($type == 'pauli'):?>
				<tr>
					<td><?php echo ($row->part + 1);?></td>
					<td><?php echo $row->total;?></td>
					<td><?php echo $row->benar;?></td>
					<td><?php echo $row->salah;?></td>
				</tr>
				<?php elseif ($type == 'essay'):?>
				<tr>
					<td><?php echo $row->nomor;?></td>
					<td><?php echo $row->question;?></td>
					<td><?php echo $row->jawaban;?></td>
				</tr>
				<?php else:?>
				<?php $total_benar_colspan = 3; ?>
				<tr>
					<td><?php echo $row->nomor;?></td>
					<td><?php echo $row->jawaban;?></td>
					<td><?php echo $row->jawaban_benar;?></td>
					<td>
						
						<?php if($type== 'personal'): ?>
							<?php if(!empty($row->jawaban)): ?>
								<?php 
									$total_selesai = $total_selesai + 1;	
								?>
								<span class="badge badge-success">Selesai</span>
							<?php endif; ?>
							<?php if(empty($row->jawaban)): ?>
								<?php 
									$total_belum = $total_belum + 1;	
								?>
								<span class="badge badge-success">Belum Selesai</span>
							<?php endif; ?>
						<?php endif;?>

						<?php if($type != 'personal'): ?>
							<?php 
								if(isset($row->jawaban_benar)):
									if($row->jawaban == $row->jawaban_benar):
									$total_benar = $total_benar + 1;
							?>
								<span class="badge badge-success">benar</span>
							<?php 
									else: 
										$total_salah = $total_salah + 1;
							?>
								<span class="badge badge-danger">salah</span>
							<?php 
									endif;
								endif; 
							?>
						<?php endif;?>
					</td>
				</tr>
				<?php endif;?>
			<?php endforeach;?>
			<?php if($type != 'personal'): ?>
				<tr class="bg-dark text-light" style="border-color:var(--dark);">
					<td colspan="<?=$total_benar_colspan?>" style="border-color:var(--dark);" class="text-right">
					Total Benar 
				</td>
					<td style="border-color:var(--dark);">: <span class="badge badge-success" style="font-size: 16pt;"><?=$total_benar ?></span></td>
				</tr>
				<tr class="bg-dark text-light" style="border-color:var(--dark);">
					<td colspan="<?=$total_benar_colspan?>" style="border-color:var(--dark);" class="text-right">Total Salah </td>
					<td style="border-color:var(--dark);">: <span class="badge badge-danger" style="font-size: 16pt;"><?=$total_salah ?></span></td>
				</tr>
			<?php endif; ?>
			<?php if($type == 'personal'): ?>
				<tr class="bg-dark text-light" style="border-color:var(--dark);">
					<td colspan="<?=$total_benar_colspan?>" style="border-color:var(--dark);" class="text-right">
					Total Selesai
				</td>
					<td style="border-color:var(--dark);">: <span class="badge badge-success" style="font-size: 16pt;"><?=$total_selesai ?></span></td>
				</tr>
				<tr class="bg-dark text-light" style="border-color:var(--dark);">
					<td colspan="<?=$total_benar_colspan?>" style="border-color:var(--dark);" class="text-right">Total Belum Selesai </td>
					<td style="border-color:var(--dark);">: <span class="badge badge-danger" style="font-size: 16pt;"><?=$total_belum ?></span></td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>
