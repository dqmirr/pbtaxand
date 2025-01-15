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
        Quiz - <?=$this->config->item('app_name');?>
    </title>
</head>

<body>
    <?=$this->load->view('Admin/navigasi' ,$nav)?>

	<h1>asda</h1>
	<script>
    class AdminSoal{
		constructor(){
		}
		fetchData(){}
	}
    </script>
</body>
</html>

