<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['disable_info_login'] = 0;
$config['app_name'] = 'PB Taxand';
$config['app_logo'] = 'assets/images/logo.png';
$config['app_header_logo'] = 'assets/images/logo.png';
$config['admin_allow_host'] = array('127.0.0.1', '10.110.10.21','103.58.102.215','103.28.53.75','103.28.53.78','::1','192.168.1.7','103.127.97.160', '103.127.134.46', '172.18.0.3');
$config['app_greeting'] = '
Selamat Datang di Online Test PB Taxand.
';
$config['app_greeting1'] = '
<p>
Pbtaxand akan bekerja sama dengan Anda untuk melakukan serangkaian tes.
</p>
<p>
Tujuan pemeriksaan kali ini adalah untuk seleksi penerimaan karyawan. Untuk itu kami mohon kesediaan Anda untuk mengerjakannya secara optimal, agar mendapatkan hasil yang terbaik. 
</p>
<p>
Persoalan yang akan disajikan beraneka ragam, ada yang berupa kalimat dan juga hitungan. Namun, di setiap subtes, semua akan dijelaskan terlebih dahulu pada bagian petunjuk, sehingga Anda akan dapat mengerjakannya dengan baik.
</p>
<p>
Yang penting, bacalah petunjuk-petunjuk yang diberikan. Kerjakanlah sesuai dengan apa yang diperintahkan saja, jangan mengerjakan apa yang tidak diperintahkan. Jika belum memahami petunjuknya, bacalah dengan seksama instruksi yang diberikan sebelum Anda memulai untuk mengerjakan tes. 
</p>
<p>
Waktu pengerjaan dibatasi, tetapi cukup. Batas waktu tersebut ada yang diberitahukan kepada Anda, dan ada yang tidak, sehingga Anda harus bekerja secara cepat, tepat, dan seteliti mungkin. Diingatkan kembali bahwa total waktu pengerjaan ini adalah 3 jam. Saat Anda sudah memulai mengerjakan, maka waktu per tes akan dimulai dan tidak dapat dihentikan. Jadi manfaatkanlah waktu sebaik-baiknya. 
</p>
<p>
Karena waktu yang terbatas, lebih baik saat Anda mengerjakan, Anda berada di lingkungan yan kondusif sehingga Anda tidak mudah teralihkan. Selain itu, alat komunikasi juga lebih baik untuk dinonaktifkan agar tidak mengganggu Anda saat proses pengerjaan. 
</p>
<p>
Selamat mengerjakan tes dan semoga sukses untuk Anda. 
</p>
<p>
<strong>
Jika Anda sudah siap, silahkan mulai mengerjakan dengan mengklik pilihan Open pada test Cognitive Assesment . Setelah selesai, silahkan lanjutkan ke tes Number  Agility.
</strong>
</p>
';

$config['app_greeting2'] = '
<p>Selamat datang dalam proses seleksi Pbtaxand. </p>
<p>Kami mohon kesediaan Anda untuk mengerjakan pemeriksaan pada tahap selanjutnya ini secara optimal, agar mendapatkan hasil yang terbaik.</p>
<p>Persoalan yang akan disajikan pada pemeriksaan kali ini berupa tes bahasa Inggris dan tes kepribadian. Anda tidak perlu khawatir karena di setiap subtes, semua akan dijelaskan terlebih dahulu pada bagian petunjuk, sehingga Anda akan dapat mengerjakannya dengan baik. Jika belum memahami petunjuknya, bacalah dengan seksama instruksi yang diberikan sebelum Anda memulai untuk mengerjakan tes.</p>
<p>Waktu pengerjaan dibatasi, tetapi cukup. Batas waktu tersebut ada yang diberitahukan kepada Anda, dan ada yang tidak, sehingga Anda harus bekerja secara cepat, tepat, dan seteliti mungkin. Saat Anda sudah memulai mengerjakan, maka waktu per tes akan dimulai dan tidak dapat dihentikan. Jadi manfaatkanlah waktu sebaik-baiknya.</p>
<p>Karena waktu yang terbatas, lebih baik saat Anda mengerjakan, Anda berada di lingkungan yang kondusif sehingga Anda tidak mudah teralihkan. Selain itu, alat komunikasi juga lebih baik untuk dinonaktifkan agar tidak mengganggu Anda saat proses pengerjaan.</p>
<p>Selamat mengerjakan tes dan semoga sukses untuk Anda.</p>
<p><strong>
Urutan Pengerjaan:
<ol>
<li>3A</li>
<li>Business English</li>
<li>Work Personality Assessment 1</li>
<li>Work Personality Assessment 2</li>
<li>Work Personality Assessment 3</li>
</ol>
<br />
Mohon untuk tidak mengklik tombol home atau logout pada saat mengerjakan test
</strong></p>
';

$config['app_greeting3'] = '
<p>
Selamat datang dalam proses seleksi Pbtaxand.
</p>
<p>
Kami mohon kesediaan Anda untuk mengerjakan pemeriksaan pada tahap ini secara optimal, agar mendapatkan hasil yang terbaik.
</p>
<p>
Waktu pengerjaan dibatasi, namun cukup. Batas waktu ini tidak akan diberitahukan kepada anda, sehingga Anda harus bekerja secara cepat, tepat, dan seteliti mungkin. 
</p>
<p>
Silahkan anda kerjakan <strong>Test GMA saja <span class="text-danger">pada saat wawancara</span></strong>. 
</p>
<p>
Sesuai peraturan, Tes GMA ini hanya boleh dilakukan pada saat wawancara. Nama anda akan dicatat jika melakukan tes sebelum wawancara. Jika anda melakukan tes sebelum wawancara, silahkan <strong>clear cache browser</strong> untuk melakukan tes pada saat wawancara.
</p>
<p>
Selamat mengerjakan test dan semoga sukses untuk anda.
</p>
';
/*
$config['app_disclaimer'] = '
<p>
Dengan ini saya menyatakan bahwa survei ini saya kerjakan sendiri tanpa diwakili atau dikerjakan oleh orang lain selain diri saya sendiri.
</p>
<p>
Saya bersedia mengikuti survei ini sebagai bagian dari Pemetaan Profil Pekerja Pbtaxand.
</p>
';
*/
$config['app_disclaimer'] = '
<p>
Dengan ini saya menyatakan bahwa saya yang memiliki data di bawah ini:
<br /><br />
Nama Lengkap : <strong>{SESSION_fullname}</strong>
<br />
Alamat email : <strong>{SESSION_email}</strong>
<br /><br />
Adalah benar peserta yang memiliki identitas di atas, sebagai peserta online test dan menyatakan bahwa tes ini saya ikuti tanpa diwakili atau dikerjakan oleh siapapun selain diri saya sendiri. 
<br /><br />'.
//Saya menyatakan bahwa saya bersedia mengikuti tes ini sebagai bagian dari proses seleksi calon kandidat karyawan {CONFIG_app_name} dan saya mengikutinya dengan sadar dan tanpa paksaan apapun.
'Setiap bentuk tindakan kecurangan selama online test ini akan memiliki konsekuensi seperti sanksi berupa gagal tes dan masuk daftar hitam perusahaan.
<br /><br />
Saya menyatakan bahwa saya bersedia mengikuti tes ini dan data yang diberikan dalam online test ini dapat digunakan untuk kepentingan Pbtaxand.'
.'</p>';
