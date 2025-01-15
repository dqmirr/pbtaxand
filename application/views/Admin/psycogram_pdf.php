
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>
    
    <?=$this->load->view('Admin/assets_js');?>


    <title>
        Pyschogram - <?=$this->config->item('app_name');?>
    </title>
</head>

<style>
@-webkit-keyframes spinner-border {
  to {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes spinner-border {
  to {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

.spinner-border {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    vertical-align: text-bottom;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    -webkit-animation: spinner-border .55s linear infinite;
    animation: spinner-border .55s linear infinite;
    
}
#rendering {
    position: absolute !important;
    top: 18px;
}
.spinner-border-sm {
  width: 1.5rem;
  height: 1.5rem;
  border-width: 0.2em;
}
.spinner-text {
    margin-left: 4px;
}
</style>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

    <?php
    if($this->uri->segment(3) == 'result') {
        $label = $data['label'];
        $back = $url['base'].'/psycogram/list/'.$data['code'];
    }

    if($this->uri->segment(3) == 'user') {
        $text = $data['users'][0];
        $label = $text['fullname'];
        $back = $url['base'].'/psycogram/list/'.$text['sesi_code'];
    }
    ?>
    
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Psychogram - <?=$label?></h4>
            </div>
            <div class="col-sm">
                <div id="rendering">
                    <div class="spinner-border spinner-border-sm text-warning" role="status">
                        <span class="sr-only">Rendering...</span>
                    </div>
                    <span class="spinner-text">Rendering...</span>
                </div>
            </div>
            <div class="col-sm">
                <a href="<?=$back?>" class="btn btn-outline-danger float-right mt-3">Kembali</a>
            </div>

            
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div id="pdf-preview" type="application/pdf"></div>
            </div>
        </div>
    </div>



    <script src="<?=base_url()?>assets/jsPDF/dist/jspdf.min.js"></script>
    <script src="<?=base_url()?>assets/PDFObject/pdfobject.min.js"></script>
    <script src="<?=base_url()?>assets/jsPDF-AutoTable/dist/jspdf.plugin.autotable.js"></script>
    <script src="<?=base_url()?>assets/js/admin/psycogram_pdf.js"></script>
    
    <script>
    const psyPDF = new psycoPdf({
        img: '<?=base_url()?>assets/images/logo.png',
        base: '<?=$url['base']?>',
        code: '<?=$data['code']?>',
        label: '<?=$data['label']?>',
        data: <?php echo json_encode($data['users'])?>
    });
    </script>
</body>
</html>
