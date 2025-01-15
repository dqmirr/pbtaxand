


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

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Form Quiz</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=base_url($admin_url)?>/quiz" class="btn btn-outline-danger float-right mt-3">Kembali</a>
            </div>
        </div>

        <form method="post" action="<?=$action_form?>">
            <?php 
            $this->load->view('Admin/quiz_add'); 
            if($this->uri->segment(3) == 'edit') {
                ?>

                <div class="col-12 mt-3 mb-3" style="text-align:center">
                    <button type="submit" class="btn btn-primary col-4">
                        Simpan
                    </button>
                </div>

                <?php
            }
            ?>

        </form>
    </div>

    <div class="modal fade" id="pilihanModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header pb-2">
                    <h5 class="modal-title">Edit Pilihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <form id="form_pilihan">
                        <input type="hidden" name="id" value="">
                        <table class="table table-bordered mb-0" id="table_pilihan">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Pilihan</th>
                                    <th style="border-right: 0">Label</th>
                                    <th width="50" style="border-left: 0"></th>
                                </tr>
                            </thead>
                            <tbody id="tb_pilihan"></tbody>
                            <tr>
                                <td colspan="3" style="border-right: 0"></td>
                                <td style="border-left: 0">
                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                        id="plus" onclick="admQuiz.addRowPilihan()">
                                        <span class="oi oi-plus"></span>
                                    </button>
                                </td>
                            </tr>
                        </table>

                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary btn-submit" onclick="admQuiz.submitMultiple()">Simpan</button>
                </div>
            </div>
        </div>

        
    </div>


	<script type="text/javascript" src="<?=base_url('assets/js/jquery-3.2.1.min.js')?>"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/js/admin/quiz_form.js"></script>
    <script>
    const admQuiz = new AdminQuiz({
        base: '<?=base_url($admin_url)?>',
    });

	$(document).ready(()=>{
		$('select[name="lib_code"]').change(()=>{
			const library = $('select[name="lib_code"]').val()

			if(library != '<?=$library_group_name?>') {
				$('select[name="sub_lib_code"]').attr('disabled', 'true')
			}

			if(library == '<?=$library_group_name?>') {
				$('input[name="seconds"]').attr('disabled', 'true')
			}
		})
	})
    </script>
</body>
</html>
