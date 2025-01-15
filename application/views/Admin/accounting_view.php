
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?php $this->load->view('Admin/stylesheet');?>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/datatable_custom.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dtables/datatables.min.css">
    
    <?php $this->load->view('Admin/assets_js');?>
    <script src="<?=base_url()?>assets/dtables/datatables.min.js"></script>

    <title>
        Accounting - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
<?=$this->load->view('Admin/navigasi' ,$nav)?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm">
            <h4 class="mt-3 mb-3">Psycogram Accounting - <?=ucfirst($data['label'])?></h4>
        </div>
        <div class="col-sm"></div>
        <div class="col-sm">
            <a href="<?=$url['base']?>/psycogram" class="btn btn-outline-danger float-right mt-3">Kembali</a>
        </div>

        <table class="table table-striped table-bordered" id="dt_table" style="width:100%">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle">No</th>
                    <th rowspan="2" style="vertical-align: middle">Kemampuan Teknis</th>
                    <th colspan="5" style="text-align: center">Range Skor</th>
                </tr>
                <tr>
                    <th style="text-align: center">Elementary</th>
                    <th style="text-align: center">Pre Intermediate</th>
                    <th style="text-align: center">Intermediate</th>
                    <th style="text-align: center">Above Intermediate</th>
                    <th style="text-align: center">Advance</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td rowspan="2" style="text-align: center; vertical-align: middle">3</td>
                    <td rowspan="2" style="vertical-align: middle">
                        Tes Accounting Level Junior dan Senior (50 soal, tiap soal x 2 points)
                    </td>
                    <td style="text-align: center">2 sd < 36</td>
                    <td style="text-align: center">38</td>
                    <td style="text-align: center">40 sd 48</td>
                    <td style="text-align: center">50</td>
                    <td style="text-align: center">>52 sd 100</td>
                </tr>
                <tr>
                    <td align="center">(benar 18 soal kebawah)</td>
                    <td align="center">(benar 19 soal)</td>
                    <td align="center">(Benar 20 sd 24 soal )</td>
                    <td align="center">(Benar 25 soal)</td>
                    <td align="center">(Benar 26 soal keatas sd 50 soal)</td>
                </tr>
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
