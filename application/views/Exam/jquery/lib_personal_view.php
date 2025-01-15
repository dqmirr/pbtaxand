<style>
	#soal_container .col h4{
		font-size: 1.5rem;
	}

	#opsi_container .col .btn {
		font-size: 1.5rem;
		white-space: normal;
   		word-wrap: break-word;
	}
</style>
<!-- petunjuk -->
<div id="petunjuk">
    <div class="row">
        <div class="col">
            <p>Petunjuk:</p>
<?php 
/******************************
*        PERSONAL HEXACO      *
*******************************/
if (in_array($sub_library, array('hexaco'))):?>
<script>
var opsi_lookup = ['Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju'];
</script>
<ol>
    <li>
        Setiap soal terdiri dari 1 pernyataan dengan 5 pilihan jawaban yaitu Sangat Setuju, Setuju, Netral, Tidak Setuju, dan Sangat Tidak Setuju. Seperti contoh di bawah ini. 
        <div class="row my-3">
            <?php foreach (array('Sangat Setuju', 'Setuju', 'Netral', 'Tidak Setuju', 'Sangat Tidak Setuju') as $btn_text):?>
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-primary"><?=$btn_text;?></button>
            </div>
            <?php endforeach;?>
        </div>
    </li>
    <li>
        Pilihlah jawaban yang paling sesuai dengan diri Anda.
    </li>
    <li>
        Jawablah secara jujur dan spontan dengan mengklik salah satu dari pilihan jawaban tersebut.
    </li>
    <li>
        Jika sudah memahami petunjuk, silakan klik tombol <b>Mulai Test</b> untuk melanjutkan ke soal berikutnya.
    </li>
    <li>
        Waktu pengerjaan tes ini terbatas, untuk itu gunakan waktu Anda semaksimal mungkin.
    </li>
    <li>
        Selamat mengerjakan dan semoga sukses!
    </li>
</ol>
<?php
/******************************
*        PERSONAL CTI      *
*******************************/
elseif (in_array($sub_library, array('cti'))):?>
<script>
var opsi_lookup = ['Pasti Benar', 'Hampir/Banyak Benarnya', 'Ragu-ragu', 'Hampir/Banyak salahnya', 'Pasti Salah'];
</script>
<ol>
    <li>
        Test ini terdiri dari 1 pernyataan dengan 5 pilihan jawaban yaitu Pasti Benar, Hampir/Banyak Benarnya, Ragu-ragu, Hampir/Banyak salahnya, dan Pasti Salah, seperti tampilan dibawah ini.  
        <div class="row my-3">
            <?php foreach (array('Pasti Benar', 'Hampir/Banyak Benarnya', 'Ragu-ragu', 'Hampir/Banyak salahnya', 'Pasti Salah') as $btn_text):?>
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-primary"><?=$btn_text;?></button>
            </div>
            <?php endforeach;?>
        </div>
    </li>
    <li>
        Pilihlah jawaban yang paling sesuai dengan diri Anda.
    </li>
    <li>
        Jawablah secara jujur dan spontan dengan mengklik pilihan jawaban tersebut.
    </li>
    <li>
        Jika sudah memahami petunjuk dengan jelas, silahkan klik tombol <b>Mulai Test</b> untuk mulai mengerjakan soal.
    </li>
    <li>
        Anda memiliki waktu pengerjaan yang terbatas, untuk itu gunakan waktu anda semaksimal mungkin.
    </li>
    <li>
        Selamat mengerjakan dan semoga sukses!
    </li>
