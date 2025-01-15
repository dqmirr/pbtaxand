<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="<?= base_url('assets/images/favicon.ico');?>" />
    
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/open-iconic-bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/base.css');?>" />
	<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
	<link rel='stylesheet' href='<?php echo base_url('assets/css/styles.css'); ?>' />
	<script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
	<link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
	
	<script src="https://jsuites.net/v4/jsuites.js"></script>
	<link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
	
	<style>
		.body-bg-image-disclaimer {
			background-image:url('/assets/images/bg-disclaimer.jpeg');
			background-repeat: no-repeat;
			background-size: 100vw 93vh;
			position: absolute;
			left: 0px;
			width: 100vw;
			bottom: 0;
		}
	</style>
	<style>
	#story_container{
		background-color:var(--light);
		border-radius: 1rem;
	}
	.btn-outline-primary{
		background-color: var(--light)
	}

	#soal_container{
		font-size: 1.5rem;
	}

	#soal_container ol{
		font-size: 1.5rem;
		font-weight: bold;
	}

	#soal_container ol li {
		font-weight: 500;
		font-size: 1.5rem;
	}

	#soal_container ul,
	#soal_container ol {
		margin-left: 1.5rem;
	}

	#jawaban_container .col .btn {
		font-size: 1.5rem;
		white-space: normal;
   		word-wrap: break-word;
	}

	#jawaban_container .jawaban_label table{
		width:100%;
	}

	#jawaban_container .jawaban_label {
		overflow-x: auto;
	}
</style>
	<title>Preview - Soal</title>
</head>
<body id="QuixTaxand">
	<h4 id="badge-info" style="position: absolute; top: 5px; left: 5px; z-index: 1026;" ng-cloak></h4>
	
	<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light justify-content-between header">
		<a id="a_logo" class="navbar-brand" href="<?php echo site_url('/');?>">
			<?php if ($this->config->item('app_header_logo') != ''):?>
				<img src="<?php echo base_url($this->config->item('app_header_logo'));?>" alt="<?php echo $this->config->item('app_name');?>" />
			<?php else:?>
				<?php echo $this->config->item('app_name');?>
			<?php endif;?>
		</a>
		
		<div>
			<a href="/faq" onclick="this.target = ''; window.open(this.href, '', 'width=1024,height=600'); return false;" style="margin-left: 10px; margin-right: 10px;" title="Frequently Asked Questions - Online Test Pbtaxand" target="FAQ">FAQ</a>
			<button class="btn btn-outline-danger" type="button" id="logout_button">Logout</button>
		</div>
	</nav>
	
	{breadcrumb}
	
	<div class="container-fluid container-body">
		<div class="body-bg-image-disclaimer"></div>
		<div class="container">
			<div class="row d-flex justify-content-center">
			<div id="info_tutorial" class="bg-light" style="display:none;border-radius:1rem; padding: 0.5rem;"></div>
			<div class="col-12">
				<div class=" yt-2 pb-5" style="height: 75vh; overflow-y:auto; margin-top: auto;">
					<div class="row m-2">
						<div class="col">
							<button class="btn btn-outline-primary mb-2" id="btn_petunjuk">Petunjuk</button>
							
							<style>
	#story_container{
		background-color:var(--light);
		border-radius: 1rem;
	}
	.btn-outline-primary{
		background-color: var(--light)
	}

	#soal_container{
		font-size: 1.5rem;
	}

	#soal_container ol{
		font-size: 1.5rem;
		font-weight: bold;
	}

	#soal_container ol li {
		font-weight: 500;
		font-size: 1.5rem;
	}

	#soal_container ul,
	#soal_container ol {
		margin-left: 1.5rem;
	}

	#jawaban_container .col .btn {
		font-size: 1.5rem;
		white-space: normal;
   		word-wrap: break-word;
	}

	#jawaban_container .jawaban_label table{
		width:100%;
	}

	#jawaban_container .jawaban_label {
		overflow-x: auto;
	}
