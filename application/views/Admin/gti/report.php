

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="<?=base_url()?>assets/images/favicon.ico">
    <?=$this->load->view('Admin/stylesheet');?>

    <title>
      Gti - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

        <div style="position:absolute;">
            <button class="btn btn-primary m-2" onclick="history.back();">Back</button>
            <button class="btn btn-primary m-2" onclick="download();">Download</button>
        </div>
        <div class="d-flex w-100 h-100 justify-content-center">
            <div id="page" style="width: 210mm;font-size:12px;">
                <div class="container-fluid">
                    <div class="d-flex justify-content-center ">
                        <h4 class="mt-3 mb-3">INDIVIDUAL ASSESMENT REPORT</h4>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col">Name</div>
                                    <div class="col-8">: <?=$data['name']?></div>
                                </div>
                                <div class="row">
                                    <div class="col">Date</div>
                                    <div class="col-8">: <?=$data['date']?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6"></div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-9">
                            <div class="row">
                                <div class="col">
                                    <canvas id="report_gti" width="100%"></canvas>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-10 mt-2">
                                    <div class="container mt-2">
                                        <div class="row"><div class="col">Description</div></div>
                                        <div class="row">
                                        <?php foreach($data['keterangan_warna'] as $warna): ?>
                                            <div class="col py-2" style="background-color:<?=$warna->color;?>;text-align:center;font-size:8px;">
                                                <?=$warna->label;?>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                                <table style="width:100%;border:2px solid #000;">
                                        <tr class="bg-dark">
                                            <td class="bg-dark text-light text-center p-3" colspan="2">GTI</td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 text-center py-2" style="border-right: 2px solid #000;"><span style="font-weight:bold;"><?=$data["gtq"]["value"] ?></span></td>
                                            <td class="w-50 text-center py-2"><span style="line-height:18px; font-weight:bold;"><?=$data["gtq"]["keterangan"] ?></span></td>
                                        </tr>
                                </table>
                                <table class="table table-bordered mt-2" style="font-size:8px;">
                                    <tr>
                                        <td>Letter Checking <br> (94-110)</td>
                                        <td><?=$data["result"]["Subtest 1"]["GTQ"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Reasoning <br> (77-98)</td>
                                        <td><?=$data["result"]["Subtest 2"]["GTQ"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Letter Distance <br> (77-99)</td>
                                        <td><?=$data["result"]["Subtest 3"]["GTQ"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Number Distance <br> (81-100)</td>
                                        <td><?=$data["result"]["Subtest 4"]["GTQ"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Spatial Orientation <br> (85-103)</td>
                                        <td><?=$data["result"]["Subtest 5"]["GTQ"]; ?></td>
                                    </tr>
                                </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-4">
                            <table class="table mt-4" border="1">
                                <thead>
                                    <tr>
                                        <th class="bg-success text-light text-center col-6">Kelebihan</th>
                                        <th class="bg-danger text-light text-center col-6">Kekurangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col pl-4">
                                                        <ul>
                                                            <?php foreach($data['kelebihan'] as $kelebihan): ?>
                                                            <li><?=$kelebihan ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col pl-4">
                                                        <ul>
                                                            <?php foreach($data['kelemahan'] as $kelemahan): ?>
                                                                <li><?=$kelemahan ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?=$this->load->view('Admin/assets_js');?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="<?= base_url('/assets/js/chart/report_gti.js'); ?>"></script>
    <script>ReportGTI(<?=$data["result_json"]?>);</script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jspdf-html2canvas@latest/dist/jspdf-html2canvas.min.js"></script>
    <script>
        var download = function(){
            let page = document.getElementById('page');
            html2PDF(page, {
                jsPDF: {
                    unit: 'px',
                    format: 'a4',
                },
                html2canvas:{
                    scale:2,
                },
                imageType: 'image/jpeg',
                imageQuality: 0.98,
                output: '<?=$data["pdf_name"];?>'
            });
        }
    </script>
</body>
</html>
