<div class="container">
	<div class="row mt-3 mb-3">
		<div class="col-lg-10 col-sm-12">
			<h3>LAPORAN DIGITAL HASIL TEST SELEKSI CALON KARYAWAN</h3>
		</div>
		<div class="col-lg-2 col-sm-12">
			<a id="generate_pdf_button" href="javascript:void(0)" onclick="generate_pdf()" class="btn btn-secondary btn-block disabled"><img src="<?php echo base_url('assets/images/icons/pdf.png');?>" /> Print</a>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-7 col-sm-12">
			<div class="row">
				<div class="col-lg-5 col-sm-12 font-weight-bold">User ID</div>
				<div class="col-lg-7 col-sm-12"><?php echo $data->username;?></div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-sm-12 font-weight-bold">Nama</div>
				<div class="col-lg-7 col-sm-12"><?php echo $data->fullname;?></div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-sm-12 font-weight-bold">Formasi</div>
				<div class="col-lg-7 col-sm-12"><?php echo $data->formasi_code;?></div>
			</div>
			<p>&nbsp;</p>
			<div class="row">
				<div class="col-lg-5 col-sm-12 font-weight-bold">Hasil Test Secara Umum</div>
				<div class="col-lg-7 col-sm-12"></div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-sm-12">Saran Keputusan</div>
				<div class="col-lg-7 col-sm-12 font-weight-bold"><?php echo $data->kategori;?></div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-sm-12">Ranking dalam Formasi</div>
				<div class="col-lg-7 col-sm-12"><?php echo $data->rank;?></div>
			</div>
			<p>&nbsp;</p>
			<div class="row">
				<div class="col-lg-5 col-sm-12 font-weight-bold">Kesimpulan Umum</div>
				<div class="col-lg-7 col-sm-12 text-justify"><?php echo $data->gtq_text;?></div>
			</div>
			<p>&nbsp;</p>
			<div class="row">
				<div class="col font-weight-bold">Analisa Test Fragmental</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Subtest</th>
									<th>Hal yang diukur</th>
									<th>Hasil yang dicapai Oleh Pelamar</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-justify">
									<td>Sub-Test 1</td>
									<td>Tes ini menilai seberapa cepat dan akurat seseorang dapat memeriksa kesalahan / keakuratan yang dilakukan dan kemudian menggambarkan sekumpulan data atau membuat catatan penting mengenai data tersebut. Selain itu merupakan kemampuan membaca data secara cepat.</td>
									<td><?php echo $data->lc_text;?></td>
								</tr>
								<tr class="text-justify">
									<td>Sub-Test 2</td>
									<td>Tes ini menilai kemampuan seorang individu untuk menyimpan informasi dalam ingatannya dan memecahkan masalah setelah menerima instruksi lisan atau tertulis. Skor yang tinggi akan menunjukan kemampuan belajar secara cepat, dan kemampuan penalaran verbal yang baik. Test juga merupakan ukuran kemampuan negosiasi yang berguna.</td>
									<td><?php echo $data->re_text;?></td>
								</tr>
								<tr class="text-justify">
									<td>Sub-Test 3</td>
									<td>Test ini mengukur kemampuan pemecahan masalah secara deduktif yang menuntut kemampuan untuk menanggung beban kerja mental yang tinggi dan sangat memerlukan rentang perhatian dan konsentrasi yang tinggi dalam jangka waktu lama.</td>
									<td><?php echo $data->ld_text;?></td>
								</tr>
								<tr class="text-justify">
									<td>Sub-Test 4</td>
									<td>Test ini mengukur kemampuan mengelola pekerjaan yang menekankan kebutuhan akan kemampuan numerik, juga mengukur mental agility (kegigihan mental dan kemampuan memory secara umum)</td>
									<td><?php echo $data->nd_text;?></td>
								</tr>
								<tr class="text-justify">
									<td>Sub-Test 5</td>
									<td>Test ini mengukur kemampuan mengelola pekerjaan yang menekankan kebutuhan akan kemampuan numerik, juga mengukur mental agility (kegigihan mental dan kemampuan memory secara umum)</td>
									<td><?php echo $data->so_text;?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-5 col-sm-12" style="height: 600px;">
			<canvas id="chart"></canvas>
		</div>
	</div>
</div>
<div style="display:none">
	<form id="form_generate" method="POST" action="<?php echo $pdf_url;?>">
		<input type="hidden" name="base64img" value="" id="picture" />
	</form>
</div>

<script>
window.chartColors = {
	red: 'rgb(255, 99, 132)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(75, 192, 192)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)'
};

var picture;

var generate_pdf = function(){
		$('#picture').val(picture)
		$('#form_generate').submit()
	}

var chartData = {
	labels: ['Ketelitian Huruf', 'Logika Verbal', 'Working Memory', 'Kemampuan Numerik', 'Kemampuan Figural'],
	datasets: [{
		type: 'line',
		label: 'Batas',
		borderColor: window.chartColors.green,
		borderWidth: 2,
		fill: false,
		data: [
			100,
			100,
			100,
			100,
			100
		]
	}, {
		type: 'bar',
		label: 'Hasil',
		backgroundColor: window.chartColors.blue,
		data: [
			<?php echo $data->lc_num;?>,
			<?php echo $data->re_num;?>,
			<?php echo $data->ld_num;?>,
			<?php echo $data->nd_num;?>,
			<?php echo $data->so_num;?>,
		],
		borderColor: 'white',
		borderWidth: 2
	}]
}
var ctx = document.getElementById('chart').getContext('2d');

window.myMixedChart = new Chart(ctx, {
	type: 'bar',
	data: chartData,
	options: {
		responsive: true,
		title: {
			display: true,
			text: 'HASIL TEST SCREENING AGILITY  & FLUID THINKING TEST'
		},
		maintainAspectRatio: false,
		scaleShowValues: true,
		scales: {
			yAxes: [{
				ticks: {
					beginAtZero: true
				}
			}],
			xAxes: [{
				ticks: {
					autoSkip: false
				}
			}]
		},
		animation: {
			onComplete: function(){
				$('#generate_pdf_button').removeClass('disabled');
				picture = window.myMixedChart.toBase64Image();
			}
		}
	},
});

</script>
