

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
                <h4 class="mt-3 mb-3">List Psychogram - <?=$data['label']?></h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=$url['base'].'/psycogram'?>"
                    class="btn btn-outline-danger float-right mt-3">Kembali</a>
                <a class="btn btn-outline-primary float-right mt-3 mr-3"
                    href="<?=$data['download']?>">Download PDF</a>
            </div>
        </div>

        <table class="table table-striped table-bordered" id="dt_table" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Peserta</th>
                    <th>Divisi</th>
                    <th>Level</th>
                    <th>Tgl Lahir</th>
                    <th>PDF</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['users'] as $key => $val) { ?>

                <tr>
                    <td><?=($key+1)?></td>
                    <td><?=$val['username']?></td>
                    <td><?=$val['fullname']?></td>
                    <td><?=$val['jabatan']?></td>
                    <td><?=$val['tingkatan']?></td>
                    <td><?=$val['tgl_lahir']?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-outline-primary" href="<?=$data['aksi'].$val['username']?>">
                                <span class="oi oi-zoom-in"></span>
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
        dt_table = $('#dt_table').DataTable();
    });
    </script>
</body>
</html>
