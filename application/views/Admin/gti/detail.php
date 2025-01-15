

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
      Gti - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
				<div class="d-flex">
					<div class="mt-3 mb-3 mr-3">
						<a class="btn btn-primary" href="<?=$url['action']['back']?>">Back</a>
					</div>
					<div class="mt-3 mb-3">
						<h4 class="">Detail Report Gti</h4>
					</div>
				</div>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
        </div>
				<div class="row mb-2">
					<div class="col">
						<h2>Nama: <?=$data['name']; ?></h2>
					</div>
				</div>
				<?php 
					// array_view($data);
				?>
				<?php if (count($data['result'])>0):?>
					<div class="row mb-4">
					<?php foreach($data['result'] as $key => $val): ?>
						<?php if(is_array($val)): ?>
						<div class="col-4 p-0">
								<div class="card ml-3 mr-3 mb-3">
										<div class="card-header cl-theme">
												<b><?=$key?></b>
										</div>
										<div class="card-body row">
												<div class="col-12">
													<table class="table table-striped">
														<thead>
															<tr>
																<th>B</th>
																<th>S</th>
																<th>K</th>
																<th>DONE</th>
																<th>ADJ</th>
																<th>PERC</th>
																<th>GTQ</th>
															</tr>
														</thead>
														<tbody>
															<tr>
																<td><?= $val["B"] ?></td>
																<td><?= $val["S"] ?></td>
																<td><?= $val["K"] ?></td>
																<td><?= $val["DONE"] ?></td>
																<td><?= $val["ADJ"] ?></td>
																<td><?= $val["PERC"] ?></td>
																<td><?= $val["GTQ"] ?></td>
															</tr>
														</tbody>
													</table>
												</div>
										</div>
								</div>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>
					</div>
				<?php else: ?>
						<div class="col-12 text-center"><span>Tidak ada data</span></div>
				<?php endif; ?>
    </div>

		
		<?=$this->load->view('Admin/assets_js');?>
</body>
</html>
