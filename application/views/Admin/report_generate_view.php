<form class="row">
	<div class="form-group col-lg-4 col-sm-12">
		<label for="generate_by">Berdasarkan</label>
		<select class="form-control" id="generate_by">
			<option value="">-- Pilih Opsi --</option>
			<option value="sesi_code">Sesi Code</option>
			<option value="formasi_code">Formasi Code</option>
		</select>
	</div>
	<div class="form-group col-lg-6 col-sm-12">
		<label for="code">Code</label>
		<div id="code-container" class="border code-container table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th colspan="3">
							<input type="text" placeholder="Search&hellip;" class="form-control" id="search_code" />
						</th>
					</tr>
					<tr>
						<th><input type="checkbox" id="select_all" /></th>
						<th>Label</th>
						<th>Code</th>
					</tr>
				</thead>
				<tbody id="code"></tbody>
			</table>
		</div>
		<button id="expand_collapse" class="btn btn-block btn-outline-secondary mt-2" type="button" data-stat="collapse" data-text="Collapse">Expand</button>
	</div>
	<div class="col-lg-2 col-sm-12">
		<div style="height: 24px; margin-bottom: 8px;"></div>
		<button class="btn btn-primary btn-block" type="button" id="generate">Generate</button>
	</div>
</form>

<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Generated</th>
				<th>Berdasarkan</th>
				<th>Code</th>
				<th>Excel</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody id="report_queue_container">
		<?php if (count($arr_generated) == 0):?>
			<tr>
				<td colspan="6"><em>Belum Ada Data</em></td>
			</tr>
		<?php else:?>
		<?php endif;?>
		</tbody>
	</table>
</div>

<div style="display: none;" id="clone">
	<table>
		<tbody>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<a href="#" style="display: none;">download</a>
					<progress></progress>
					<div><em class="info"></em></div>
				</td>
				<td>
					<a href="javascript:void(0)" onclick="hapus(this)" data-id="" data-sha1="">Hapus</a>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<style>
td.remove {
	background-color: #FF0000;
	color: #FFF;
}

td.remove a {
	color: #FFF;
}

.code-container {
	height: 150px;
	overflow: auto;
}

.code-container.expand {
	height: 500px;
}

td > div > em.info {
	font-size: 0.9em;
}
</style>

<script>
var hapus;
var get_status;

