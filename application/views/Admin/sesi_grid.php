


<?php
$data_sesi = $data['data'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>

    <?=$this->load->view('Admin/assets_js');?>
    <script src="<?=base_url()?>assets/tagify/tagify.js"></script>
    <link rel="stylesheet" href="<?=base_url()?>assets/tagify/tagify.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/tagify.css">
    <title>
        Sesi - <?=$nav['app_name']?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi', $nav)?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Sesi</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm">
                <a class="btn btn-outline-primary float-right mt-3"
                    href="<?=$url['action']['add']?>">Tambah</a>
            </div>
        </div>

		<div class="row mb-4">
        <?php
        if(count($data_sesi) > 0) {
            foreach($data_sesi as $key => $val) {
                $data_users = $val['users']['data'];
                $expaired = tgl_expaired($val['time_to']);
                $btn_exp = button_exp($val['time_to']);
                ?>
                <div class="col-3 p-0 my-2">
                    <div class="card ml-3 mr-3" style="<?=$expaired==1? "background-color: #FE5C5C50;": ""; ?>">
                        <div class="card-header cl-theme">
                            <b><?=$val['label']?></b>
                            <span class="float-right"><?=expaired_sesi($val['time_to'])?></span>
                        </div>
                        <div class="card-body row">
                            <div class="col-6">
                                <b><?=jumlah_hari($val['time_from'], $val['time_to'])?> Hari</b><br><br>
                            </div>

                            <div class="col-6 text-right">
                                <button type="button" id="btn_peserta" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#pesertaModal" data-code="<?=$val['code']?>" data-expaired="<?=$expaired?>"><?=$val['users']?> Peserta</button>
                            </div>

                            <div class="col-sm">
                                <?=hari_indo($val['time_from'])?> - <?=hari_indo($val['time_to'])?><br>
                                <?=jam($val['time_from'])?> - <?=jam($val['time_to'])?> WIB<br>
                                <span style="font-size:14px"><?=tgl_fromto($val['time_from'], $val['time_to'])?></span><br>
                                <?php if($expaired) { ?>
                                    <a href="<?=$url['action']['delete'].$val['id']?>"
                                        class="btn btn-sm btn-outline-danger float-right mt-3 <?=$btn_exp['class']?>"
                                        id="btn_delete"
                                        data-code="<?=$val['label']?>"
                                        onclick="<?=$btn_exp['return']?>">Delete</a>
                                <?php } else { ?>
                                    <a href="<?=$url['action']['delete'].$val['id']?>"
                                        class="btn btn-sm btn-outline-danger float-right mt-3"
                                        id="btn_delete"
                                        data-code="<?=$val['label']?>"
										>Delete</a>
									<!-- <a href="$url['action']['edit'].$val['id']" 
                                        class="btn btn-sm btn-outline-primary float-right mt-3 mr-2">Reactivate</a> -->
                                <?php }?>
								<a href="<?=$url['action']['edit'].$val['id']?>" 
                                        class="btn btn-sm btn-outline-primary float-right mt-3 mr-2"
                                        >Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                
            }
            ?>
			</div>
			<?php if(isset($data['pagination'])): ?>
				<?php 
					$pagination_url = base_url("/admin442e17d83025ac7201c9b487db03fe226f67808ad2912247d72fac704c624d7b/sesi");
					$prev_num = $data['pagination']['page'] - 1;
					$next_num = $data['pagination']['page'] + 1;

					if($prev_num <= 0) {
						$prev_url = '#';
					} else {
						$prev_url = $pagination_url."?page=".$prev_num;
					}

					if($next_num >= $data['pagination']['total_page'] + 1) {
						$next_url = '#';
					} else {
						$next_url = $pagination_url."?page=".$next_num;
					}


				?>
				<div class="row mb-4">
					<div class="col">

					<?php

						// How many adjacent pages should be shown on each side?
						$adjacents = 2;

						//how many items to show per page
						$limit = $data['pagination']['perpage'];

						// if no page var is given, default to 1.
						$page = $data['pagination']['page'];

						//first item to display on this page
						$start = ($page - 1) * $limit;

						$total_pages = $data['pagination']['total_rows'];

						/* Setup page vars for display. */
						$prev = $page - 1;
						$next = $page + 1;
						$lastpage = ceil($total_pages / $limit);
						$last = $lastpage;
						//last page minus 1
						$lpm1 = $lastpage - 1;

						$first_pages = "<li class='page-item'><a class='page-link' href='?page=1'>1</a></li>" .
							"<li class='page-item'><a class='page-link' href='?page=2'>2</a>";

						$ellipsis = "<li class='page-item disabled'><span class='page-link'>...</span></li>";

						$last_pages = "<li class='page-item'><a class='page-link' href='?page=$lpm1'>$lpm1</a></li>" .
							"<li class='page-item'><a class='page-link' href='?page=$lastpage'>$lastpage</a>";

						$pagination = "<nav aria-label='page navigation'>";
						$pagination .= "<ul class='pagination'>";

						//previous button

						$disabled = ($page === 1) ? "disabled" : "";
						$pagination.= "<li class='page-item $disabled'><a class='page-link' href='?page=$prev'>« previous</a></li>";

						//pages 
						//not enough pages to bother breaking it up
						if ($lastpage < 7 + ($adjacents * 2)) { 
							for ($i = 1; $i <= $lastpage; $i++) {
								$active = $i === $page ? "active" : "";
								$pagination .= "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
							}
						} elseif($lastpage > 5 + ($adjacents * 2)) {
							//enough pages to hide some
							//close to beginning; only hide later pages
							if($page < 1 + ($adjacents * 2)) {
								for ($i = 1; $i < 4 + ($adjacents * 2); $i++) {
									$active = $i === $page ? "active" : "";
									$pagination .= "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
								}
								$pagination .= $ellipsis;
								$pagination .= $last_pages;
							} elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
								//in middle; hide some front and some back
								$pagination .= $first_pages;
								$pagination .= $ellipsis;
								for ($i = $page - $adjacents; $i <= $page + $adjacents; $i++) {
									$active = $i === $page ? "active" : "";
									$pagination .= "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
								}
								$pagination .= $ellipsis;
								$pagination .= $last_pages;
							} else {
								//close to end; only hide early pages
								$pagination .= $first_pages;
								$pagination .= $ellipsis;
								$pagination .= "<li class='page-item disabled'><span class='page-link'>...</span></li>";
								for ($i = $lastpage - (2 + ($adjacents * 2)); $i <= $lastpage; $i++) {
									$active = $i === $page ? "active" : "";
									$pagination .= "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
								}
							}
						}

						//next button
						$disabled = ($page == $last) ? "disabled" : "";
						$pagination.= "<li class='page-item $disabled'><a class='page-link' href='?page=$next'>next »</a></li>";

						$pagination .= "</ul></nav>";

						if($lastpage <= 1) {
							$pagination = "";
						}

						echo $pagination;
						?>

						<!-- <nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								
								<li class="page-item <?=$prev_url=='#'?'disabled':'' ?>">
									<a href="<?=$prev_url?>" class="page-link">Previous</a>
								</li>

					
									<?php for($i=1;$i<=$data['pagination']['total_page']; $i++): ?>
										<li class="page-item <?=$i==$data['pagination']['page']? "disabled": "" ?>"><a class="page-link" href="<?=$pagination_url."?page=".$i ?>"><?= $i ?></a></li>
									<?php endfor; ?>

								<li class="page-item <?=$next_url=='#'?'disabled':'' ?>">
									<a class="page-link" href="<?=$next_url?>">Next</a>
								</li>
							</ul>
						</nav> -->
					</div>
				</div>
			<?php endif; ?>
            </div>
            <?php
        } else {
            echo '<div class="col-12 text-center"><span>Tidak ada data</span></div>';
        }
        ?>

    </div>

    <div class="modal fade" id="pesertaModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header pb-2">
                    <h5 class="modal-title">Data Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <form id="form_peserta">
                        <input type="hidden" name="id" value="">
                        <textarea name="users" id="val_peserta" data-code="" placeholder="Masukan Username atau Fullname"></textarea>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>


    
    <script src="<?=base_url()?>assets/js/admin/sesi_form.js"></script>
    <script src="<?=base_url()?>assets/jquery_validate/jquery.validate.min.js"></script>
    <script>
    const admSesi = new AdminSesi({
        base: '<?=$url['base']?>',
    });
    </script>
</body>
</html>
