


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>
    
    <?=$this->load->view('Admin/assets_js');?>

    <title>
        Sesi - <?=$nav['app_name']?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi', $nav)?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Edit Sesi</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=$url['action']['back']?>" class="btn btn-outline-danger float-right mt-3">Kembali</a>
            </div>
        </div>

        <form method="post" id="sesi_form" action="<?=$url['action']['form']?>">
        <?php $dt_sesi = $data['data'][0];?>
            <input type="hidden" name="id" value="<?=$dt_sesi['id']?>">
            <input type="hidden" name="code_ori" value="<?=$dt_sesi['code']?>">
            <div class="card mb-2 pb-3">
                <div class="card-header">
                    <b>Sesi</b>
                </div>
                <div class="card-body row">
                    <div class="col">
                        <div class="mb-2 row">
                            <label for="code"
                                class="col-sm-3 col-form-label">
                                Code
                            </label>
                            <div class="col-sm-7">
                                <input type="text"
                                    class="form-control"
                                    name="code"
                                    id="code"
                                    value="<?=$dt_sesi['code']?>">
                                <?=form_error('code');?>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="label"
                                class="col-sm-3 col-form-label">
                                Label
                            </label>
                            <div class="col-sm-7">
                                <input type="text"
                                    class="form-control"
                                    name="label"
                                    id="label"
                                    value="<?=$dt_sesi['label']?>">
                                <?=form_error('label');?>
                            </div>
                        </div>

                        <div class="mb-2 row input-daterange" id="datepicker">
                            <label for="time_from"
                                class="col-sm-3 col-form-label">
                                Time from
                            </label>
                            <?php $min = date('Y-m-d')?>
                            <div class="col-sm-7">
                                <input type="datetime-local"
                                    class="form-control"
                                    name="time_from"
                                    value="<?=$dt_sesi['time_from']?>">
                                <?=form_error('time_from');?>
                            </div>
                        </div>
						<div class="mb-2 row">
							<label for="time_to" class="col-sm-3 col-form-label">
                                Time To
							</label>
                            <div class="col-sm-7">
                                <input type="datetime-local"
                                    class="form-control"
                                    name="time_to"
                                    value="<?=$dt_sesi['time_to']?>">
                                <?=form_error('time_to');?>
                            </div>
						</div>
                    </div>

                    <div class="col">
                        <div class="mb-2 row">
                            <label for="part"
                                class="col-sm-2 col-form-label">
                                Part
                            </label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control"
                                    name="part"
                                    id="part"
                                    value="<?=$dt_sesi['part']?>">
                                <?=form_error('part');?>
                            </div>
                        </div>

                        <div class="mb-2 row">
                            <label for="greeting"
                                class="col-sm-2 col-form-label">
                                Greeting
                            </label>
                            <div class="col-sm-8">
                                <textarea name="greeting" 
                                    class="form-control" 
                                    id="greeting"
                                    rows="3"><?=$dt_sesi['greeting']?></textarea>
                                <?=form_error('greeting');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3 mb-3" style="text-align:center">
                <button type="submit" class="btn btn-primary col-3">
                    Simpan
                </button>
            </div>
        </form>
    </div>


    
    <script src="<?=base_url()?>assets/js/admin/sesi_form.js"></script>
    <script src="<?=base_url()?>assets/jquery_validate/jquery.validate.min.js"></script>
    <script src="<?=base_url()?>assets/jquery_validate/localization/messages_id.min.js"></script>
    <script>
    const admSesi = new AdminSesi({
        base: '<?=$url['base']?>',
    });
    </script>
</body>
</html>
