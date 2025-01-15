<div class="row mt-3">
	<div class="col-2">
		<div>
			<a class="btn btn-primary" href="<?php echo site_url($back_url);?>">Back</a>
		</div>
		<div class="my-2">
			<a class="btn btn-outline-primary" href="<?=$download_pdf_url ?>">Download Pdf</a>
		</div>
	</div>
	<div class="col-3">
		<h3><?php echo $title;?></h3>
	</div>
	<div class="col-7 text-right">
		<h3><?php echo $user_data;?></h3>
	</div>
</div>
<div class="row bg-dark text-light">
	<div class="col-6">Total: <?= count($data); ?></div>
	<div class="col-6">Status: <?= $status; ?></div>
</div>
<div class="row">
	<div class="table-responsive">
		<table class="table table-striped">
			<?php 
					$thead = ["Keterangan", "D", "I", "S", "C", "*", "Total","DISC Profile"];
			?>
			<thead class="thead-dark">
				<tr>
					<?php foreach($thead as $row): ?>
					<th><?= $row ?></th>
					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php 
						$nomor = 1;
						$most_grand_total = intval($data->disc_result["D"]["most_total"]) + 
						intval($data->disc_result["I"]["most_total"]) +
						intval($data->disc_result["S"]["most_total"]) +
						intval($data->disc_result["C"]["most_total"]) +
						intval($data->disc_result["B"]["most_total"]) ;
						$least_grand_total = intval($data->disc_result["D"]["least_total"]) + 
						intval($data->disc_result["I"]["least_total"]) +
						intval($data->disc_result["S"]["least_total"]) +
						intval($data->disc_result["C"]["least_total"]) +
						intval($data->disc_result["B"]["least_total"]) ;	
						$is_most_done = $most_grand_total == 24;
						$is_least_done = $least_grand_total == 24;
						$is_all_done = $is_most_done && $is_least_done;
						$most_disc = array();
						$least_disc = array();
						$change_disc = array();
				?>
				<tr>
					<td>Most</td>
					<td><?= $data->disc_result["D"]["most_total"] ?></td>
					<td><?= $data->disc_result["I"]["most_total"] ?></td>
					<td><?= $data->disc_result["S"]["most_total"] ?></td>
					<td><?= $data->disc_result["C"]["most_total"] ?></td>
					<td><?= $data->disc_result["B"]["most_total"] ?></td>
					<td><?= $most_grand_total; ?></td>
					<td><?= $is_most_done ? $data->m_disc["profile"] : ""; ?></td>
				</tr>
				<tr>
					<td>Least</td>
					<td><?= $data->disc_result["D"]["least_total"] ?></td>
					<td><?= $data->disc_result["I"]["least_total"] ?></td>
					<td><?= $data->disc_result["S"]["least_total"] ?></td>
					<td><?= $data->disc_result["C"]["least_total"] ?></td>
					<td><?= $data->disc_result["B"]["least_total"] ?></td>
					<td><?= $least_grand_total ?></td>
					<td><?= $is_least_done ? $data->l_disc["profile"] : ""; ?></td>
				</tr>
				<tr>
					<td>Change</td>
					<td><?= $data->disc_result["D"]["change_total"] ?></td>
					<td><?= $data->disc_result["I"]["change_total"] ?></td>
					<td><?= $data->disc_result["S"]["change_total"] ?></td>
					<td><?= $data->disc_result["C"]["change_total"] ?></td>
					<td><?= $data->disc_result["B"]["change_total"] ?></td>
					<td></td>
					<td><?= $is_all_done ? $data->c_disc["profile"] : ""; ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<?php if($is_all_done): ?>
<div class="row mb-5">
	<div class="col-4">
		<canvas id="chartMost" width="400" height="400"></canvas>
	</div>
	<div class="col-4">
		<canvas id="chartLeast" width="400" height="400"></canvas>
	</div>
	<div class="col-4">
		<canvas id="chartChange" width="400" height="400"></canvas>
	</div>
