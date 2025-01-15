<div class="d-flex flex-column mt-2">
	<h4>Jenis Soal: <?=title($header)?></h4>	
	<?php 
	if(isset($list_data))
	{
		$grouped_category = [];
		# Loop $data
		foreach($list_data as $row) {
			# Make the size the key value
			$grouped_category[$row['category_name']][] = $row;
		}
	?>
		
	<table class="table table-bordered" id="tableKategori">
		<thead>
			<tr>
				<th>Kategori</th>
				<th>Kesulitan</th>
				<th>Total Data Kesulitan</th>
				<th>Count Showing Soal</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$count=1;
		foreach($grouped_category as $block => $rows)
		{
			$rowspan    =   false;
			# This indicates an easy way to note that you need a new header row
			$start      =   true;
			# This will be set on each new thickness, but you want to reset it on 
			# each size group as well.
			if(isset($thickness))
				unset($thickness);
			# Loop each rows now
			foreach($rows as $row):
				if(!empty($start)) {
					# Assign rowspan
					$rowspan    =   count($rows);
					# This is the first row, so make sure the start is set false
					# for subsequent rows
					$start      =   false;
				}
				# Create the rowspan here for thickness 
				$thickrowcount  =   
				$new            =   false;
				# If not set, set it (indicates first use of thickness)
				if(!isset($thickness)) {
					$thickness  =   $row['thickness'];
					$new        =   true;
				}
				# If it's already set and doesn't match, consider it's new
				if(($row['thickness'] != $thickness)) {
					$thickness  =   $row['thickness'];
					$new        =   true;
				}
				# Iterate the rows in this group and determine how many are this thickness.
				if($new)
					$thickrowcount  =  array_sum(array_map(function($v) use ($thickness){ return ($v['thickness'] == $thickness)? 1 : 0; },$rows));

	?>
	<tr>
		<?php if(!empty($rowspan)): ?>
		<td rowspan="<?php echo $rowspan;$rowspan = false; ?>"><?=title($row['category_name']) ?></td>
		<?php endif; ?>
		<td><?=$row['difficulty_name'] ?></td>
		<td><?=$row['difficulty_total'] ?></td>
		<td>
			<input type="number" class="form-control" data-id="<?=$row['difficulty_id']?>#<?=$row['category_id']?>" data-link="<?=$row['link']?>" min="0" max="<?=$row['difficulty_total']?>" value="<?=$row['count']?>"/>
		</td>
	</tr>
	<?php
		$count++;
		endforeach;
	}
	}
	?>
		<tr>
			<td colspan="3" class="text-right"><b>Total</b></td>
			<td><span id="jumlahShowingSoal"></span></td>
		</tr>
		<tr>
			<td colspan="3" class="text-right"><b>Total Paket Soal</b></td>
			<td><span><?=$total_paket_soal;?></span></td>
		</tr>
		</tbody>
	</table>
</div>
<div class="row">
	<div class="col">
		
	</div>
</div>
<div class="d-flex my-2 align-items-center">
	<button class="btn btn-primary m-1" onclick="generateSoal()">Add Generate</button>
	<button class="btn btn-primary m-1" onclick="updateAllGenerate()">Update All Generate</button>
	<button class="btn btn-primary m-1" onclick="save_generate()">Save</button>
</div>
<div id="Message"></div>

<!-- Modal -->
<div class="modal fade" id="pilihSoalModal" tabindex="-1" role="dialog" aria-labelledby="pilihSoalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pilihSoalModalLabel">Pilih Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="overflow-x: scroll">
        <table id="tablePilihSoal" class="table-responsive-md" width="100%">
		</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-info-message" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content p-2">
		<div class="modal-header">
        	<h5 class="modal-title" id="messageModalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
    	</div>
		<div class="modal-body">

		</div>
    </div>
  </div>
</div>

