

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?php $this->load->view('Admin/stylesheet', TRUE);?>
    <link rel="stylesheet" href="<?=base_url()?>assets/css/datatable_custom.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dtables/datatables.min.css">
    
    <?php $this->load->view('Admin/assets_js');?>
    <script src="<?=base_url()?>assets/dtables/datatables.min.js"></script>

    <title>
        Hexaco - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Psychogram Hexaco - <?=ucfirst($data['label'])?></h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=$url['base']?>/psycogram" class="btn btn-outline-danger float-right mt-3">Kembali</a>
                <?php if(count($data['users']) > 0) { ?>
                <a href="<?=$button['hexaco']['download'].$data['code']?>" class="btn btn-outline-primary float-right mt-3 mr-3">Download PDF</a>
                <?php } ?>
            </div>
        </div>

        <?php
        if(count($data['users']) > 0) {
            echo '<div class="row mb-4">';
            foreach($data['users'] as $key => $val) {
                ?>
                <div class="col-4 p-0">
                    <div class="card ml-3 mr-3">
                        <div class="card-header cl-theme">
                            <b><a href="<?=$button['hexaco']['download'].$data['code'].'?users_id='.$val['id']?>" class="btn btn-outline-primary btn-sm"><?=$val['fullname']?></a></b>
                            <a href="#"
                                class="btn btn-outline-primary btn-sm float-right"
                                data-toggle="modal"
                                data-target="#detailModal"
                                data-id="<?=$val['id']?>"
                                data-user="<?=$val['fullname']?>">Detail</a>
                        </div>
                        <div class="card-body row">
                            <div class="col-12">
                                <center>
                                    <canvas id="radar_<?=$val['id']?>"></canvas>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                if(($key+1) % 3 == 0) {
                    echo '</div>';
                    echo '<div class="row mb-4">';
                }
            }
        } else {
            echo '<div class="col-12 text-center"><span>Tidak ada data</span></div>';
        } ?>

        
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 1000px">
            <div class="modal-content">
                <div class="modal-header pb-2">
                    <h5 class="modal-title">Detail Hexaco</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0 pt-2 pb-2">
                    <div class="row col-12 mt-2 mb-4 pr-0">
                        <div class="col-6 pr-0">
                            <span class="ml-5">
                                Honesty-Humility <badge id="nilai-he"></badge>
                            </span>
                            <canvas id="bar-he" height="75"></canvas>
                        </div>
                        <div class="col-6 pr-0">
                            <span class="ml-5">
                                Agreeableness <badge id="nilai-ag"></badge>
                            </span>
                            <canvas id="bar-ag" height="75"></canvas>
                        </div>
                    </div>

                    <div class="row col-12 mb-4 pr-0">
                        <div class="col-6 pr-0">
                            <span class="ml-5">
                                Emotionality <badge id="nilai-em"></badge>
                            </span>
                            <canvas id="bar-em" height="75"></canvas>
                        </div>
                        <div class="col-6 pr-0">
                            <span class="ml-5">
                                Conscientiousnesss <badge id="nilai-co"></badge>
                            </span>
                            <canvas id="bar-co" height="75"></canvas>
                        </div>
                    </div>

                    <div class="row col-12 pr-0">
                        <div class="col-6 pr-0">
                            <span class="ml-5">
                                Extraversion <badge id="nilai-ex"></badge>
                            </span>
                            <canvas id="bar-ex" height="75"></canvas>
                        </div>
                        <div class="col-6 pr-0">
                            <span class="ml-5">
                                Openness to Experience <badge id="nilai-op"></badge>
                            </span>
                            <canvas id="bar-op" height="75"></canvas>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=base_url()?>assets/js/admin/hexaco.js"></script>
    <script>
    $(document).ready(function() {
        dt_table = $('#dt_table').DataTable();
    });
    const hex = new hexaco({
        base: '<?=$url['base']?>',
        code: '<?=$data['code']?>',
    });
    </script>
</body>
</html>
