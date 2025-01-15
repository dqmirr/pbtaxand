<?php
$img_path = base_url('assets/images/ist/group/');
?>
<style>
	#soal_container{
		padding: 2rem;
		margin-top: 5rem;
		background-color: var(--light);
		border-radius: 1rem;
		margin-bottom: 1rem;
	}
</style>
<!-- petunjuk -->
<div id="petunjuk">
    <div class="row">
        <div class="col">
<?php 
/***********************
*        IST ZR        *
************************/
if (in_array($sub_library, array('zr'))):?>
<p>
    Pada persoalan berikut akan diberikan deret angka.
    <br />
    Setiap deret tersusun menurut suatu aturan yang tertentu dan dapat dilanjutkan menurut aturan itu.
    <br />
    Carilah untuk setiap deret angka berikutnya dan ketiklah jawaban angka yang tepat. 
</p>
<p>
    <b>Contoh:</b>
</p>
<div class="row text-center mb-3" style="font-size: 32px;">
    <div class="col">2</div>
    <div class="col">4</div>
    <div class="col">6</div>
    <div class="col">8</div>
    <div class="col">10</div>
    <div class="col">12</div>
    <div class="col">14</div>
    <div class="col">?</div>
</div>
<p>
    Pada deret ini, angka berikutnya selalu didapat jika angka di depannya ditambah dengan 2.
    <br />
    Maka jawabannya ialah 16
    <br />
    Oleh karena itu, Anda akan diminta untuk mengetik angka 16 pada kolom yang tersedia. Kemudian tekan tombol <b>JAWAB</b> sehingga tanda <b>? (Tanda Tanya)</b> berubah menjadi angka yang diketik tadi. 
</p>
<p>
    <b>Contoh berikutnya:</b>
</p>
<div class="row text-center mb-3" style="font-size: 32px;">
    <div class="col">9</div>
    <div class="col">7</div>
    <div class="col">10</div>
    <div class="col">8</div>
    <div class="col">11</div>
    <div class="col">9</div>
    <div class="col">12</div>
    <div class="col">?</div>
</div>
<p>
    Pada deret ini, selalu berganti-ganti, harus dikurangi dengan 2 dan setelah itu ditambah dengan 3.
    <br />
    Jawaban contoh ini ialah : 10, maka dari itu Anda akan diminta untuk memilih angka 1 dan 0.
    <br />
    Kadang-kadang pada beberapa soal harus pula dikalikan atau dibagi. 
</p>
<?php
/***********************
*        IST FA        *
************************/
elseif (in_array($sub_library, array('fa'))):?>
<?php 
$sample1 = array(1=>'a','b','c','d','e');
$sample2 = array(6,7,8,9);
?>
<p>
    Pada persoalan berikutnya, setiap soal memperlihatkan sesuatu bentuk tertentu yang terpotong menjadi beberapa bagian.
</p>
<p>
    Carilah di antara bentuk-bentuk yang ditentukan (a,b,c,d,e), bentuk yang dapat dibangun dengan cara menyusun potongan-potongan itu sedemikian rupa, sehingga tidak ada kelebihan sudut atau ruang di antaranya.
</p>
<div class="row my-3">
    <?php foreach ($sample1 as $k => $button):?>
    <div class="col">
        <img class="img-fluid" src="<?=$img_path;?>fa_sample<?=$k;?>.png" />
        <br />
        <button class="btn btn-outline-primary btn-block" type="button"><?=$button;?></button>
    </div>
    <?php endforeach;?>
</div>
<div class="row my-3">
    <?php foreach ($sample2 as $k):?>
    <div class="col">
        <img class="img-fluid" src="<?=$img_path;?>fa_sample<?=$k;?>.png" />
    </div>
    <?php endforeach;?>
</div>
<p>
    <b>Contoh 6</b>
    <br />
    Jika potongan-potongan pada contoh 6 di atas disusun (digabungkan), maka akan menghasilkan bentuk a.
