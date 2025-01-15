<style>

.soal-pci h1, .soal-jh h1 {
    font-size: 4em;
}
.soal-penalaran {
    font-size: 1.5rem;p
}
.soal-kka tr td {
    font-size: 2em;
    padding-left: 10px;
    padding-right: 10px;
}

#petunjuk {
	background-color: var(--bg-white-transparent);
	padding: 1.5rem;
	border-radius: 1rem;
}

#opsi_container .col .btn{
	font-size: 1.5rem !important;
}
</style>
<!-- petunjuk -->
<div id="petunjuk">
    <div class="row">
        <div class="col">
<?php 
/**********************
*        GTI PCI      *
***********************/
if (in_array($sub_library, array('gti_pci', 'gti_pci_r'))):?>
<?php 
if ($sub_library == 'gti_pci') {
    $petunjuk_pasangan = '3';
    $petunjuk_jawaban = '3 (tiga)';
    $gti_pci_yang_dicari = 'kesamaan';
    $gti_pci_yang_dicari_jawaban = 'sama';
}
else {
    $petunjuk_pasangan = '1';
    $petunjuk_jawaban = '1 (satu)';
    $gti_pci_yang_dicari = 'perbedaan';
    $gti_pci_yang_dicari_jawaban = 'beda';
}
?>
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col text-center soal-pci">
            <h1></h1>
            <h1></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
</div>
Lihat Contoh sebagai berikut: 
<div class="row mx-3">
    <div class="col text-center soal-pci">
        <h1>F</h1>
        <h1>f</h1>
    </div>
    <div class="col text-center soal-pci">
        <h1>G</h1>
        <h1>c</h1>
    </div>
    <div class="col text-center soal-pci">
        <h1>R</h1>
        <h1>r</h1>
    </div>
    <div class="col text-center soal-pci">
        <h1>S</h1>
        <h1>s</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">0</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary <?=($sub_library == 'gti_pci_r') ? 'active' : '';?>">1</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">2</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary <?=($sub_library == 'gti_pci') ? 'active' : '';?>">3</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">4</button>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <p>
            Di dalam setiap kotak terdapat pasangan huruf di setiap soal, pada contoh di atas pasangan huruf tersebut berada di dalam kotak yang membatasinya.
        </p>
        <p>
            Tugas Anda adalah menghitung dari keempat pasangan huruf yang ada, <b>berapa jumlah pasangan huruf yang memiliki <?=$gti_pci_yang_dicari;?></b> antara huruf yang berada di baris atas dengan huruf yang tepat berada di baris bawahnya. 
        </p>
        <p>
            Pada contoh di atas, pasangan pertama huruf F dan f merupakan huruf yang sama.<br/>
            R dan r serta S dan s, pasangan ketiga dan keempat juga merupakan huruf yang sama.
        </p>
        <p>
            Pasangan kedua yakni G dan c, adalah pasangan yang <u>tidak sama</u>.
        </p>
        <p>
            Pada contoh di atas terdapat <?=$petunjuk_pasangan;?> pasangan huruf yang <?=$gti_pci_yang_dicari_jawaban;?>. Jawaban pada angka <?php echo $petunjuk_jawaban;?> merupakan jawaban yang benar untuk jawaban persoalan ini.
        </p>
    </div>
</div>

<?php 
/****************************
*        GTI PENALARAN      *
*****************************/
elseif (in_array($sub_library, array('gti_penalaran', 'gti_penalaran_2'))):?>
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col text-center soal-penalaran col-12"></div>
    </div>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <p>
            Setiap pertanyaan mengenai siapa yang lebih berat atau lebih ringan, siapa lebih tinggi atau lebih pendek, dan perbandingan-perbandingan lainnya dengan orang di sekitarnya.
        </p>
        <p>
            Simaklah dengan baik contoh-contoh berikut ini:
        </p>
    </div>
</div>
<?php if ($sub_library == 'gti_penalaran'):?>
<div class="row mb-3">
    <div class="col text-center soal-penalaran">
        Anton lebih berat daripada Dodi
    </div>
</div>
<div class="row mb-3">
    <div class="col text-center soal-penalaran">
        Siapa yang terberat?
    </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary active">
            Anton
        </button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">
            Dodi
        </button>
    </div>
