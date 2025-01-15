<div id="petunjuk_pauli" style="display: none;">
	<div class="row">
		<div class="col-12">
			<h4>Petunjuk</h4>
			<ol>
				<li>Pada tes ini, Anda akan dihadapkan pada beberapa deret angka-angka acak.</li>
				<li>Tugas Anda sederhana, yaitu menjumlahkan angka-angka tersebut hingga mencapai jumlah <strong>9 (Sembilan)</strong>.</li>
				<li>Anda memilih angka-angka yang dijumlahkan dengan cara menekan tombol &rarr; (panah kanan) pada keyboard Anda hingga angka-angka yang dijumlahkan mencapai jumlah 9, lalu setelah itu silahkan menekan <strong>tombol Enter</strong> pada keyboard Anda</li>
				<li>Ketika Anda menekan tombol ENTER, maka hasil penjumlahan akan disimpan ke dalam system dan tidak dapat diubah lagi.</li>
				<li>Pilihan lain, jika Anda mengalami masalah pada keyboard Anda, Anda juga dapat mengerjakannya dengan meng’klik’ tanda panah (&rarr;) yang berada di layar Anda dan meng’klik’ pilihan ENTER yang juga berada pada layar Anda.</li>
				<li>Jika sudah menekan ENTER, silahkan lanjut ke angka-angka berikutnya ketika sudah menyelesaikan satu penjumlahan.</li>
				<li>Kerjakan dengan cepat dan teliti.</li>
				<li>Total waktu pengerjaan Anda adalah selama 15 menit.</li>
			</ol>
			<p>
				Perhatikan contoh berikut:
			</p>
			<p>
				<center>
					<img src="<?php echo base_url('assets/images/pauli/petunjuk1.png');?>" class="img-fluid" />
				</center>
			</p>
			<p>
				<ul>
					<li>Silahkan klik tanda panah (&rarr;) pada layar atau tekan tanda panah (&rarr;) pada keyboard Anda untuk menggerakkan kursor.</li>
					<li>Pada contoh di atas, angka 6 dan 3 jika dijumlahkan hasilnya 9. Oleh karena itu, setelah angka 6 dan 3 bertanda hitam, silahkan klik tombol Enter atau tekan tanda Enter pada keyboard Anda.</li>
				</ul>
				<center>
					<img src="<?php echo base_url('assets/images/pauli/petunjuk2.png');?>" class="img-fluid" />
				</center>
			</p>
			<p>
				<ul>
					<li>Jika ada angka 9, maka Anda cukup hanya meng”klik” tanda panah sekali, sampai angka 9 bertanda hitam, lalu silahkan Anda klik tombol Enter.</li>
				</ul>
				<center>
					<img src="<?php echo base_url('assets/images/pauli/petunjuk3.png');?>" class="img-fluid" />
				</center>
			</p>
			<p>
				<ul>
					<li>Selama Anda mengerjakan, pada waktu-waktu tertentu, pada layar Anda akan muncul layar hitam dengan tulisan TERUSKAN KERJAKAN. Saat ada tampilan seperti itu, silahkan tetap meneruskan penjumlahan Anda sampai waktu Anda habis.</li>
				</ul>
				<center>
					<img src="<?php echo base_url('assets/images/pauli/petunjuk4.png');?>" class="img-fluid" />
				</center>
			</p>
			<div class="mb-5"></div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col">
			<button type="button" class="btn btn-warning btn-block" id="start_quiz_button">Mulai Test</button>
		</div>
	</div>
</div>
<div style="display: none;" id="quiz_pauli">
	<div class="row">
		<div class="col">
			<div class="table-responsive">
				<table width="960px" align="center" cellspacing="0">
					<tbody id="part_container">
						<!-- content -->
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<nav class="navbar fixed-bottom navbar-light bg-light">
		<div class="btn-group btn-block">
			<button onclick="enter()" type="button" class="no-zoom btn btn-primary btn-lg border col-sm-4">Enter</button>
			<button id="back_button" onclick="back()" type="button" class="no-zoom btn btn-primary btn-lg border col-sm-4"><span class="oi oi-arrow-left"></span></button>
			<button id="next_button" onclick="next()" type="button" class="no-zoom btn btn-primary btn-lg border col-sm-4"><span class="oi oi-arrow-right"></span></button>
		</div>
	</nav>