</p>
<p>
    <b>Contoh berikutnya :</b>
    <br />
    Potongan-potongan <b>contoh 7</b> setelah disusun (digabungkan) menghasilkan bentuk e.
    <br />
    <b>Contoh 8</b> menjadi bentuk b.
    <br />
    <b>Contoh 9</b> ialah bentuk d.
</p>
<?php
/***********************
*        IST WU        *
************************/
elseif (in_array($sub_library, array('wu'))):?>
<?php 
$sample1 = array(1=>'a','b','c','d','e');
$sample2 = array(6,7,8,9,10);
?>
<p>
    Ditentukan 5 (lima) buah kubus a,b,c,d,e. Pada tiap-tiap kubus terdapat enam tanda yang berlainan pada setiap sisinya. Tiga dari tanda itu dapat dilihat.
    <br />
    Kubus-kubus yang ditentukan itu (a,b,c,d,e) ialah kubus-kubus yang berbeda, artinya kubus-kubus itu dapat mempunyai tanda-tanda yang sama, akan tetapi susunannya berlainan.
    <br />
    Setiap soal memperlihatkan salah satu kubus yang ditentukan di dalam kedudukan yang berbeda.
    <br />
    Carilah kubus yang dimaksudkan itu dan jawablah pertanyaan tersebut dengan jawaban yang tepat.
    <br />
    Kubus itu dapat diputar, dapat digulingkan atau dapat diputar dan digulingkan dalam pikiran Saudara. Oleh karena itu, mungkin akan terlihat suatu tanda yang baru. 
</p>
<div class="row my-3">
    <?php foreach ($sample1 as $k => $button):?>
    <div class="col">
        <img class="img-fluid" src="<?=$img_path;?>wu_sample<?=$k;?>.png" />
        <br />
        <button class="btn btn-outline-primary btn-block" type="button"><?=$button;?></button>
    </div>
    <?php endforeach;?>
</div>
<div class="row my-3">
    <?php foreach ($sample2 as $k):?>
    <div class="col">
        <img class="img-fluid" src="<?=$img_path;?>wu_sample<?=$k;?>.png" />
    </div>
    <?php endforeach;?>
</div>
<p>
    <b>Contoh 1</b>
    <br />
    Contoh ini memperlihatkan kubus a dengan kedudukan yang berbeda.
    <br />
    Mendapatkannya adalah dengan cara menggulingkan lebih dahulu kubus itu ke kiri satu kali dan kemudian diputar ke kiri satu kali, sehingga sisi kubus yang bertanda dua segi empat hitam terletak di depan, seperti kubus a.
    <br />
    Maka, jawaban yang tepat adalah <b>a</b>.
</p>
<p>
    Contoh berikutnya:
    <br />
    <b>Contoh nomor 2</b> adalah <b>kubus e</b>.
    <br />
    Cara mendapatkannya adalah dengan digulingkan ke kiri satu kali dan diputar ke kiri satu kali, sehingga sisi kubus yang bertanda garis silang terletak di depan, seperti kubus e.
</p>
<p>
    <b>Contoh nomor 3</b> adalah <b>kubus b</b>.
    <br />
    Cara mendapatkannya adalah dengan menggulingkannya ke kiri satu kali, sehingga dasar kubus yang tadinya tidak terlihat memunculkan tanda baru (dalam hal ini adalah tanda dua segi empat hitam) dan tanda silang pada sisi atas kubus itu menjadi tidak terlihat lagi.
</p>
<p>
    <b>Contoh nomor 4</b> jawabannya adalah <b>kubus c</b>.
    <br />
    <b>Contoh nomor 5</b> jawabannya adalah <b>kubus d</b>.
</p>
<?php endif;?>
        </div>
    </div>