</div>
<?php else:?>
<div class="row mb-3">
    <div class="col text-center soal-penalaran">
        Bonita lebih tua dari Edina, Edina lebih tua dari Puput, Puput lebih tua dari Evita. Manakah pernyataan di bawah ini yang paling benar?
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">
            Evita lebih tua dari Puput
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary active">
            Puput lebih muda dari Bonita
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">
            Edina lebih muda dari Puput
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">
            Edina lebih tua dari Bonita
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-block btn-outline-primary">
            Edina lebih muda dari Evita
        </button>
    </div>
</div>
<?php endif;?>
<?php 
/**********************
*        GTI JH      *
***********************/
elseif (in_array($sub_library, array('gti_jh', 'gti_jh_r'))):?>
<?php
$gti_jh_jarak = 'terjauh';
$gti_jh_B_active = '';
$gti_jh_I_active = 'active';
$gti_jh_jawaban_benar = 'I';
$gti_jh_text = 'besar (3 huruf) yaitu F;G;H. Sedangkan antara huruf B dan huruf E hanya memiliki 2 huruf: C dan D';

if ($sub_library == 'gti_jh_r') 
{
    $gti_jh_jarak = 'terdekat';
    $gti_jh_B_active = 'active';
    $gti_jh_I_active = '';
    $gti_jh_jawaban_benar = 'B';
    $gti_jh_text = 'kecil (2 huruf) yaitu C;D. Sedangkan antara huruf E dan huruf I memiliki 3 huruf: F, G dan H';
}
;?>
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col border mx-3 mb-3 text-center soal-jh">
            <h1></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <p>
            Pada saat mengerjakan tes ini, Anda harus <u>mengingat urutan huruf</u>.
        </p>
        <p>
            Perhatikan setiap kotak terdiri dari tiga buah huruf. 
            Ingat selalu urutan huruf itu. 
            Kemudian pilihlah satu huruf <?=$gti_jh_jarak;?> selisihnya dari huruf yang terletak di tengah, jika telah diurutkan secara benar, pilihlah huruf yang tersedia.
        </p>
        <p>
            Berikut contoh:
        </p>
    </div>
</div>
<div class="row">
    <div class="col mx-3 mb-3 border text-center soal-jh">
        <h1>B</h1>
    </div>
    <div class="col mx-3 mb-3 border text-center soal-jh">
        <h1>E</h1>
    </div>
    <div class="col mx-3 mb-3 border text-center soal-jh">
        <h1>I</h1>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block <?=$gti_jh_B_active;?>">B</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block <?=$gti_jh_I_active;?>">I</button>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <p>
        Jika diurutkan secara benar maka huruf <b>B</b> ada di urutan pertama, kemudian huruf <b>E</b> dan terakhir huruf <b>I</b> berdasarkan urutan hurufnya.
        </p>
        <p>
        Tugas Anda adalah mencari selisih yang <?=$gti_jh_jarak;?> dari huruf yang ada di tengah (huruf E) dengan huruf yang ada di sebelah kiri (huruf B) atau dengan huruf yang ada di sebelah kanan (huruf I). 
        </p>
        <table cellpadding="5" border="0" align="center">
            <tbody>
                <tr>
                    <td><h1 class="mr-3 ng-binding">B</h1></td>
                    <td><h4 class="text-secondary"><u>C</u></h4></td>
                    <td><h4 class="text-secondary"><u>D</u></h4></td>
                    
                    <td><h1 class="mr-3 ml-3 ng-binding">E</h1></td>
                    <td><h4 class="text-secondary"><u>F</u></h4></td>
                    <td><h4 class="text-secondary"><u>G</u></h4></td>
                    <td><h4 class="text-secondary"><u>H</u></h4></td>
                    
                    <td><h1 class="ml-3 ng-binding">I</h1></td>
                </tr>
                <tr valign="top">
                    <td colspan="3" align="right">
                        <span class="text-secondary selisih rotate r90">}</span>
                        <br>
                        2 Huruf
                    </td>
                    <td></td>
                    <td colspan="3" align="center">
                        <span class="text-secondary selisih rotate r90">}</span>
                        <br>
                        3 Huruf
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <p>
        Jawaban yang benar adalah <u>Huruf <?=$gti_jh_jawaban_benar;?></u> karena memiliki selisih yang lebih <?=$gti_jh_text;?>. Oleh karena itu pilihan jawaban yang tepat adalah <strong><?=$gti_jh_jawaban_benar;?></strong>. 
        </p>
    </div>
