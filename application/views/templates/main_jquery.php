<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="<?= base_url('assets/images/favicon.ico');?>" />
    
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/open-iconic-bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/base.css');?>" />
	<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
	<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
	<style>[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
		display: none !important;
	} .oi.t3 {top: 3px;} body {overflow-x: hidden;}</style>
	<link rel='stylesheet' href='<?php echo base_url('assets/css/styles.css'); ?>' />
	<script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
	<link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" />
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css" rel="stylesheet">
	
	<script src="https://jsuites.net/v4/jsuites.js"></script>
	<link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />
	
	<style>
		.body-bg-image-disclaimer {
			background-image:url('/assets/images/bg-disclaimer.jpeg');
			background-repeat: no-repeat;
			background-size: 100vw 93vh;
			position: absolute;
			left: 0px;
			width: 100vw;
			bottom: 0;
		}
	</style>
	<title>{title}</title>
</head>
<body class="body-bg-image-main" ng-app="ExamPlatform" ng-controller="main" id="QuixTaxand">
	<h4 id="badge-info" style="position: absolute; top: 5px; left: 5px; z-index: 1026;" ng-cloak></h4>
	
	<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light justify-content-between header">
		<!-- <a id="a_logo" class="navbar-brand" href="<?php //echo site_url('/');?>"> -->
		<a class="navbar-brand" href="#">
			<?php if ($this->config->item('app_header_logo') != ''):?>
				<img src="<?php echo base_url($this->config->item('app_header_logo'));?>" alt="<?php echo $this->config->item('app_name');?>" />
			<?php else:?>
				<?php echo $this->config->item('app_name');?>
			<?php endif;?>
		</a>
		<h7 id="timer_container" class="text-primary" ng-class="seconds_extra_active == true ? 'text-danger' : ''" ng-if="timer" ng-cloak>
			<span>{{timer}}</span>
			<div class="progress">
				<div class="progress-bar" ng-class="seconds_extra_active == true ? 'bg-danger' : ''" role="progressbar" style="width: {{progress_percent}}%" aria-valuenow="{{progress_now}}" aria-valuemin="0" aria-valuemax="{{progress_max}}"></div>
			</div>
		</h7>
		
		<div>
			<a href="/faq" onclick="this.target = ''; window.open(this.href, '', 'width=1024,height=600'); return false;" style="margin-left: 10px; margin-right: 10px;" title="Frequently Asked Questions - Online Test Pbtaxand" target="FAQ">FAQ</a>
			<button class="btn btn-outline-danger" type="button" id="logout_button">Logout</button>
		</div>
	</nav>
	
	<!-- {breadcrumb} -->
	<!-- <div class="body-bg-image-main"></div> -->
	<div class="container-fluid container-body">
		<div class="row">
			<div class="col" style="background-color:transparent;">
				<img src="/assets/images/pbtaxand/Logo_new.png" height="42"/>
			</div>
		</div>
		{body}
	</div>
	
	<div class="modal fade" id="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modal_title">Alert</h5>
					<button id="custButton" type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p id="msg"></p>
				</div>
				<div class="modal-footer">
					<button id="closerButton" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<script>var logoutUrl = '<?php echo site_url('auth/ajax_logout');?>'; var clientUsername = '<?php echo md5($this->session->userdata('username'));?>';</script>
	<script src="<?php echo base_url('assets/js/init.js');?>"></script>
	<script src="<?php echo base_url('assets/js/new-main.js?v=2.0');?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script>feather.replace()</script>
	<?php 
		if ($this->session->flashdata('error')) {
			echo "<script> Swal.fire('Error', '".$this->session->flashdata('error')."','error')</script>";
		}

		if ($this->session->flashdata('warning')) {
			echo "<script> Swal.fire('Warning', '".$this->session->flashdata('warning')."','warning')</script>";
		}
	?>
</body>
</html>
