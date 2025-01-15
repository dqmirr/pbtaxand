

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
        Formasi - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi', $nav)?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Formasi</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a class="btn btn-outline-primary float-right mt-3"
                    href="<?=$url['action']['add']?>">Tambah</a>
            </div>
        </div>

        <table class="table table-striped table-bordered" id="table_formasi" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Label</th>
                    <th>Sesi</th>
                    <th>Divisi</th>
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data as $key => $val) { ?>
                <tr>
                    <td><?=($key+1)?></td>
                    <td><?=$val['code_formasi']?></td>
                    <td><?=$val['label_formasi']?></td>
                    <td><?=$val['sesi']?></td>
                    <td><?=$val['divisi']?></td>
                    <td><?=$val['level']?></td>
                    <td>
                        <div class="btn-group">
                            <!-- <a class="btn btn-sm btn-outline-primary" href="<?=$url['action']['view'].$val['id']?>">
                                <span class="oi oi-zoom-in"></span>
                            </a> -->
                            <a class="btn btn-sm btn-outline-primary" href="<?=$url['action']['edit'].$val['code_formasi']?>">
                                <span class="oi oi-pencil"></span>
                            </a>
                            <a class="btn btn-sm btn-outline-danger" href="<?=$url['action']['delete'].$val['code_formasi']?>" id="delete">
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
        tb_formasi = $('#table_formasi').DataTable();
        $('a#delete').on('click', function() {
            var text = "Apakah Anda Yakin?";
            if(confirm(text) == true) {
                return true;
            } else {
                return false;
            }
        });

    });
    </script>

</body>
</html>
