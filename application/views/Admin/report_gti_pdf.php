<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
	<title>Report</title>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
	<style>
	.table tr {
		page-break-inside: avoid;
	}
	.table th {
		vertical-align: top !important;
	}
	</style>
</head>
<body>
	<p>
		<strong>LAPORAN DIGITAL HASIL TEST SELEKSI CALON KARYAWAN</strong>
	</p>
	<table>
		<tbody>
			<tr>
				<th width="250">User ID</th>
				<td><?php echo $data->username;?></td>
			</tr>
			<tr>
				<th>Nama</th>
				<td><?php echo $data->fullname;?></td>
			</tr>
			<tr>
				<th>Formasi</th>
				<td><?php echo $data->formasi_code;?></td>
			</tr>
			<tr>
				<td><p>&nbsp;</p></td>
			</tr>
			<tr>
				<th>Hasil Test Secara Umum</th>
				<td></td>
			</tr>
			<tr>
				<td>Surat Keputusan</td>
				<th><?php echo $data->kategori;?></th>
			</tr>
			<tr>
				<td>Ranking Dalam Formasi</td>
				<td><?php echo $data->rank;?></td>
			</tr>
			<tr>
				<td><p>&nbsp;</p></td>
			</tr>
			<tr>
				<th valign="top">Kesimpulan Umum</th>
				<td><?php echo $data->gtq_text;?></td>
			</tr>
			<tr>
				<td><p>&nbsp;</p></td>
			</tr>
			<tr>
				<th>Analisa Test Fragmental</th>
			</tr>
		</tbody>
	</table>
	
	<table class="table">
		<thead>
			<tr>
				<th width="120">Subtest</th>
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
	
	<img src="<?php echo $img;?>" style="height: 400px;" />
</body>
</html>
