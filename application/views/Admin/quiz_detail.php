


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap_plus.css">

    <?=$this->load->view('Admin/assets_js');?>
    <script src="<?=base_url()?>assets/jquery_validate/jquery.validate.min.js"></script>

    <title>
        Quiz - <?=$this->config->item('app_name');?>
    </title>
</head>
<style>

</style>
<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Detail</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=base_url($admin_url)?>/quiz" class="btn btn-outline-danger float-right mt-3">Kembali</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <b>Quiz</b>
            </div>
            <div class="card-body row">
                <div class="col">
                
                    <div class="mb-2 row">
                        <label class="col-sm-3 col-form-label">
                            Code
                        </label>
                        <label class="col-sm-7 col-form-label">
                            : <?=$form['quiz']['data']['code']?>
                        </label>
                    </div>

                    <div class="mb-2 row">
                        <label class="col-sm-3 col-form-label">
                            Library Code
                        </label>
                        <label class="col-sm-7 col-form-label">
                            : <?=$form['quiz']['data']['library_code']?>
                        </label>
                    </div>

                    <div class="mb-2 row">
                        <label class="col-sm-3 col-form-label">
                            Sub Library Code
                        </label>
                        <label class="col-sm-7 col-form-label">
                            : <?=$form['quiz']['data']['sub_library_code']?>
                        </label>
                    </div>
                </div>

                <div class="col">
                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">
                            Label
                        </label>
                        <label class="col-sm-7 col-form-label">
                            : <?=$form['quiz']['data']['label']?>
                        </label>
                    </div>

                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">
                            Description
                        </label>
                        <label class="col-sm-7 col-form-label">
                            : <?=$form['quiz']['data']['description']?>
                        </label>
                    </div>

                    <div class="mb-2 row">
                        <label class="col-sm-2 col-form-label">
                            Seconds
                        </label>
                        <label class="col-sm-2 col-form-label">
                            : <?=$form['quiz']['data']['seconds']?>
                        </label>

                        <div class="col-sm-3 text-right mt-2">
                            <label class="form-check-label mr-3" for="active">Active</label>
                            <div class="form-check form-switch float-right">
                                <input class="form-check-input" type="checkbox" id="active" <?=checked_html($form['quiz']['data']['active'])?> disabled>
                            </div>
                        </div>

                        <div class="col-sm-3 text-right mt-2">
                            <label class="form-check-label mr-3" for="restart">Allow Restart</label>
                            <div class="form-check form-switch float-right">
                                <input class="form-check-input" type="checkbox" id="restart"
                                <?=checked_html($form['quiz']['data']['allow_restart'])?> disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php
        $jenis_soal = $form['quiz']['data']['library_code'];
        if($jenis_soal == 'multiplechoice') {
            $this->load->view('Admin/quiz_multiple');
        } 
        ?>    
    </div>

    
</body>
</html>