</div>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://unpkg.com/jspdf-autotable@3.5.25/dist/jspdf.plugin.autotable.js"></script>
<script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	const {
		jsPDF
	} = window.jspdf;

	const filename = '<?php echo $user_data;?> - <?php echo $title;?>'
	function downloadPDF(){
		let pdf = generatePdf();
		pdf.save(`${filename}.pdf`);
	}

	var generatePdf = function () {
		var doc = new jsPDF('p', 'pt', 'a4')
		doc.text('Hasil Pengerjaan Soal Quiz', 40, 50)

		// var raw = 
		var body = bodyRows()

		doc.autoTable({
			startY: 60,
			head: [
			[
				{
					content: 'Total: <?php echo count($data);?>',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
				{
					content: 'Status: <?php echo $status;?>',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
				{
					content: '',
					colSpan: 3,
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				}
			],
			[
				{
					content: 'No',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
				{
					content: 'Keterangan',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
				{
					content: 'Most',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
				{
					content: 'Least',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
				{
					content: 'Change',
					styles: { fillColor: [0, 0, 0], textColor: [255,255,255] }
				},
			]
			],
			body: body,
			theme: 'grid',
		})
		return doc
	}

	function bodyRows() {
		var body = [
			<?php
				$nomor = 1;
				foreach ($data as $key=>$row):
			?>
				[
					'<?=$nomor;?>',
					'<?=$row->keterangan;?>',
					'<?=$row->most_total;?>',
					'<?=$row->least_total;?>',
					'<?=intval($row->most_total) - intval($row->least_total)?>'
				],
			<?php 
					$nomor++;
				endforeach;
			?>
		]
		return body
	}
</script>

<script>
	const ctxCartMost = document.getElementById('chartMost');
	const chartMost = new Chart(ctxCartMost, {
			type: 'line',
			data: {
					labels: ['D', 'I', 'S', 'C'],
					datasets: [{
							label: "Grafik 1",
							data: [
									<?=$data->m_disc["segment_16_list"]["D"];?>,
									<?=$data->m_disc["segment_16_list"]["I"];?>,
									<?=$data->m_disc["segment_16_list"]["S"];?>,
									<?=$data->m_disc["segment_16_list"]["C"];?>
								],
							borderColor: [
									'rgba(255, 99, 132, 1)'
							],
							borderWidth: 5
					}]
			},
			options: {
					scales: {
							y: {
								min: -8,
								max: 8
							}
					}
			}
	});

	const ctxCartLeast = document.getElementById('chartLeast');
	const chartLeast = new Chart(ctxCartLeast, {
			type: 'line',
			data: {
					labels: ['D', 'I', 'S', 'C'],
					datasets: [{
							label: "Grafik 2",
							data: [
									<?=$data->l_disc["segment_16_list"]["D"];?>,
									<?=$data->l_disc["segment_16_list"]["I"];?>,
									<?=$data->l_disc["segment_16_list"]["S"];?>,
									<?=$data->l_disc["segment_16_list"]["C"];?>
								],
							borderColor: [
									'rgba(255, 99, 132, 1)'
							],
							borderWidth: 5
					}]
			},
			options: {
					scales: {
							y: {
								min: -8,
								max: 8
							}
					}
			}
	});

	const ctxCartChange = document.getElementById('chartChange');
	const chartChange = new Chart(ctxCartChange, {
			type: 'line',
			data: {
					labels: ['D', 'I', 'S', 'C'],
					datasets: [{
						label: "Grafik 3",
							data: [
									<?=$data->c_disc["segment_16_list"]["D"];?>,
									<?=$data->c_disc["segment_16_list"]["I"];?>,
									<?=$data->c_disc["segment_16_list"]["S"];?>,
									<?=$data->c_disc["segment_16_list"]["C"];?>
								],
							borderColor: [
									'rgba(255, 99, 132, 1)'
							],
							borderWidth: 5
					}]
			},
			options: {
					scales: {
							y: {
								min: -8,
								max: 8
							}
					}
			}
	});
</script>