</div>
<!-- main -->
<div id="main" style="display: none;">
	<div class="panel-soal">
    	<div class="row" id="soal_container"></div>
	</div>
    <div class="row" id="jawaban_container" style="justify-content: center;"></div>
	<div id="soal_clone" style="display: none;">
	<?php if ($sub_library == 'zr'):?>
		<div class="row">
			<div class="col text-center mb-3">
				<h2></h2>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-lg-12" style="background-color:#ffffff; border-radius: 1rem;">
				<h3>Jawaban:</h3>
				
				<div class="input-group mb-3">
					<input type="text" class="form-control text-center" maxlength="2" size="2" style="font-size: 32px;" />
				</div>
			</div>
		</div>
	<?php else:?>
		<div class="row">
			<div class="offset-lg-4 col-lg-4 col-sm-12 text-center">
				<img class="img-fluid text-center" src="" />
			</div>
		</div>
		<div class="row">
			<div class="col m-2 p-2" style="background-color:var(--light); border-radius:1rem;">
				<img src="" class="img-rounded" style="height: 150px; width: 150px;" />
				<br />
				<button type="button" class="btn btn-outline-primary btn-block"></button>
			</div>
		</div>
	<?php endif;?>
	</div>
</div>
<script>
set_soal = function() {
    row  = quiz_data[index]
    
    $('#soal_container, #jawaban_container').html('')

    <?php if ($sub_library == 'zr'):?>
    $.each(row.soal, function(k,v){
        var clone = $('#soal_clone > div:eq(0) > .col').clone()
        clone.find(':first-child').text(v)
        $('#soal_container').append(clone)
    })
    
    // Soal
    clone = $('#soal_clone > div:eq(0) > .col').clone()
    clone.find(':first-child').text('?').addClass('text-primary').attr('data-jawaban','?')
    $('#soal_container').append(clone)
    
    // Jawaban
    clone = $('#soal_clone > div:eq(1) > div:eq(0)').clone()
    clone.find('input').data('id', row.id)
        
    clone.find('input').on('keyup change', function(){
        $(this).addClass('active')
        
        if ($(this).val() == '') {
            jawaban = '?'
            hide_next_button()
            return;
        }
        else {
            jawaban = $(this).val()
        }
        
        $('#soal_container').find('[data-jawaban]').html(jawaban)
        
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
    <?php else:?>
    opts = group_code[row.group]
    
    var total_image = 1 + Object.keys(opts).length;
    var total_loaded = 0
    var image = {}
    var id_name = row.soal.replace('\.','').replace(/\//g,'')
    var clone = $('#soal_clone > div:eq(0) > div').clone()
    clone.find('img:eq(0)').attr('src', '<?php echo base_url('assets/images/loading.gif');?>').attr('id', 'image_'+id_name).css('height', '200px')
    $('#soal_container').append(clone)
    
    image[id_name] = new Image();
    image[id_name].src = '<?php echo base_url('assets/images/ist/');?>/'+ row.soal;
    image[id_name].dataset.id = '#image_'+ id_name
    
    image[id_name].onload = function() {
        var target = this.dataset.id
        $(target).attr('src', this.src)
        total_loaded = timer_unpause_watch(total_image, total_loaded)
    }
    
    $.each (opts, function(a,b){
        var clone_col = $('#soal_clone > div:eq(1) > .col').clone()
        var id_name = b.replace('\.','').replace(/\//g,'')
        clone_col.addClass('text-center')
        clone_col.find('button').text(a).val(a).data('id', row.id)
        clone_col.find('img').attr('src', '<?php echo base_url('assets/images/loading.gif');?>').attr('id', 'image_'+id_name).css('height', '200px')
        
        clone_col.find('button').on('click', function(){
            $('#jawaban_container').find('button').removeClass('active')
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
        
        
        $('#jawaban_container').append(clone_col)
    })
    $.each (opts, function(a,b){
        id_name = b.replace('\.','').replace(/\//g,'')
        image[id_name] = new Image();
        image[id_name].src = '<?php echo base_url('assets/images/ist/group/');?>/'+ b;
        image[id_name].dataset.id = '#image_'+ id_name
        
        image[id_name].onload = function() {
            var target = this.dataset.id
            $(target).attr('src', this.src)
            total_loaded = timer_unpause_watch(total_image, total_loaded)
        }
    })
    
    <?php endif;?>
}
</script>
