<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<a class="btn btn-primary my-2" href="<?= base_url("admin442e17d83025ac7201c9b487db03fe226f67808ad2912247d72fac704c624d7b/soal/multiplechoice/") ?>"> Kembali ke soal</a>
<?php echo $output;?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
