

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
        DISC - <?=$this->config->item('app_name');?>
    </title>
</head>

<style>
tr.child-detail td tbody {
}
#dt_table tr.child-detail td tr#head th {
    width: 13.1%;
    /* max-width: 100% !important; */
    /* background: blue; */
}
table.dataTable td {
    box-sizing: unset !important;
}
</style>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Psychogram DISC - <?=ucfirst($data['label'])?></h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a href="<?=$url['base']?>/psycogram" class="btn btn-outline-danger float-right mt-3">Kembali</a>
                <?php if(count($data['users']) > 0) { ?>
                <a href="<?=$button['disc']['download'].$data['code']?>" class="btn btn-outline-primary float-right mt-3 mr-3">Download PDF</a>
                <?php } ?>
            </div>
        </div>


        <table class="table table-striped table-bordered" id="dt_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Fullname</th>
                    <th>Formasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['users'] as $key => $val) { ?>
                <tr>
                    <td><?=($key+1)?></td>
                    <td><?=$val['username']?></td>
                    <td><?=$val['fullname']?></td>
                    <td align="center"><?=$val['formasi_label']?></td>
                    <td><?=$val['status']?></td>
                    <td class="dt-control shown-<?=$val['id']?>" data-id="<?=$val['id']?>"></td>
                </tr>

                <?php } ?>
            </tbody>
        </table>

        <?php foreach($data['users'] as $key => $val) { ?>
			<?php
				$nomor = 1;
				$most_grand_total = intval($val['disc']['disc_result']["D"]["most_total"]) +
				intval($val['disc']['disc_result']["I"]["most_total"]) +
				intval($val['disc']['disc_result']["S"]["most_total"]) +
				intval($val['disc']['disc_result']["C"]["most_total"]) +
				intval($val['disc']['disc_result']["B"]["most_total"]) ;
				$least_grand_total = intval($val['disc']['disc_result']["D"]["least_total"]) +
				intval($val['disc']['disc_result']["I"]["least_total"]) +
				intval($val['disc']['disc_result']["S"]["least_total"]) +
				intval($val['disc']['disc_result']["C"]["least_total"]) +
				intval($val['disc']['disc_result']["B"]["least_total"]) ;
				$is_most_done = $most_grand_total == 24;
				$is_least_done = $least_grand_total == 24;
				$is_all_done = $is_most_done && $is_least_done;
				$most_disc = array();
				$least_disc = array();
				$change_disc = array();
		?>
        <table class="table table-striped table-bordered" id="dt_detail_<?=$val['id']?>" style="display: none">
                <tr id="head">
                    <th>Keterangan</th>
                    <th>D</th>
                    <th>I</th>
                    <th>S</th>
                    <th>C</th>
                    <th>*</th>
                    <th>Total</th>
                    <th>DISC Profile</th>
                    <th rowspan="4">
						<?php if($is_all_done): ?>
                        <a href="#"
                            class="btn btn-outline-primary btn-sm float-right"
                            data-toggle="modal"
                            data-target="#detailModal"
                            data-id="<?=$val['id']?>"
                            data-user="<?=$val['fullname']?>">grafik
						</a>
						<?php endif;?>
                    </th>
                </tr>
                <tr>
                    <td>Most</td>
                    <td><?= $val['disc']['disc_result']["D"]["most_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["I"]["most_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["S"]["most_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["C"]["most_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["B"]["most_total"] ?></td>
                    <td><?= $is_most_done ? $most_grand_total : ''; ?></td>
                    <td><?= $is_most_done ? $val['disc']['m_disc']["profile"] : ""; ?></td>
                </tr>
                <tr>
                    <td>Least</td>
                    <td><?= $val['disc']['disc_result']["D"]["least_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["I"]["least_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["S"]["least_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["C"]["least_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["B"]["least_total"] ?></td>
                    <td><?= $is_least_done ? $least_grand_total : '' ?></td>
                    <td><?= $is_least_done ? $val['disc']['l_disc']["profile"] : ""; ?></td>
                </tr>
                <tr>
                    <td>Change</td>
                    <td><?= $val['disc']['disc_result']["D"]["change_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["I"]["change_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["S"]["change_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["C"]["change_total"] ?></td>
                    <td><?= $val['disc']['disc_result']["B"]["change_total"] ?></td>
                    <td></td>
                    <td><?= $is_all_done ? $val['disc']['c_disc']["profile"] : ""; ?></td>
                </tr>
        </table>
        <?php } ?>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 1000px">
            <div class="modal-content">
                <div class="modal-header pb-2">
                    <h5 class="modal-title">Detail DISC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-0 pt-2 pb-2 pl-2 pr-4">
                    <div class="row">
                        <div id="chart-container-most" class="col-4">
                            
                        </div>

                        <div id="chart-container-least" class="col-4">
                            
                        </div>

                        <div id="chart-container-change" class="col-4">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=base_url()?>assets/js/admin/disc.js"></script>
    
    <script>
    const disc = new discJs({
        base: '<?=$url['base']?>',
        code: '<?=$data['code']?>',
        data: <?php echo json_encode($data['users'])?>
    });

    function format(d) {
        return d;
    }

    $(document).ready(function() {
        dt_table = $('#dt_table').DataTable();

        var detailRows = [];
        $('#dt_table tbody').on('click', 'tr td.dt-control', function () {
            var tr = $(this).closest('tr');
            var id_user = $(this).data('id');
            var row = dt_table.row(tr);
            var idx = detailRows.indexOf(tr.attr('id'));
    
            if (row.child.isShown()) {
                tr.removeClass('details');
                row.child.hide();
    
                detailRows.splice(idx, 1);
            } else {
                tr.addClass('details');
                const node = document.getElementById("dt_detail_"+id_user).lastChild;
				// console.log(node);
                const clone = node.cloneNode(true);
                row.child(clone).show();
                row.child().addClass('child-detail');
                // var htm = '<table></table>';
                // htm.append(node);
                // row.child().html(clone);
    
                if (idx === -1) {
                    detailRows.push(tr.attr('id'));
                }
            }
        });
    });
    </script>
</body>
</html>