</div>
<div style="display: none;" id="jeda_pauli" class="jeda_pauli">
	<table width="100%" height="100%">
		<tbody>
			<tr>
				<td style="text-align: center">
					<h1>Teruskan Kerjakan</h1>
					<img style="display: none;" id="loading_end_pauli" src="<?php echo base_url('assets/images/pauli/loading.gif');?>" />
				</td>
			</tr>
		</tbody>
	</table>
</div>

<style>
#quiz_pauli table td {
	border-left: 2px solid transparent;
}

td.cursor-start {
	border-left: 2px solid #FF0000 !important;
}

td.cursor-selected {
	background: #000;
	color: #FFFF00;
}

td.cursor-stored {
	background: #FFF;
	color: #A6A6A6;
}

.jeda_pauli {
	background: #000;
	color: #FFF;
	position: absolute;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
}
</style>

<script>
var block = false;
var enter;
var back;
var next;

$(function(){
	var current_part = 0;
	var arr_part = {};
	var timer = 0;
	var cursor_col = 0;
	var cursor_row = 0;
	var start_row = 0;
	var start_col = 0;
	var jawaban_current_part = []
	var arr_jawaban_pauli = {}
	
	<?php /* Numagility tidak boleh dicampur dengan library lain */ ;?>
	if (ARR_QUIZ.length == 1) {
		$.each(ARR_QUIZ, function(k,v){
			if (v.library == 'pauli') {
				$('#petunjuk_pauli').show();
				library = v.library;
				code = v.code;
			}
		})
	}
	
	var simpan_jawaban_pauli = function(arr_jawaban, done) {
		var index_send = []

		if (done == 1) {
			// ubah tulisan jeda
			$('#jeda_pauli h1').html('Selesai. Sedang Menyimpan Jawaban&hellip;');
			$('#loading_end_pauli').show();
		}

		$.ajax({
			beforeSend: function(){
				$.each(arr_jawaban, function(index, row){
					index_send.push(index)
				})
			},
			data: {library: library, code: code, answers: arr_jawaban, done: done},
			dataType: 'JSON',
			error: function() {
				if (done == 1) {
					// Kalau error dan done = 1, ulangi kirim jawaban dalam 3 detik
					setTimeout(function(){
						simpan_jawaban_pauli(arr_jawaban, done)
					}, 3 * 1000) 
				}
			},
			success: function(data) {
				if (data.success) {
					for (i=0; i<index_send.length; i++) {
						var index = index_send[i]
						delete(arr_jawaban[index])
					}
					
					if (done == 1) {
						$('#jeda_pauli h1').html('Kembali ke halaman utama&hellip;');
						$('#loading_end_pauli').hide();
						forceExit = true;
						window.location.href = '<?php echo site_url('exam');?>';
					}
				}
				else {
					if (done == 1) {
						// Kalau error dan done = 1, ulangi kirim jawaban dalam 3 detik
						setTimeout(function(){
							simpan_jawaban_pauli(arr_jawaban, done)
						}, 3 * 1000) 
					}
				}
			},
			type: 'POST',
			url: SAVEANSWER_URL
		})
	}
	
	var start_timer = function() {
		setTimeout(function(){
			// simpan ke arr_jawaban_pauli
			arr_jawaban_pauli[current_part] = jawaban_current_part.join(';')
			
			var done = 0;
			block = true;
			$('#quiz_pauli').hide();
			$('#jeda_pauli').show();
			
			current_part += 1
			
			if (current_part == arr_part.length) {
				// Sudah selesai, set done
				done = 1
			}
			else {
				// Baru dilanjutkan setelah peringatan selesai
				setTimeout(function() {
					generate_part(current_part)
				}, 1000)
			}
			
			// simpan ke server
			simpan_jawaban_pauli(arr_jawaban_pauli, done)
			
		}, timer * 1000)
	}
	
	var generate_part = function(part) {
		// reset
		$('#part_container').html('')
		$('#quiz_pauli').show();
		$('#jeda_pauli').hide();
		$('#loading_end_pauli').hide();
		jawaban_current_part = []
		block = false;
		cursor_col = 0;
		cursor_row = 0;
		start_row = 0;
		start_col = 0;
		
		var selected_part = arr_part[part]
		var part_rows = jQuery.parseJSON(selected_part)
		
		$.each(part_rows, function(row, cols){
			var tr = $('<tr></tr>').attr('id', 'row-'+row)
			tr.data('max_col', cols.length)
			
			$.each (cols, function(k,v){
				var td = $('<td></td>').css('text-align', 'center')
				td.data('value', v)
				td.html(v)
				td.attr('id', 'cell-'+row+'-'+k);
				
				if (row == 0 && k == 0) {
					td.addClass('cursor-start')
				}
				
				tr.append(td)
			})
			
			$('#part_container').append(tr)
		})
			
		$(window).scrollTop(0)
		start_timer()
	}
	
	// CONTROL
	enter = function() {
		var collection = []
		
		if (cursor_row > start_row) {
			$('#row-'+start_row).fadeOut(function(){
				$(this).remove();
			})
		}
		
		start_col = cursor_col
		start_row = cursor_row
		
		$('.cursor-selected').each(function(){
			var value = $(this).data('value')
			collection.push(value)
			$(this).removeClass('cursor-selected').addClass('cursor-stored')
		})
		
		if (collection.length > 0) {
			// Add to jawaban_current_part
			jawaban_current_part.push(collection.join(','))
		}
	}
	
	back = function() {
		if (cursor_col == start_col && cursor_row == start_row) {
			return false;
		}
		
		$('#cell-'+cursor_row+'-'+cursor_col).removeClass('cursor-start')
		
		if (cursor_col == 0 && cursor_row > start_row) {
			var max_col = $('#row-'+cursor_row).data('max_col')
			cursor_row-=1
			cursor_col = max_col
		}
		
		cursor_col -= 1
		$('#cell-'+cursor_row+'-'+cursor_col).addClass('cursor-start').removeClass('cursor-selected')
	}
	
	next = function() {
		var max_col = $('#row-'+cursor_row).data('max_col')
		$('#cell-'+cursor_row+'-'+cursor_col).removeClass('cursor-start').addClass('cursor-selected')
		cursor_col += 1
		
		if (cursor_col == max_col) {
			cursor_col = 0;
			cursor_row+= 1;
		}
		
		$('#cell-'+cursor_row+'-'+cursor_col).addClass('cursor-start')
	}
	
	var ambil_soal_pauli = function(tutorial){
		$.ajax({
			data: {library: library, code: code, tutorial: tutorial},
			dataType: 'JSON',
			complete: function(){
				$('#start_quiz_button').html('Mulai Test').prop('disabled', false);
			},
			success: function(data) {
				if (data.rows) {
					if (! data.rows.version) {
						// kalau tidak ditemukan versi, maka kirim ulang
						ambil_soal_pauli(2)
					}
					else {
						if (data.rows.part.length > 0) {
							$('#petunjuk_pauli').hide()
							$('#quiz_pauli').show()
							
							arr_part = data.rows.part
							current_part = 0;
							timer = data.rows.timer;
							
							generate_part(current_part)
							
							// Ubah tombol ?Petunjuk
							var petunjuk_button = $('<a></a>').attr('href', 'javascript:void(0)').html('<span class="oi oi-question-mark"></span> Petunjuk')
							petunjuk_button.on('click', function(){
								if ($('#petunjuk_pauli').is(':hidden')) {
									$('#petunjuk_pauli').show()
								} else {
									$('#petunjuk_pauli').hide()
								}
								$('#start_quiz_button').hide();
							})
							$('ol.breadcrumb > li.mr-3').append(petunjuk_button)
						}
					}
				}
			},
			type: 'POST',
			url: QUESTIONS_URL,
		})
	}
	
	$('#start_quiz_button').on('click', function(){
		$(this).html('Silahkan tunggu&hellip;').prop('disabled', true);
		
		// Ambil Soal
		ambil_soal_pauli(0)
	})
})

$(document).on('keydown', function(event) {

	if (block == true)
		return;

	switch (event.keyCode)
	{
		case 39: // kanan
			$('#next_button').trigger('click')
		break;		
		
		case 37: // kiri
			$('#back_button').trigger('click')
		break;
		
		case 13: // enter
			enter()
		break;
	}
})
</script>
