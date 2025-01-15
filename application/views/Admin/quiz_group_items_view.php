<h4 class="mt-3">Quiz Group Items</h4>
<form method="GET">
	<div class="row mt-3 mb-3">
		<div class="col-lg-2 from-group">
			<button type="button" class="btn btn-primary btn-block" id="add_new_button">Add Item&hellip;</button>
		</div>
		<div class="col-lg-3 from-group">
			<?php echo $dropdown;?>
		</div>
		<div class="col-lg-5 from-group">
			<input type="text" name="search" class="form-control" placeholder="Search text&hellip;" value="<?php echo $search_text;?>" />
		</div>
		<div class="col-lg-2 from-group">
			<button type="submit" class="btn btn-outline-primary btn-block">
				<span class="oi oi-magnifying-glass"></span> Search
			</button>
		</div>
	</div>
</form>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Group Quiz Code</th>
				<th>Quiz Code</th>
				<th>Order</th>
				<th class="text-center">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($arr_group_quiz as $row):?>
			<tr>
				<td><?php echo $row->group_quiz_code;?></td>
				<td><?php echo $row->quiz_code;?></td>
				<td><?php echo $row->ordering;?></td>
				<td class="text-center" data-group="<?php echo $row->group_quiz_code;?>" data-quiz="<?php echo $row->quiz_code;?>" data-order="<?php echo $row->ordering;?>">
					<button type="button" class="btn btn-sm btn-warning mr-3" data-action="edit">
						<i class="oi oi-pencil"></i> Edit
					</button>
					<button type="button" class="btn btn-sm btn-danger" data-action="delete">
						<i class="oi oi-trash"></i> Delete
					</button>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<label>Group Quiz Code</label>
			<?php echo $dropdown_add_group;?>
			</select>
		</div>
		<div class="form-group">
			<label>Quiz Code</label>
			<select class="form-control" id="add_quiz">
			<?php foreach ($arr_quiz as $row):?>
				<option value="<?php echo $row->code;?>"><?php echo $row->code;?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="form-group">
			<label>Order</label>
			<input type="number" id="add_order" value="" class="form-control" value="0" />
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="add_button">Add</button>
      </div>
    </div>
  </div>
</div>

<!-- UPDATE MODAL -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="update_target">
		<input type="hidden" id="update_group" value="" />
		<input type="hidden" id="update_quiz" value="" />
		<div class="form-group">
			<label>Group Quiz Code</label>
			<input type="text" readonly="readonly" value="" id="text_group" class="form-control" />
		</div>
		<div class="form-group">
			<label>Quiz Code</label>
			<select class="form-control" id="update_new_quiz">
			<?php foreach ($arr_quiz as $row):?>
				<option value="<?php echo $row->code;?>"><?php echo $row->code;?></option>
			<?php endforeach;?>
			</select>
		</div>
		<div class="form-group">
			<label>Order</label>
			<input type="number" id="update_order" value="" class="form-control" />
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update_button">Update</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
	var URL = '<?php echo $URL;?>';
	
	$('#add_button').on('click', function(){
		var group_quiz_code = $('#add_group').val();
		var quiz_code = $('#add_quiz').val();
		var order = $('#add_order').val();
		
		$.post(URL, {action: 'add', group_quiz_code: group_quiz_code, quiz_code: quiz_code, order: order}, function(data){
			if (data.error) {
				alert(data.msg)
			}
			else {
				window.location.href = URL
			}
		},'json')
	})
	
	$('#add_new_button').on('click', function(){
		// reset
		$('#add_order').val('0');
		$('#add_modal').modal('show')
	})
	
	$('#update_button').on('click', function() {
		var group_quiz_code = $('#update_group').val();
		var quiz_code = $('#update_quiz').val();
		var new_quiz_code = $('#update_new_quiz').val();
		var order = $('#update_order').val();
		var target = $('#update_target').data('object');
		
		$.post(URL, {action: 'update', group_quiz_code: group_quiz_code, quiz_code: quiz_code, new_quiz_code: new_quiz_code, order: order}, function(data){
			if (data.error) {
				alert(data.msg)
			}
			else {
				target.find('td:eq(0)').html(data.group_quiz_code)
				target.find('td:eq(1)').html(data.quiz_code)
				target.find('td:eq(2)').html(data.order)
				target.find('td:eq(3)').data('group', data.group_quiz_code)
				target.find('td:eq(3)').data('quiz', data.quiz_code)
				target.find('td:eq(3)').data('order', data.order)
				
				// hide modal
				$('#edit_modal').modal('hide');
			}
		}, 'json');
	})
	
	$("button[data-action=edit]").on('click', function(){
		var target = $(this).parent().parent();
		var group_quiz_code = $(this).parent().data('group');
		var quiz_code = $(this).parent().data('quiz');
		var order = $(this).parent().data('order');
		
		// reset
		$('#update_group, #text_group, #update_quiz, #update_new_quiz, #update_order').val('')
		
		$('#update_group').val(group_quiz_code);
		$('#text_group').val(group_quiz_code);
		$('#update_quiz, #update_new_quiz').val(quiz_code);
		$('#update_order').val(order);
		$('#update_target').data('object', target);
		
		// open modal
		$('#edit_modal').modal('show');
	})
	
	$("button[data-action=delete]").on('click', function(){
		var target = $(this).parent().parent()
		var group_quiz_code = $(this).parent().data('group')
		var quiz_code = $(this).parent().data('quiz')
		
		var yes = confirm('Anda yakin akan menghapus quiz "'+ quiz_code +'" dari group "'+group_quiz_code+'" ? Tekan OK jika yakin.');
		
		if (yes) {
			$.post(URL, {action: 'delete', group_quiz_code: group_quiz_code, quiz_code: quiz_code}, function(data){
				if (data.error) {
					alert(data.msg)
				}
				else {
					target.fadeOut(function(){
						$(this).remove();
					})
				}
			}, 'json');
		}
	})
})	
</script>