$(function(){
	var use_websocket = false;
	
<?php if (isset($websocket_url)):?>
	var ws;

	const socketMessageListener = (e) => {
		try {
			obj = JSON.parse(e.data)
			sha1 = obj.sha1_codes
			step = obj.step
			num_step = obj.num_step
			
			target = $('[data-sha1='+sha1+']')
			
			target.find('td:eq(3) > div > em').html(obj.message)
			
			if (num_step > 0) {
				target.find('progress').attr('max', num_step * 10)
				
				target.find('progress').stop().animate({
					'value': step * 10
				}, 'slow')
				
				if (step == num_step) {
					target.find('progress').fadeOut(function(){
						target.find('td:eq(3) > a').fadeIn()
					})
					target.find('td:eq(3) > div').hide()
				}
			}
			else if (obj.message == 'Done') {
				target.find('progress').fadeOut(function(){
					target.find('td:eq(3) > a').fadeIn()
				})
				target.find('td:eq(3) > div').hide()
			}
		}
		catch(err) {
			// ...
		}
	};

	const socketOpenListener = (event) => {
		use_websocket = true;
	};

	const socketCloseListener = (event) => {
	  if (ws) {
		console.error('Disconnected.');
	  }
	  
	  ws = new WebSocket("<?php echo $websocket_url;?>");
	  ws.addEventListener('open', socketOpenListener);
	  ws.addEventListener('message', socketMessageListener);
	  ws.addEventListener('close', socketCloseListener);
	};
	
	socketCloseListener();
<?php endif;?>
	
	$('#select_all').on('change', function(){
		if ($(this).is(':checked')) {
			$('[name="code[]"]').prop('checked', true)
		}
		else {
			$('[name="code[]"]').prop('checked', false)
		}
	})
	
	$('#expand_collapse').on('click', function(){
		var stat = $(this).data('stat')
		var text = $(this).data('text')
		var currText = $(this).html()
		
		if (stat == 'collapse') {
			$('#code-container').addClass('expand')
			$(this).data('text', currText)
			$(this).data('stat', 'expand')
			$(this).html(text)
		}
		else {
			$('#code-container').removeClass('expand')
			$(this).data('text', currText)
			$(this).data('stat', 'collapse')
			$(this).html(text)
		}
	})
	
	var load_report = function(){
		$.ajax({
			dataType: 'JSON',
			error: function(){
				alert('An Error Occured')
			},
			success: function(data) {
				if (data.error) {
					alert(data.msg)
				}
				else {
					$('#report_queue_container').html('')
					
					$.each(data.data, function(k,v){
						var clone = $('#clone > table > tbody > tr').clone()
						
						clone.attr('id', 'row_'+v.id)
						clone.attr('data-sha1', v.sha1_codes)
						clone.find('td:eq(0)').html(v.created)
						clone.find('td:eq(1)').html(v.generate_by)
						clone.find('td:eq(2)').html(v.codes)
						clone.find('td:eq(3) > a').attr('href', data.path + v.sha1_codes + data.ext + '?id=' + v.id)						
						
						if (v.status == 'done') {
							clone.find('td:eq(3) > a').show()
							clone.find('td:eq(3) > progress').hide()
						}
						else {
							if (! use_websocket) {
								// aktifkan pencarian
								get_status(v.id)
							}
						}
						
						clone.find('td:eq(4) > a').data('id', v.id)
						clone.find('td:eq(4) > a').data('sha1', v.sha1_codes)
						
						$('#report_queue_container').append(clone)
					})
				}
			},
			type: 'GET',
			url: '<?php echo $load_report_url;?>'
		})
	}
	
	$('#generate_by').on('change', function(){
		var generate_by = $(this).val()
		
		if (generate_by == '') {
			alert('Harus dipilih salah satu')
			return false;
		}
		
		$.ajax({
			beforeSend: function(){
				$('#code').html('')
			},
			data: {generate_by: generate_by},
			dataType: 'JSON',
			error: function(){
				alert('An Error Occured')
			},
			success: function(data) {

				if (data.error) {
					alert(data.msg)
				}
				else {
					$.each(data.data, function(k,v){
						//var option = $('<option></option>').val(v.code).html(v.label + ' &nbsp;&nbsp;&nbsp;&nbsp; [CODE: '+v.code+']')
						var id = 'code_'+v.code
						var checkbox = $('<input>').attr('type', 'checkbox').attr('name','code[]').val(v.code).attr('id',id)
						var tr = $('<tr></tr>')
						var label_1 = $('<label></label>').attr('for',id).html(v.label)
						var label_2 = $('<label></label>').attr('for',id).html(v.code)
						var td_0 = $('<td></td>').html(checkbox)
						var td_1 = $('<td></td>').html(label_1)
						var td_2 = $('<td></td>').html(label_2)
						td_0.append(checkbox)
						tr.append(td_0)
						tr.append(td_1)
						tr.append(td_2)
						$('#code').append(tr)
					})
				}
			},
			type: 'POST',
			url: '<?php echo $get_code_url;?>'
		})
	})
	
	$('#generate').on('click', function(){
		var generate_by = $('#generate_by').val()
		var code = []
		
		$('[name="code[]"]:checked').each(function(k,v){
			code.push($(this).val())
		})
		
		if (generate_by == '') {
			alert('Berdasarkan opsi belum dipilih')
			return false;
		}
			
		if (code == '') {
			alert('Code belum dipilih');
			return false;
		}
		
		$.ajax({
			data: {generate_by: generate_by, 'code[]': code},
			dataType: 'JSON',
			error: function(){
				alert('An Error Occured')
			},
			success: function(data) {
				if (data.error) {
					alert(data.msg)
				}
				else {
					if (data.reload) {
						load_report()
					}
				}
			},
			type: 'POST',
			url: '<?php echo $generate_report_url;?>'
		})
	})
	
	hapus = function(obj) {
		var id = $(obj).data('id')
		var sha1_codes = $(obj).data('sha1')
		
		if (id > 0) {
			yes = confirm('Anda yakin akan menghapus row ini?')
			
			if (! yes)
				return false
			
			$.ajax({
				data: {id: id, sha1_codes: sha1_codes},
				dataType: 'JSON',
				error: function(){
					alert('An Error Occured')
				},
				success: function(data) {
					if (data.error) {
						alert(data.msg)
					}
					else {
						$(obj).parent().parent().find('td').addClass('remove')
						$(obj).parent().parent().fadeOut(function(){
							$(this).remove()
						})
					}
				},
				type: 'POST',
				url: '<?php echo $delete_queue_url;?>'
			})
		}
	}
	
	get_status = function(id) {
		$.ajax({
			data: {id: id},
			dataType: 'JSON',
			error: function(){
				alert('An Error Occured')
			},
			success: function(data) {
				if (data.error) {
					alert(data.msg)
				}
				else {
					var row_id = $('#row_'+id)
					
					if (data.num_step > 0) {
						row_id.find('progress').attr('max', 6 * 10)
						
						if (data.step <= data.num_step) {
							//row_id.find('progress').val(data.step * 10)
							row_id.find('progress').animate({
								'value': data.step * 10
							}, 'slow')
						}
					}
					
					if (data.details.excel == 1) {
						row_id.find('td:eq(3) > div > em').html('Writing to Excel&hellip;')
					}
					else if (data.details.excel == 2 && data.status != 'done') {
						row_id.find('td:eq(3) > div > em').html('Cleaning Up&hellip;')
					}
					else if (data.details.prepare == 1) {
						row_id.find('td:eq(3) > div > em').html('Preparing data&hellip;')
					}
					else if (data.details.prepare == 2) {
						found_quiz = 0
						
						$.each (data.details.quiz, function(k,v){
							if (v == 1) {
								found_quiz = 1
								row_id.find('td:eq(3) > div > em').html('Calculating '+ k +'&hellip;')
							}
						})
						
						if (found_quiz == 0 && data.details.excel == 0 && data.step < (data.num_step - 1))
							row_id.find('td:eq(3) > div > em').html('Preparing Quiz&hellip;')
						else if (data.step == (data.num_step - 1))
							row_id.find('td:eq(3) > div > em').html('Preparing Excel&hellip;')
					}
					
					if (data.status == 'done') {
						row_id.find('td:eq(3) > div > em').html('')
						
						row_id.find('td:eq(3) > progress').fadeOut(function(){
							row_id.find('td:eq(3) > a').fadeIn()
						})
					}
					else if (data.reload_in) {
						if (! use_websocket) {
							setTimeout(function(){
								get_status(id)
							}, data.reload_in)
						}
					}
					else if (data.remove) {
						row_id.find('td').addClass('remove')
						row_id.fadeOut(function(){
							$(this).remove()
						})
					}
				}
			},
			type: 'POST',
			url: '<?php echo $get_status_url;?>'
		})
	}
	
	$('#search_code').on('keyup', function(){
		var text = $(this).val()
		
		$('#code').find('tr').each(function(k,v){
			var label = $(v).find('td:eq(1)').text().toLowerCase()
			var code = $(v).find('td:eq(2)').text().toLowerCase()
			
			if (label.includes(text) || code.includes(text)) {
				$(this).show()
			}
			else {
				$(this).hide()
			}
		})
	})
	
	load_report()
})
</script>