</style>
<!-- petunjuk -->
<div id="petunjuk">
    <div class="row">
        <div class="col">
            <?php if ($code == 'english'):?>
            <p>Petunjuk Business English</p>
			<p id="infoTotalSoal"></p>
            <ol>
                <li>
                    Pada subtes ini, Anda akan dihadapkan pada dua bagian soal, <b>Incomplete Sentences</b> & <b>Reading Comprehension</b>.
                </li>
                <li>
                    Pada bagian <b>Incomplete Sentences</b>, Anda diminta untuk memilih kata yang tepat dari 4(empat) pilihan jawaban untuk melengkapi kalimat dari masing-masing persoalan.
                </li>
                <li>
                    Pada bagian <b>Reading Comprehension</b>, Anda diminta untuk membaca terlebih dahulu suatu bacaan yang tersedia, seperti potongan artikel, surat, majalah, dan iklan. Setelah itu, Anda diminta untuk menjawab pertanyaan sesuai dengan bacaan yang Anda baca.
                </li>
                <li>
                    Selamat mengerjakan dan semoga sukses!
                </li>
            </ol>
			<?php elseif($code == 'english_taxand'):?>
				<p>Petunjuk English:</p>
				<p id="infoTotalSoal"></p>
				<ul style="list-style-type:none;">
					<li> 
						<h4>WRITTEN EXPRESSION</h4>	
						<p>Identify the one underlined word or phrase that must be changed in order for the sentence to be correct.</p>
					</li>		
						
					<li>
						<h4>GRAMMAR</h4>		
						<p>Choose the grammatically correct word or phrase to complete the following sentences.</p>	
					</li>
					
					<li>
						<h4>STRUCTURE</h4>		
						<p>Choose the one word or phrase that best completes the sentence.</p>
					</li>
						
					<li>
						<h4>Reading Comprehension</h4>
						<p>Read the following passage carefully</p>
					</li>
				</ul>
            <?php else:?>
            <p>Petunjuk:</p>
            <p>
                Pilihlah satu jawaban yang tepat. Selamat mengerjakan dan semoga sukses!
            </p>
			<p id="infoTotalSoal"></p>
            <?php endif;?>
        </div>
    </div>
</div>
<!-- Soal dan Opsi jawaban -->
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col mb-3">
            <h1></h1>
        </div>
    </div>
    <div class="row">
        <div class="col mx-2 mb-2">
            <span></span> <span></span>
        </div>
    </div>
    <div class="row">
        <div class="col my-1 col-12">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <div class="row">
                <div class="col border mx-3 my-3 px-3 py-3"></div>
            </div>
        </div>
    </div>
</div>
<div id="main" style="display: none;">
	<div class="panel-soal">
		<div id="group_soal" style="display: none;">
			<h4 class="text-center"></h4>
			<hr />
		</div>
		<div class="row" id="story_container"></div>
		<div class="row" id="soal_container"></div>
		<div class="row" id="opsi_container"></div>
	</div>
	<div class="row" id="jawaban_container"></div>
