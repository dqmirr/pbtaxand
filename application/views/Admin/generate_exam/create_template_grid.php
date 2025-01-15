<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/datatable_custom.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dtables/datatables.min.css">

    <?=$this->load->view('Admin/assets_js');?>
    <script src="<?=base_url()?>assets/dtables/datatables.min.js"></script>
    <title>
        Rule - <?=$this->config->item('app_name');?>
    </title>
</head>
<body>

<?=$this->load->view('Admin/navigasi', $nav)?>
<div class="container-fluid">
	<div class="container-fluid mb-5">
		<div class="row">
			<div class="col"><h4>Filter By:</h4></div>
		</div>
		<div class="row">
			<div class="col-3">
				<label for="filterLibrary">Library</label>
				<select name="filterLibrary" id="filterLibrary" class="form-control">
					<option value="">Select Library</option>
					<?php foreach($list_library["data"] as $data): ?>
						<option value="<?= $data["code"]; ?>" <?= $data["selected"] ? 'selected' : ''; ?> ><?= $data["code"]; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
	<h2>List Template Rule</h2>
	<table class="table table-striped table-bordered" id="table_quiz">
		<thead>
			<tr>
				<th>#</th>
				<th>Code</th>
				<th>Label</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				foreach($list_quiz["data"] as $key => $quiz):
			?>
			<tr>
				<td><?= $key+1; ?></td>
				<td><?= $quiz["code"]; ?></td>
				<td><?= $quiz["label"]; ?></td>
				<td>
					<?php if(in_array($quiz['library_code'], $available_library)): ?>
						<button class="btn btn-primary" onClick="selectQuiz('<?=$quiz['code'] ?>');">Select</div>
					<?php else: ?>
						<button class="btn btn-primary" disabled>Select</div>
					<?php endif; ?>
				</td>
			</tr>
			<?php
				endforeach;
			?>
		</tbody>
	</table>

	<div id="createTemplateRule" style="display:none">
		<h2>Create template rule</h2>
		<div class="form-group row">
			<label for="jenisSoal" class="col-2">Library</label>
			<div class="col-6">
				<input readonly type="text" class="form-control" id="jenisSoal" value="Multiplechoice">
			</div>
		</div>
		<div class="form-group row">
			<label for="jenisSoal" class="col-2">Jenis Soal</label>
			<div class="col-6">
				<input readonly type="text" class="form-control" id="jenisSoal" value="English University">
			</div>
		</div>
		<table class="table table-bordered" id="tableKategori">
		<thead>
			<tr>
				<th>Rule</th>
				<th>Count</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		</table>
	</div>
</div>

<script>

	class GenerateExam {
		selected_quiz;
		show_create_html;
		dt_kategori;

		rule_type:[
			'difficulty',
			'category',
		]
		rule:{},

		constructor(){
			// $('#createTemplateRule').hide()
			this.urlCreateTemplateRule = '<?= $url_create_template_rule ?>';
		}

		loadTemplateRule(code){
			$.ajax({
				beforeSend: function() {
					$('#createTemplateRule').hide();
				},
				data: {'code': code },
				dataType: 'json',
				error: function(jqXHR,textStatus,errorThrown) {
					$('#createTemplateRule').hide();
				},
				success: function(response) {
					$('#createTemplateRule').show();
					if(response && response.data && response.data.list){

						let dataSet = [];
						let column = [];

						if(response['data']['list'].length > 0){
							let colSpanCategory = 0;
							let listRule = response['data']['list'];
							let row = listRule.map(item=>{
								return `
									<tr>
										<td>
											Kategori : ${item.category_name} <br/>
											kesulitan :  ${item.difficulty_name}
										</td>
										<td></td>
									</tr>
								`;
							});

							$('#tableKategori tbody').html(row);
						}
						// this.dt_kategori = $('#tableKategori').DataTable()
					}
					
				},
				type: 'GET',
				url: this.urlCreateTemplateRule
			})
		}
	}

	var generateExam = new GenerateExam();

	function selectQuiz(code){
		generateExam.loadTemplateRule(code);
	}

	$(document).ready(function() {
        var tb_quiz = $('#table_quiz').DataTable({
			lengthMenu: [5,10,50,100],
			pageLength: 5,
		});

		function filterData () {
			let library = $('#filterLibrary').val();
			let search = new URLSearchParams();
			if(library){
				search.append('library',library);
			}

		    window.location.replace(`?${search}`);
		}
		$('#filterLibrary').on('change', function () {
	        filterData();
	    });


    });
</script>
</body>
</html>
