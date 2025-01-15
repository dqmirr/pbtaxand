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
    if (index == 0) {
        index = 1001
    }
	
	if(quiz_data[index] == undefined){
		return
	}

    row  = quiz_data[index]
    $('#soal_container, #opsi_container, #jawaban_container, #story_container').html('')
    $('#group_soal').hide()

	let totalSoal = Object.keys(quiz_data).length
	if(!Number.isNaN(totalSoal) && totalSoal > 0){
		let e_totalSoal = document.querySelector('#infoTotalSoal')
		e_totalSoal.innerHTML = `
			total soal ${totalSoal}
		`
	}

    if (row && (row.hasOwnProperty("group_name") && row["group_name"] !== undefined)) {
        $('#group_soal > h4').text(row.group_name)
        $('#group_soal').show()
    }
    
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
</script>

