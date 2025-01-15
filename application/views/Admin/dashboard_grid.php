


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>
	<link rel="stylesheet" href="<?=base_url()?>assets/css/datatable_custom.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/dtables/datatables.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/admin_dashboard.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/treeview.css">

    <title>
        Dashboard - <?=$nav['app_name']?>
    </title>
</head>
<style>
.progress-bar-animated-reverse {
    animation-direction: reverse;
}
</style>
<body>
    <?=$this->load->view('Admin/navigasi', $nav)?>

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm">
                <h4 class="mt-3 mb-3">Dashboard</h4>
            </div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
        </div>


        <div class="row mb-3">
            <div class="col-xl-2 col-md-12 mb-2">
                <div class="card border-left-primary h-100">
                    <div class="card-body ">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a class="font-weight-bold text-primary text-uppercase mb-1" href="<?=$url['base']?>/users">Users</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$dashboard['user_active']?></div>
                            </div>

                            <div class="col-auto">
                                <i class="fa fa-solid fa-users fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xl-2 col-md-12 mb-2">
                <div class="card border-left-success h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a class="font-weight-bold text-success text-uppercase mb-1" href="<?=$url['base']?>/formasi">Formasi</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$dashboard['jumlah_formasi']?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-solid fa-sitemap fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    
            <div class="col-xl-2 col-md-12 mb-2">
                <div class="card border-left-info h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a class="font-weight-bold text-info text-uppercase mb-1" href="<?=$url['base']?>/sesi">Sesi</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$dashboard['sesi_active']?></div>
                            </div>

                            <div class="col-auto">
                                <i class="fa fa-solid fa-tasks fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-xl-2 col-md-12 mb-2">
                <div class="card border-left-warning h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a class="font-weight-bold text-warning text-uppercase mb-1" href="<?=$url['base']?>/soal/gti">Soal GTI</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$dashboard['jumlah_gti']?></div>
                            </div>
                            
                            <div class="col-auto">
                                <i class="fa fa-solid fa-list-alt fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            

            <div class="col-xl-2 col-md-12 mb-2">
                <div class="card border-left-danger h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a class="font-weight-bold text-danger text-uppercase mb-1" href="<?=$url['base']?>/soal/multiplechoice">Multiple</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$dashboard['jumlah_multiple']?></div>
                            </div>

                            <div class="col-auto">
                                <i class="fa fa-solid fa-check-square-o fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xl-2 col-md-12 mb-2">
                <div class="card border-left-secondary h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <a class="font-weight-bold text-secondary text-uppercase mb-1" href="<?=$url['base']?>/quiz">Quiz</a>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$dashboard['jumlah_quiz']?></div>
                            </div>

                            <div class="col-auto">
                                <i class="fa fa-solid fa-file-text fa-3x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-2 pb-0">
            <div class="card-header p-1">
                <b class="pl-2" 
                    style="top: 5px; position: relative">Data Sesi</b>
                <form method="post" 
                    action="<?=$url['base']?>"
                    class="float-right row p-0">
                    <input type="month" 
                        name="tahun"
                        class="form-control col-sm p-1"
                        value="<?=$dashboard['tahun']?>"
                        style="position: relative; right: 25px; top: 0px">
                    <button type="submit" 
                        class="btn btn-sm btn-outline-primary float-right  col-sm" 
                        style="position: relative; right: 15px">Ganti</button>
                </form>
            </div>


            <div class="card-body mb-0">
                <center>
                    <?php if(count($dashboard['sesi_list']) > 0) { ?>
                        <?php foreach($dashboard['sesi_list'] as $key => $val) { ?>
                        <div class="mb-4">
                            <div class="row col-sm-12 border-card text-center" 
                                id="row_<?=$val['code']?>" 
                                data-code="<?=$val['code']?>"
                                onclick="dashboard.detail(this)">
                                <div class="col-sm-1">
                                    <div class="badge <?=$val['badge']?>" style="width: 80px">
                                        <span class="fa fa-circle"></span> <?=$val['text']?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="label-group">
                                        <p class="title"><?=$val['label']?></p>
                                        <p class="caption">code : <?=$val['code']?></p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="label-group">
                                        <p class="title">
                                            <div class="progress">
                                                <div class="progress-bar bg-warning
                                                progress-bar-animated progress-bar-animated-reverse" role="progressbar"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                                style="transition-duration:300ms;
                                                width:<?=$val['persen']?>%"><?=$val['persen']?>%</div>
                                            </div>
                                        </p>
                                        <p class="caption"><?=$val['hari']?> Hari (<?=$val['tanggal']?>)</p>
                                    </div>
                                </div>

                                <div class="col-sm-2 row">
                                    <div class="col-6 title-single pr-0"><?=count($val['users'])?> Peserta</div>
                                    <div class="col-6 pl-0">
                                        <canvas id="doug_<?=$val['code']?>"></canvas>
                                    </div>
                                </div>

                                <div class="col-sm-3"><?=$val['part']?></div>
                                
                            </div>

                            <div class="row col-sm-12 detail-card text-left pl-4"
                                id="detail_<?=$val['code']?>" 
                                style="display: none">
                                
                                <ul class="tree pl-4">
                                    <?php foreach($val['users'] as $key1 => $val1) { ?>
                                    <li class="mb-3">
                                        <details>
                                            <summary>
                                                <div class="row col-12">
                                                    <div class="col-4"><?=($key1+1)?>. <?=$val1['fullname']?></div>
                                                    <div class="col-4"><?=$val1['formasi']?></div>
                                                    <div class="col-4"><?=$val1['text_quiz']?></div>
                                                </div>
                                            </summary>

                                            <ul>
                                                <?php foreach($val1['quiz'] as $key2 => $val2) { ?>
                                                <li>
                                                    <div class="row col-12">
                                                        <div class="col-4"><?=$val2['label']?></div>
                                                        <div class="col-4">
                                                            <span class="badge <?=$val2['badge']?>"><?=$val2['status']?></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php } ?>
                                            </ul>

                                        </details>
                                    </li>
                                    <?php } ?>
                                </ul>

                            </div>
                        </div>
                    
                        <?php } ?>
                    <?php } else { ?>
                        Tidak ada data
                    <?php } ?>
                </center>

            </div>
        </div>


        <div class="card mb-2 pb-3" style="display: none">
            <div class="card-header p-1">
                <b class="pl-2" 
                    style="top: 5px; position: relative">Data Sesi</b>
                <form method="post" 
                    action="<?=$url['base']?>"
                    class="float-right row p-0">
                    <input type="month" 
                        name="tahun"
                        class="form-control col-sm p-1"
                        value="<?=$dashboard['tahun']?>"
                        style="position: relative; right: 25px; top: 0px">
                    <button type="submit" 
                        class="btn btn-sm btn-outline-primary float-right  col-sm" 
                        style="position: relative; right: 15px">Ganti</button>
                </form>
            </div>

            <div class="card-body row">

                <?php if(count($dashboard['sesi_list']) > 0) { ?>
                <div class="col-sm-6">

                    <?php foreach($dashboard['sesi_list'] as $key => $val) { ?>
                    <div class="card mycard">
                        <div class="card-body pt-1 pb-1">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <a href="#" class="text-lg font-weight-bold text-info text-uppercase mb-1" data-code="<?=$val['code']?>" onclick="dashboard.viewUser(this)"><?=$val['label']?></a>
                                    <div class="h6 mb-1 font-weight-bold text-gray-800"><?=count($val['users'])?> User</div>
                                    <div class="mb-0 text-gray-800"><?=$val['hari']?> Hari</div>
                                    <div class="mb-0 text-gray-800"><?=$val['tanggal']?></div>
                                    
                                </div>
                                <div class="col-sm-2 this-chart">
                                    <canvas id="myChart_<?=$val['code']?>"
                                        class="float-right right"
                                        width="10"
                                        height="10"
                                        data-code="<?=$val['code']?>"></canvas>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                </div>

                <div class="col-sm-6">
                    <div class="card mycard">
                        <div class="card-body pt-1 pb-1">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-lg font-weight-bold text-info text-uppercase pt-2" id="header_users">User</div>
                                    <table id="data_users" class="table table-bordered table-sm" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="13">No</th>
                                                <th>Fullname</th>
                                                <th>Formasi</th>
                                                <th>Quiz</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody></tbody>

                                    </table>
                                    
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-sm-12">
                    <center>Tidak ada data</center>
                </div>
                <?php } ?>

                

            </div>


        </div>
    </div>

	<?=$this->load->view('Admin/assets_js');?>
    <script src="<?=base_url()?>assets/dtables/datatables.min.js"></script>
	
    <script src="<?=base_url()?>assets/js/admin/dashboard.js"></script>
    <script>
    const dashboard = new Dash({
        base: '<?=$url['base']?>',
        code: '<?=$dashboard['sesi_list'][0]['code']?>',
        tahun: '<?=$dashboard['tahun']?>',
        sesi: '<?=$dashboard['sesi_list'][0]['label']?>'
    });
    </script>
</body>
</html>
