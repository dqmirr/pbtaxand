



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
        Quiz - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Quiz</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a class="btn btn-outline-primary float-right mt-3"
                    href="<?=$action['add']?>">Tambah</a>
            </div>
        </div>
        <table class="table table-striped table-bordered" id="table_quiz" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Label</th>
                    <th>Description</th>
                    <th>Library Code</th>
                    <th>Group Quiz Code</th>
                    <th>Active</th>
                    <th>Seconds</th>
                    <th>Is Show</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($table as $key => $val) { ?>
                <tr>
                    <td><?=($key+1)?></td>
                    <td><?=$val['code']?></td>
                    <td><?=$val['label']?></td>
                    <td><?=$val['description']?></td>
                    <td><?=$val['library_code']?></td>
                    <td><?=$val['group_quiz_code']?></td>
                    <td><?=$val['active']?></td>
                    <td><?=$val['seconds']?></td>
                    <td><?=$val['is_show']?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-outline-primary" href="<?=$action['view'].$val['id']?>">
                                <span class="oi oi-zoom-in"></span>
                            </a>
                            <a class="btn btn-sm btn-outline-primary" href="<?=$action['edit'].$val['id']?>">
                                <span class="oi oi-pencil"></span>
                            </a>
                            <a class="btn btn-sm btn-outline-danger" href="<?=$action['del'].$val['id']?>" onclick="return false">
                                <span class="oi oi-trash"></span>
                            </a>
                        </div>
                    </td>
                </tr>

                
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script>
    $(document).ready(function() {
        tb_quiz = $('#table_quiz').DataTable();
    });
    </script>
</body>
</html>