<script src="<?=base_url()?>assets/js/jquery-3.2.1.min.js"></script>
<script>

	var setMessage = function(status,textHTML) {
		switch(status){
			case 'error':
				$('.modal-info-message .modal-content').addClass('text-light bg-danger');
				$('.modal-info-message .modal-content .modal-title').text("Error");
				break;
			case 'warning':
				$('.modal-info-message .modal-content').addClass('text-light bg-warning');
				$('.modal-info-message .modal-content .modal-title').text("Warning");
				break;
			default:
				$('.modal-info-message .modal-content').addClass('text-light bg-success');
				$('.modal-info-message .modal-content .modal-title').text("Success");
				break;
		}
		$('.modal-info-message .modal-content .modal-body').html(`${textHTML}`);
		$('.modal-info-message').modal('show');
	}

	var generateSoal = function(){
		let datas = document.querySelectorAll('#tableKategori input')
		let result = []
		let total = 0
		for( let i of datas){
			let data = i.getAttribute('data-link').split('#')
			if(Array.isArray(data)){
				
				total += i.value
				if(data.length > 3){
					result.push([data[0],data[1],data[2], i.value, data[3]])
				} else {
					result.push([data[0],data[1],data[2], i.value])
				}
			}
		}


		$.ajax({
			beforeSend: function() {
				// $('#button_loader').parent().show()
			},
			data: {"options":result},
			dataType: 'json',
			error: function(jqXHR,textStatus,errorThrown) {
				// $('#button_loader').parent().hide()
				// show_retry_button()
				let htmlMesssage = `
					Gagal generate soal
				`;
				setMessage('error', htmlMesssage);
			},
			success: function(response) {
				let htmlMesssage = `
					Berhasil generate Soal
				`;

				setMessage('success', htmlMesssage);
				location.reload()
			},
			type: 'POST',
			url: '<?php echo $get_modal_soal;?>'
		})
	}

	function getTotal(){
		let total = 0;
		$('#tableKategori input').each(function(index){
			total += parseInt(this.value);
			$('#jumlahShowingSoal').text(total);
		})
	}

	getTotal();


	$('#tableKategori input').change(function(){
		getTotal();
	});

	var save_generate = function(){
		let datas = document.querySelectorAll('#tableKategori input');
		let config = {};
		for( let i of datas){
			let data = i.getAttribute('data-id').split('#')
			config = Object.assign({ 
				[`${data[0]}_${data[1]}`]: +i.value
			}, config);
		}

		let result = {
			jenis_soal: '<?=$header?>',
			config,
		}

		$.ajax({
			beforeSend: function() {
				// $('#button_loader').parent().show()
			},
			data: {result},
			dataType: 'json',
			error: function(jqXHR,textStatus,errorThrown) {
				// $('#button_loader').parent().hide()
				// show_retry_button()
				let htmlMesssage = `
					Gagal generate soal
				`;
				setMessage('error', htmlMesssage);
			},
			success: function(response) {
				let htmlMesssage = `
				Berhasil Menyimpan Data
				`;

				setMessage('success', htmlMesssage);
			},
			type: 'POST',
			url: '<?=$link_save_generate;?>'
		})
	}

	var updateAllGenerate = function(){
		let datas = document.querySelectorAll('#tableKategori input')
		let result = []
		let total = 0
		for( let i of datas){
			let data = i.getAttribute('data-link').split('#')
			if(Array.isArray(data)){
				
				total += i.value
				if(data.length > 3){
					result.push([data[0],data[1],data[2], i.value, data[3]])
				} else {
					result.push([data[0],data[1],data[2], i.value])
				}
			}
		}


		$.ajax({
			beforeSend: function() {
				// $('#button_loader').parent().show()
			},
			data: {
				"options":result,
				"quiz_code": '<?=$header;?>'
			},
			dataType: 'json',
			error: function(jqXHR,textStatus,errorThrown) {
				// $('#button_loader').parent().hide()
				// show_retry_button()
				let htmlMesssage = `
					Gagal generate soal
				`;
				setMessage('error', htmlMesssage);
			},
			success: function(response) {
				let htmlMesssage = `
					Berhasil generate Soal
				`;

				setMessage('success', htmlMesssage);
			},
			type: 'POST',
			url: '<?=$ajax_update_all_generate;?>'
		});
	}
</script>
