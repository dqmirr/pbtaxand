<script src="<?php echo base_url('assets/js/gijgo.min.js');?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/gijgo.min.css');?>" />
<div class="row mt-3">
	<div class="col-lg-3 col-md-4 col-sm-10">
		<input id="datepicker" type="text" class="form-control" placeholder="Pilih Tanggal" aria-label="Pilih Tanggal" aria-describedby="basic-addon2" value="<?php echo $date;?>" />
	</div>
	<div class="col-lg-1 col-md-1 col-sm-2">
		<button type="button" class="btn btn-outline-secondary" id="ganti-tanggal">
			<span class="oi oi-reload mr-2"></span> Ganti
		</button>
	</div>
</div>
<?php foreach ($data as $row):?>
<div class="row mt-3" data-sesi="<?php echo $row->sesi_code;?>">
	<div class="col">
		<h4>Sesi: <strong><?php echo $row->label;?></strong></h4>
	</div>
	<div class="col">
		<h4>Peserta Hari ini: <strong><?php echo $row->total;?></strong></h4>
	</div>
</div>
<div class="row">
	<div class="col-8">
		<table class="table">
			<thead>
				<tr>
					<th>Selesai Mengerjakan: <span id="selesai_<?php echo $row->sesi_code;?>"></span></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<?php endforeach;?>

<script>
$(function(){
	
	$('#datepicker').datepicker({
		uiLibrary: 'bootstrap4',
		icons: {
			rightIcon: '<i class="oi oi-calendar"></i>'
		},
		iconsLibrary: 'fontawesome',
		format: 'yyyy-mm-dd'
	});
	
	$('#ganti-tanggal').on('click', function(){
		var tanggal = $('#datepicker').val()
		var target = '<?php echo $url.'index/';?>'+tanggal
		
		window.location.href = target
	})
	
	var reload_every_second = 30;
	
	var reload = function() {
		$('[data-sesi]').each(function(){
			var sesi_code = $(this).data('sesi')
			var tdate = '<?php echo $date;?>'
			
			$.ajax({
				data: {sesi_code : sesi_code, date: tdate},
				dataType: 'JSON',
				success: function(data) {
					if (data.selesai)
						$('#selesai_'+sesi_code).html(data.selesai)
				},
				type: 'POST',
				url: '<?php echo $url;?>ajax_get_statistik_baru'
			})
		})
			
		setTimeout(reload, reload_every_second * 1000)
	}

	reload()
})
</script>