</div>
<script>
set_soal = function() {
    // khusus untuk multiplechoice index dimulai dari 1001
    // if (index == 0) {
    //     index = 1001
    // }
    
    row  = {
		"id_soal":"7704",
		"soal":"Bimo adalah staf akuntansi yang bertanggung jawab melakukan aktivitas rekonsiliasi bank. Pada bulan April 2017, diperoleh informasi penyebab perbedaan adalah terdapat cek kosong (<i>not sufficient fund check<\/i>) senilai Rp 15.000.000 dan cek yang masih beredar (<i>outstanding checks<\/i>) senilai Rp 25.000.000. Jurnal yang tepat dicatat oleh Bimo terkait dengan rekonsiliasi bank adalah:",
		"jawaban":[
			{"choice":"a","label":"Tidak ada pencatatan jurnal","id":"32700"},
			{"choice":"b","label":"Dr. Kas  Rp 15.000.000<br\/>&nbsp;&nbsp;&nbsp;&nbsp;Cr. Utang Rp 15.000.000","id":"32701"},
			{"choice":"c","label":"Dr. Piutang Rp 15.000.000 <br \/> &nbsp;&nbsp;&nbsp;&nbsp;Cr. Kas  Rp 15.000.000","id":"32702"},
			{"choice":"d","label":"Dr. Utang   Rp 25.000.000<br>&nbsp;&nbsp;&nbsp;&nbsp;Cr. Kas  Rp 25.000.000","id":"32703"},
			{"choice":"e","label":"Dr. Kas Rp 25.000.000 <br\/>&nbsp;&nbsp;&nbsp;&nbsp;Cr. Piutang\t\tRp 25.000.000","id":"32704"}
		],
		"show_next":0,
		"img_path":null,
		"post_soal":null,
		"group_name":"Accounting",
		"no":1
	};
	
    $('#soal_container, #opsi_container, #jawaban_container, #story_container').html('')
    $('#group_soal').hide()

	// let totalSoal = Object.keys(quiz_data).length
	// if(!Number.isNaN(totalSoal) && totalSoal > 0){
	// 	let e_totalSoal = document.querySelector('#infoTotalSoal')
	// 	e_totalSoal.innerHTML = `
	// 		total soal ${totalSoal}
	// 	`
	// }

    if (row.group_name !== undefined) {
        $('#group_soal > h4').text(row.group_name)
        $('#group_soal').show()
    }
    
	console.log(row);
    var clone = $('#soal_clone > div:eq(0) > .col').clone()
	var soal = `
	<div style="display:flex;width:100%;overflow-wrap: break-word;">
		<div style="display:flex;flex:0 0 auto;">${row.no}.&nbsp;</div>
		<div style="display:flex;flex:1 1 auto; width: 100%;flex-direction:column; padding-top:-10px;">  
		${row.soal}
		</div>
	</div>
	`;

    clone.html(soal)
    
    $('#soal_container').append(clone)

	$('#soal_container span').css('font-size','inherit');
	$('#main').css('display', 'block');
	
	var i = 0
    $.each(row.jawaban, function(k,v){
        var clone = $('#soal_clone > div:eq(2) > .col').clone()
        clone.find('button').html(`<div class="row">
										<div class="col-1 d-flex justify-content-center align-items-start">
										${typeof(v.choice)=='string'?v.choice.toUpperCase():v.choice}.
										</div>
										<div class="col-11 d-flex flex-column justify-content-start align-items-start jawaban_label" style="text-align: left;"> 
										${v.label}
										</div>
									</div>
										`).val(v.id).data('id', row.id_soal)
        
        clone.find('button').on('click', function(){
            $('#jawaban_container > .col > button').removeClass('active')
            $(this).addClass('active')
            
            if ($(this).data('jawaban') == undefined) {
                simpan_jawaban($(this).data('id'), $(this).val())
            }
            else {
                if ($(this).data('jawaban') == $(this).val()) {
                    jawaban_benar()
                }
                else {
                    jawaban_salah()
                }
            }
        })
        
        $('#jawaban_container').append(clone)
        
        // // opsi
        // clone = $('#soal_clone > div:eq(1) > .col').clone()
        // clone.removeClass('col').addClass('col-12')
        // clone.find('span:eq(0)').text(v.choice)
        // clone.find('span:eq(1)').text(v.label)
        
        // $('#opsi_container').append(clone)
		i++;
    })

	let elementstr = document.querySelectorAll("#jawaban_container table tr")
	
	for(let elementtr of elementstr){
		let counttd = (elementtr.children.length)
		for(let i of (elementtr.children)){
			i.classList.add(`col-${12/counttd}`);
		}

	}

    if (row.story_index !== undefined) {
        var clone = $('#soal_clone > div:eq(3) > .col').clone()
        var story = arr_story[row.story_index]
		
        clone.find('.col').html(story)
        
        $('#story_container').append(clone)
		$('#soal_clone').css('display','none')
		$('#story_container span').css('font-size','1rem');
    }
}
set_soal();
</script>




						</div>
					</div>

					<div class="row mt-3" id="benar_salah" style="display: none">
						<div class="col" style="display: none">
							<div class="alert alert-danger text-center">
								Jawaban Salah
							</div>
						</div>
						<div class="col" style="display: none">
							<div class="alert alert-success text-center">
								Jawaban Benar
							</div>
						</div>
					</div>

					<div class="row mx-3 text-center my-4">
						<div class="col" style="display: none;">
							<button type="button" class="btn btn-outline-success btn-block" id="next_button">
								Pertanyaan Selanjutnya
							</button>
						</div>
						<div class="col" style="display: none;">
							<button type="button" class="btn btn-warning btn-block" id="finish_button">
								Simpan jawaban dan menutup quiz.
							</button>
						</div>
						<div class="col" style="display: none;">
							<button class="btn btn-primary btn-block" id="start_tutorial_button">
								Mulai Tutorial
							</button>
						</div>
						<div class="col" style="display: none;">
							<button class="btn btn-primary btn-block" id="ulangi_tutorial_button">
								Ulangi Tutorial
							</button>
						</div>
						<div class="col" style="display: none;">
							<button class="btn btn-warning btn-block" id="start_test_button">
								Mulai Test
							</button>
						</div>
						<div class="col" style="display: none;">
							<button class="btn btn-info btn-block" id="retry_button">
								Retry
							</button>
						</div>
						<div class="col" style="display: none;">
							<img src="<?php echo base_url('assets/images/loading.gif');?>" id="button_loader" />
						</div>
					</div>

					<div id="block_ui" class="block_ui" style="display: none;background-color: #ffffff80; padding: 1rem;">
						<table class="modal-center">
							<tbody>
								<tr>
									<td>
										<div class="block-content text-center">
											Sedang mengirim jawaban. Silahkan tunggu.
											<br />
											<img src="<?php echo base_url('assets/images/loading.gif');?>" />
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<!-- <div class="col-4 px-2 display-none">
				<div class="card-transparent p-2 d-flex flex-wrap list-soal-number justify-content-center"></div>
			</div> -->
		</div>
		</div>
	</div>
	
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_title">Alert</h5>
					<button id="custButton" type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p id="msg"></p>
				</div>
				<div class="modal-footer">
					<button id="closerButton" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<script>var logoutUrl = '<?php echo site_url('auth/ajax_logout');?>'; var clientUsername = '<?php echo md5($this->session->userdata('username'));?>';</script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script>feather.replace()</script>
</body>
</html>