</div>
<?php 
/**********************
*        GTI KKA      *
***********************/
elseif (in_array($sub_library, array('gti_kka', 'gti_kka_r'))):?>
<?php
$gti_kka_jarak = 'terjauh';
$gti_kka_jawaban = '13';
$gti_kka_jawaban_huruf = 'C';
$gti_kka_jawaban_2 = '13';
$gti_kka_jawaban_huruf_2 = 'A';
$gti_kka_jawaban_text = '7 dengan angka 9 hanya ada satu angka yaitu: 8. Sedangkan di antara angka 9 dan 13 terdapat tiga angka yaitu: 10,11,12';

if ($sub_library == 'gti_kka_r')
{
    $gti_kka_jarak = 'terdekat';
    $gti_kka_jawaban = '7';
    $gti_kka_jawaban_huruf = 'A';
    $gti_kka_jawaban_2 = '4';
    $gti_kka_jawaban_huruf_2 = 'B';
    $gti_kka_jawaban_text = '9 dengan angka 13 ada tiga angka yaitu: 10,11,12. Sedangkan di antara angka 7 dan 9 hanya terdapat satu angka yaitu 8';
}
;?>
<div id="soal_clone" style="display: none;">
    <div>
        <table>
            <tbody>
                <tr>
                    <td class="text-right"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <p>
            Pilihlah angka <b>tertinggi</b> dan <b>terendah</b> dari setiap perangkat bilangan yang terdiri dari 3 angka. Kemudian tetapkan dimana angka yang <b><?=$gti_kka_jarak;?> selisihnya</b> dari angka yang tersisa/angka yang di tengah (<span style="color:red;">bukan bilangan yang tertinggi atau terendah</span>).
        </p>
        <p>
            Berikut Contoh: 
        </p>
        <table align="center">
            <tbody>
                <tr align="right">
                    <td rowspan="3">
                        <table style="height: 80px;">
                            <tbody>
                                <tr>
                                    <td align="right"><h4 style="position: relative; top: 5px; margin-right: 10px;">8</h4></td>
                                    <td><h1>{</h1></td>
                                </tr>
                                <tr>
                                    <td align="right"><h4 style="position: relative; top: -5px; margin-right: 10px;">10, 11, 12</h4></td>
                                    <td><h1 style="position: relative; top: -10px;">{</h1></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    
                    <td rowspan="3" width="10px;">&nbsp;</td>
                    
                    <td><h2>7</h2></td>
                    <td rowspan="3" width="30px;">&nbsp;</td>
                    <td><h2>A</h2></td>
                </tr>
                <tr align="right">
                    <td><h2>9</h2></td>
                    <td><h2>B</h2></td>
                </tr>
                <tr align="right">
                    <td><h2>13</h2></td>
                    <td><h2>C</h2></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block <?=($sub_library == 'gti_kka_r')?'active':'';?>">A</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">B</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block <?=($sub_library == 'gti_kka')?'active':'';?>">C</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <p>
            Setelah angka-angka diurutkan dalam pikiran Anda, maka diketahui angka 7 adalah angka terendah, dan angka 13 adalah angka tertinggi.
        </p>
        <p>
            Angka manakah di antara dua angka tersebut yang <?=$gti_kka_jarak;?> jaraknya dari angka yang berada di tengah (angka 9)?
        </p>
        <p>
            Jawabannya adalah angka <?=$gti_kka_jawaban;?>, karena di antara angka <?=$gti_kka_jawaban_text;?>. Oleh karena itu jawaban yang benar adalah huruf <?=$gti_kka_jawaban_huruf;?>.
        </p>
        <p>
            Contoh lainnya: 
        </p>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <table align="center" class="soal-kka">
            <tbody>
                <tr>
                    <td class="text-right">13</td>
                    <td>A</td>
                </tr>
                <tr>
                    <td class="text-right">4</td>
                    <td>B</td>
                </tr>
                <tr>
                    <td class="text-right">8</td>
                    <td>C</td>
                </tr>
            </tbody>
        </table>
    </div>
    
</div>
<div class="row mb-3">
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block <?=($sub_library == 'gti_kka')?'active':'';?>">A</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block <?=($sub_library == 'gti_kka_r')?'active':'';?>">B</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">C</button>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <p>
             Pada contoh ini angka tidak berurutan dari rendah ke tinggi, namun sudah diacak.
             <br />
            Tugasnya tetap sama yaitu:
            <ol>
                <li>
                Menemukan angka <b>terendah</b> dan <b>tertinggi</b> (dalam pikiran Anda).
                </li>
                <li>
                Tetapkan angka mana yang mempunyai selisih <?=$gti_kka_jarak;?> dari angka tersisa.
                </li>
                <li>
                Pilih jawabah sesuai huruf yang ada di samping angka pilihan Anda.
                </li>
                <li>
                Jawabannya adalah <b><?=$gti_kka_jawaban_2;?></b>, maka pilih jawaban <?=$gti_kka_jawaban_huruf_2;?>.
                </li>
            </ol>
        </p>
    </div>
</div>
<?php 
/****************************
*        GTI ORIENTASI      *
*****************************/
elseif (in_array($sub_library, array('gti_orientasi', 'gti_orientasi_2'))):?>
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col">
            <img src="" />
            <div style="height: 100px;"></div>
            <img src="" />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
</div>
<?php if ($sub_library == 'gti_orientasi_2'):?>
<div class="row">
    <div class="col">
        <p>
             Tes ini menggunakan dua huruf. Huruf F dan R dengan dua bentuk dasar, huruf F dan R yang di atas dan dibawah ini adalah berbeda antara satu dengan yang lainnya meski pada bentuk awalnya sama yakni huruf F dan huruf R. 
        </p>
    </div>
</div>
<div class="row text-center">
    <div class="col border py-3">
        <img src="<?php echo base_url('assets/images/orientasi/a5.png');?>" />
        <div style="height: 30px;"></div>
        <img src="<?php echo base_url('assets/images/orientasi/a4.png');?>" />
    </div>
    <div class="col border py-3">
        <img src="<?php echo base_url('assets/images/orientasi/b5.png');?>" />
        <div style="height: 30px;"></div>
        <img src="<?php echo base_url('assets/images/orientasi/b4.png');?>" />
    </div>
</div>
<div class="row my-3">
    <div class="col">
        <p>
            Di bawah ini sebenarnya adalah contoh yang SAMA antara bentuk yang ada setelah diputar 90<sup>o</sup>, 180<sup>o</sup>, atau 270<sup>o</sup>. Perputaran tersebut bisa searah jarum jam (ke kanan) atau berlawanan arah jarum jam (ke kiri). 
        </p>
    </div>
</div>
<div class="row text-center">
    <div class="col border py-3">
        <div class="row">
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a1.png');?>" />
                <div style="height: 30px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a4.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a2.png');?>" />
                <div style="height: 30px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a5.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a3.png');?>" />
                <div style="height: 30px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a6.png');?>" />
            </div>
        </div>
    </div>
    <div class="col border py-3">
        <div class="row">
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/b1.png');?>" />
                <div style="height: 30px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/b4.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/b2.png');?>" />
                <div style="height: 30px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/b5.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/b3.png');?>" />
                <div style="height: 30px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/b6.png');?>" />
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="row<?=($sub_library == 'gti_orientasi_2') ? ' my-3': '';?>">
    <div class="col">
        <p>
        Perhatikan contoh berikut. Berapa banyak bentuk-bentuk di bawah ini sama seperti bentuk <strong>atasnya</strong> setelah bentuk-bentuk itu diputar?
        <br />
        <strong>Bandingkan bentuk BAWAH dengan bentuk ATASNYA.</strong>
        </p>
    </div>
</div>
<div class="row">
    <div class="offset-lg-3 col-lg-6">
        <div class="row">
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a6.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a7.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a8.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a5.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a3.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a4.png');?>" />
            </div>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block active">0</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">1</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">2</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">3</button>
    </div>
</div>
<?php $huruf = ($sub_library == 'gti_orientasi_2') ? 'b' : 'a';?>
<div class="row">
    <div class="offset-lg-3 col-lg-6">
        <div class="row">
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/'.$huruf.'6.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/'.$huruf.'7.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/'.$huruf.'5.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/'.$huruf.'3.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/'.$huruf.'4.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/'.$huruf.'5.png');?>" />
            </div>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">0</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block active">1</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">2</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">3</button>
    </div>
</div>
<div class="row">
    <div class="offset-lg-3 col-lg-6">
        <div class="row">
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a7.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a3.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a5.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a3.png');?>" />
            </div>
            <div class="col">
                <img src="<?php echo base_url('assets/images/orientasi/a1.png');?>" />
                <div style="height: 100px;"></div>
                <img src="<?php echo base_url('assets/images/orientasi/a2.png');?>" />
            </div>
        </div>
    </div>
</div>
<div class="row my-3">
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">0</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">1</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block active">2</button>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-primary btn-block">3</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <p>
            Pastikan Anda memahami cara menjawabnya dengan benar. <strong>Anda harus menunjukkan berapa pasangan yang sama</strong>.
        </p>
    </div>
</div>
<?php 
/******************************
*        GTI 2D/3D/Kotak      *
*******************************/
elseif (in_array($sub_library, array('gti_2d', 'gti_3d' ,'gti_kotak'))):?>
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col">
            <img src="" />
        </div>
    </div>
    <div class="row">
        <div class="col">
            <img src="" class="img-fluid" style="height: 150px;" />
            <br />
            <button type="button" class="btn btn-outline-primary btn-block"></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
    <?php if (in_array($sub_library, array('gti_2d', 'gti_3d'))):?>
        <ul>
            <li>
                Pada tes ini, Anda akan diberikan satu bentuk gambar tertentu.
            </li>
            <li>
                Tugas Anda adalah memilih dari 5(lima) pilihan jawaban yang tersedia, bentuk manakah yang sama dengan bentuk pada soal yang diberikan.
            </li>
            <li>
                Untuk mendapatkan jawabannya, bentuk tersebut dapat Anda putar dalam pikiran Anda sampai Anda menemukan bentuk yang sama pada pilihan jawaban yang tersedia.
            </li>
        </ul>
        <p>
            Contoh soal:
        </p>
        <p class="text-center">
            <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'.jpg');?>" />
        </p>
        <p>
            Untuk contoh di atas, pilihan jawaban yang tepat adalah pilihan bentuk keempat (D).
        </p>
        <p>
            Cara mendapatkannya adalah dengan memutar bentuk pada soal searah dengan jarum jam (diputar ke kanan). 
        </p>
    <?php elseif (in_array($sub_library, array('gti_kotak'))):?>
    <p>
        Pada tes ini, Anda akan dihadapkan pada satu kotak besar yang di dalamnya terdapat suatu pola tertentu.
    </p>
    <p>
        Perhatikan bahwa di dalam kotak tersebut, ada bagian yang masih kosong.
    </p>
    <p>
        Tugas Anda adalah melengkapi bagian kosong tersebut dengan salah satu dari 8 (delapan) pilihan jawaban yang tersedia, bentuk manakah yang cocok mengisi bagian yang kosong dengan pola pada soal yang diberikan.
    </p>
    <p>
        Contoh: 
    </p>
    <p class="text-center">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_0.png');?>" />
    </p>
    <?php endif;?> 
    </div>
</div>
<?php if (in_array($sub_library, array('gti_kotak'))):?>
<div class="row mb-3 text-center">
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_1.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_2.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_3.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_4.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
</div>
<div class="row mb-3 text-center">
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_5.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_6.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block active">Pilih</button>
    </div>
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_7.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
    <div class="col">
        <img src="<?php echo base_url('assets/images/orientasi/'.$sub_library.'/petunjuk_8.png');?>" class="img-fluid" style="height: 92px;" />
        <br />
        <button type="button" class="btn btn-outline-primary btn-block">Pilih</button>
    </div>
</div>
<div class="row">
    <div class="col">
        <p>
            Bekerjalah secepat dan seteliti mungkin karena waktunya sangat terbatas! 
        </p>
    </div>
</div>
<?php endif;?>

<?php endif;?>
        </div>
    </div>
</div>
<!-- main -->
<div id="main" style="display: none;">
<?php if (in_array($sub_library, array('gti_pci', 'gti_pci_r', 'gti_jh', 'gti_jh_r'))):?>
	<div class="panel-soal">
    	<div class="row" id="soal_container"></div>
	</div>
<?php elseif (in_array($sub_library, array('gti_penalaran', 'gti_penalaran_2'))):?>
	<div class="panel-soal">
		<div class="row" id="soal_container" style="display: flex; flex-direction: column;"></div>
	</div>
<?php elseif (in_array($sub_library, array('gti_kka', 'gti_kka_r'))):?>
	<div class="panel-soal">
		<div class="row">
			<table class="soal-kka" align="center">
				<tbody id="soal_container">
				</tbody>
			</table>
		</div>
	</div>
<?php elseif (in_array($sub_library, array('gti_orientasi', 'gti_orientasi_2', 'gti_2d', 'gti_3d', 'gti_kotak'))):?>
	<div class="panel-soal">
		<div class="row mb-3">
			<div class="offset-lg-3 col-lg-6 text-center">
				<div class="row" id="soal_container"></div>
			</div>
		</div>
	</div>
<?php endif;?>
<?php if ($sub_library == 'gti_kotak'):?>
    <div id="opsi_container"></div>
<?php else:?>
    <div class="row" id="opsi_container"></div>
<?php endif;?>
</div>
<script>
set_soal = function() {
    row  = quiz_data[index]
    $('#soal_container, #opsi_container').html('')
    
    <?php if (in_array($sub_library, array('gti_2d', 'gti_3d', 'gti_kotak'))):
    if ($sub_library == 'gti_kotak') {
        $extra_path = '/soal';
    ?>
    var total_image = 1;
    var total_loaded = 0;
    
    $.each(row.opsi, function(k,v){
        $.each (v, function(a,b){
            total_image += 1
        })
    })
    
    <?php
    } else {
        $extra_path = '';
    ?>
    var total_image = 1;
    var total_loaded = 0;
    
    $.each(row.opsi, function(k,v){
        total_image += 1
    })
    
    <?php
    }
    ?>
    var image = {}
    var id_name = row.soal.replace('\.','').replace(/\//g,'')
    var clone = $('#soal_clone > div:eq(0) > .col').clone()
    clone.find('img:eq(0)').attr('src', '<?php echo base_url('assets/images/loading.gif');?>').attr('id', 'image_'+id_name).css('height', '200px')
    $('#soal_container').append(clone)
    
    image[id_name] = new Image();
    image[id_name].src = '<?php echo base_url('assets/images/orientasi/'.$sub_library.$extra_path);?>/'+ row.soal;
    image[id_name].dataset.id = '#image_'+ id_name
    
    image[id_name].onload = function() {
        var target = this.dataset.id
        $(target).attr('src', this.src)
        total_loaded = timer_unpause_watch(total_image, total_loaded)
    }
    
    <?php else:?>
    $.each(row.soal, function(k,v){
        <?php if (in_array($sub_library, array('gti_pci', 'gti_pci_r'))):?>
        var clone = $('#soal_clone > div:eq(0) > .col').clone()
        clone.find('h1:eq(0)').text(v[0])
        clone.find('h1:eq(1)').text(v[1])
        <?php elseif (in_array($sub_library, array('gti_penalaran', 'gti_penalaran_2'))):?>
        var clone = $('#soal_clone > div:eq(0)').clone()

		if(v.match(/[?]$/)){
			clone.find('.col').text(String(v).trim())
		}else{
			clone.find('.col').text(`${String(v).trim()}.`)
		}
        <?php elseif (in_array($sub_library, array('gti_jh', 'gti_jh_r'))):?>
        var clone = $('#soal_clone > div:eq(0) > .col').clone()
        clone.find('h1:eq(0)').text(v[0])
        <?php elseif (in_array($sub_library, array('gti_kka', 'gti_kka_r'))):?>
        var clone = $('#soal_clone > div:eq(0) > table > tbody > tr').clone()
        clone.find('td:eq(0)').text(v)
        clone.find('td:eq(1)').text(row.opsi[k])
        <?php elseif ($sub_library == 'gti_orientasi'):?>
        var clone = $('#soal_clone > div:eq(0) > .col').clone()
        clone.find('img:eq(0)').attr('src', '<?php echo base_url('assets/images/orientasi');?>/a'+ v[0] + '.png')
        clone.find('img:eq(1)').attr('src', '<?php echo base_url('assets/images/orientasi');?>/a'+ v[1] + '.png')
        <?php elseif ($sub_library == 'gti_orientasi_2'):?>
        if (k == 'img') {
            $.each(v, function(a,b){
                var clone = $('#soal_clone > div:eq(0) > .col').clone()
                clone.find('img:eq(0)').attr('src', '<?php echo base_url('assets/images/orientasi');?>/'+ row.soal.prefix + b[0] + '.png')
                clone.find('img:eq(1)').attr('src', '<?php echo base_url('assets/images/orientasi');?>/'+ row.soal.prefix + b[1] + '.png')
                
                $('#soal_container').append(clone)
            })
        }
        else {
            var clone = ''
        }
        <?php endif;?>
        
        $('#soal_container').append(clone)
    })
    <?php endif;?>
    
    $.each(row.opsi, function(k,v){
        var clone = $('#soal_clone > div:eq(1) > .col').clone()
        
        <?php if (in_array($sub_library, array('gti_pci', 'gti_pci_r', 'gti_orientasi', 'gti_orientasi_2'))):?>
        clone.find('button').text(v).val(v).data('id', row.id)
        <?php elseif (in_array($sub_library, array('gti_penalaran', 'gti_jh', 'gti_jh_r', 'gti_kka', 'gti_kka_r'))):?>
        clone.find('button').text(v).val(k).data('id', row.id)
        <?php elseif ($sub_library == 'gti_penalaran_2'):?>
        clone.find('button').text(v).val(k).data('id', row.id).css('white-space', 'normal')
        clone.removeClass('col').addClass('col-12').addClass('mb-3')
        <?php elseif (in_array($sub_library, array('gti_2d', 'gti_3d'))):?>
        var id_name = v.replace('\.','').replace(/\//g,'')
        clone.find('button').text('Pilih').val(v).data('id', row.id)
        clone.find('img').attr('src', '<?php echo base_url('assets/images/loading.gif');?>').attr('id', 'image_'+id_name)
        <?php elseif ($sub_library == 'gti_kotak'):?>
        clone = $('<div></div>').addClass('row mb-3 text-center')
        $.each (v, function(a,b){
            var clone_col = $('#soal_clone > div:eq(1) > .col').clone()
            var id_name = b.replace('\.','').replace(/\//g,'')
            clone_col.find('button').text('Pilih').val(a).data('id', row.id)
            clone_col.find('img').attr('src', '<?php echo base_url('assets/images/loading.gif');?>').attr('id', 'image_'+id_name).css('height', '92px')
            
            clone.append(clone_col)
        })
        <?php endif;?>
        
        if (row.jawaban) {
            clone.find('button').data('jawaban', row.jawaban)
        }
        
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
        
        <?php if (in_array($sub_library, array('gti_2d', 'gti_3d'))):?>
        // Baru diload setelah berhasil di-append
        image[id_name] = new Image();
        image[id_name].src = '<?php echo base_url('assets/images/orientasi/'.$sub_library);?>/'+ v;
        image[id_name].dataset.id = '#image_'+ id_name
        
        image[id_name].onload = function() {
            var target = this.dataset.id
            $(target).attr('src', this.src)
            total_loaded = timer_unpause_watch(total_image, total_loaded)
        }
        <?php elseif ($sub_library == 'gti_kotak'):?>
        $.each (v, function(a,b){
            id_name = b.replace('\.','').replace(/\//g,'')
            image[id_name] = new Image();
            image[id_name].src = '<?php echo base_url('assets/images/orientasi/'.$sub_library.$extra_path);?>/'+ b;
            image[id_name].dataset.id = '#image_'+ id_name
            
            image[id_name].onload = function() {
                var target = this.dataset.id
                $(target).attr('src', this.src)
                total_loaded = timer_unpause_watch(total_image, total_loaded)
            }
        })
        <?php endif;?>
    })
}
</script>
