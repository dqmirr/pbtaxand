

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
        Pyschogram - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

    <!-- <?=array_view($data);?> -->

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Report Psychogram test</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
        </div>

        <table class="table table-striped table-bordered" id="dt_table" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Sesi Tes</th>
                    <th>Jumlah Peserta</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $key => $val) { ?>

                <tr>
                    <td><?=($key+1)?></td>
                    <td><?=$val['label']?></td>
                    <td><?=$val['peserta']?></td>
                    <td>
                        <span class="badge <?=$val['badge']?>">
                            <?=$val['status']?>
                        </span>
                    </td>
                    <td>
                        <?php foreach($button as $key1 => $val1) { ?>
                            <a href="<?=$val1['view'].$val['code']?>"
                                class="btn btn-outline-primary btn-sm">
                                <?=ucfirst($val1['label'])?>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
    </div>
    <script>
    $(document).ready(function() {
        dt_table = $('#dt_table').DataTable();
    });
    </script>
</body>
</html>