</ol>
<?php
/******************************
*        PERSONAL D3AD        *
*******************************/
elseif (in_array($sub_library, array('d3ad'))):?>
<ol>
    <li>
        Setiap soal pada tes ini terdiri dari 2 pernyataan.
    </li>
    <li>
        Tugas Anda sederhana yaitu memilih salah satu pernyataan yang paling sesuai/menggambarkan diri Anda.
    </li>
    <li>
        Jika diantara kedua pernyataan tersebut tidak ada yang menggambarkan diri Anda, Anda tetap harus memilih salah satu diantara pernyataan tersebut.
    </li>
    <li>
        Jawablah secara jujur dan spontan dengan mengklik pilihan jawaban tersebut.
    </li>
    <li>
        Anda memiliki waktu pengerjaan yang terbatas, untuk itu gunakan waktu Anda semaksimal mungkin.
    </li>
    <li>
        Jika sudah memahami petunjuk, silakan klik tombol <b>Mulai Test</b> untuk mengerjakan persoalan berikutnya.
    </li>
    <li>
        Selamat mengerjakan dan semoga sukses!
    </li>
</ol>
<?php
/*******************************
 *    PERSONAL PSIKOSOMATIS    *
 *******************************/
elseif ($sub_library == 'psikosomatis'):?>
<script>
var opsi_lookup = {1:'Ya',0:'Tidak'};
</script>
<ol>
    <li>
        Test ini terdiri dari 1 pernyataan dengan 2 pilihan jawaban yaitu Ya dan Tidak, seperti tampilan dibawah ini.  
        <div class="row my-3">
            <?php foreach (array('Ya', 'Tidak') as $btn_text):?>
            <div class="col">
                <button type="button" class="btn btn-block btn-outline-primary"><?=$btn_text;?></button>
            </div>
            <?php endforeach;?>
        </div>
    </li>
    <li>
        Pilihlah jawaban yang paling sesuai dengan diri Anda.
    </li>
    <li>
        Jawablah secara jujur dan spontan dengan mengklik pilihan jawaban tersebut.
    </li>
    <li>
        Jika sudah memahami petunjuk dengan jelas, silahkan klik tombol <b>Mulai Test</b> untuk mulai mengerjakan soal.
    </li>
    <li>
        Anda memiliki waktu pengerjaan yang terbatas, untuk itu gunakan waktu anda semaksimal mungkin.
    </li>
    <li>
        Selamat mengerjakan dan semoga sukses!
    </li>
</ol>
<?php endif;?>
        </div>
    </div>
</div>
<!-- Soal dan Opsi jawaban -->
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col text-center mb-3">
            <h4></h4>
        </div>
    </div>
    <div class="row">
        <div class="col col-12" style="margin:5px;font-size:64px">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <button type="button" class="btn btn-outline-dark btn-block"></button>
        </div>
    </div>
</div>
<style>
	#opsi_container > .col {
		margin:1rem;
	}

</style>
<!-- main -->
<div id="main" style="display: none;">
<?php if ($sub_library != 'd3ad'):?>
	<div class="panel-soal">
    	<div class="row" id="soal_container"></div>
	</div>
    <div class="row" id="opsi_container"></div>
<?php else:?>
    <div id="opsi_container"></div>
<?php endif;?>
</div>
<script>
set_soal = function() {
    row  = quiz_data[index]

    $('#soal_container, #opsi_container').html('')
    
    <?php if ($sub_library != 'd3ad'):?>
    $.each(row.soal, function(k,v){
        var clone = $('#soal_clone > div:eq(0) > .col').clone()
        clone.find('h4:eq(0)').text(v)
        
        $('#soal_container').append(clone)
    })
    
    $.each(row.opsi, function(k,v){
        var clone = $('#soal_clone > div:eq(1) > .col').clone()
        var text_opsi = opsi_lookup[k]
        clone.find('button').text(text_opsi).val(v).data('id', row.id)
        
        clone.find('button').on('click', function(){
            $('#opsi_container button').removeClass('active')
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
        
        $('#opsi_container').append(clone)
    })
    <?php else:?>
    $.each(row.soal, function(k,v){
        var clone = $('#soal_clone > div:eq(2)').clone()
        clone.find('button').text(v.text).val(v.id).data('id', row.id)
        
        clone.find('button').on('click', function(){
            $('#opsi_container button').removeClass('active')
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
        
        $('#opsi_container').append(clone)
    })
    <?php endif;?>
}
</script>
