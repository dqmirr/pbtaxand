

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>

    <link rel="stylesheet" href="<?=base_url()?>assets/Select2/css/select2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/select2.custom.css">
    <?=$this->load->view('Admin/assets_js');?>
    <title>
        Formasi - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi', $nav)?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Form Formasi</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=$url['action']['back']?>" class="btn btn-outline-danger float-right mt-3">Kembali</a>
            </div>
        </div>

        <form method="post" action="<?=$url['action']['form']?>">
            <?php
            if($this->uri->segment(3) == 'edit') {
                $this->load->view('Admin/formasi_edit');
            } else {
                $this->load->view('Admin/formasi_add');
            }
            ?>
        </form>
    </div>


    <script src="<?=base_url()?>assets/Select2/js/select2.full.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.select2').map(function(i,v){
            var that = $(this);
            $(that).val("");
            var holder = $(that).data("placeholder");
            var value = $(that).data("value");
            $(that).select2({
                placeholder: holder,
                allowClear: true,
                theme: "classic"
            });
            $(that).val(value).trigger("change");
        });
    });
    </script>
</body>
</html>
