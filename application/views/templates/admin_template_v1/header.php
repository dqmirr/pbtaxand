<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="<?= base_url('assets/images/favicon.ico');?>" />
    
	<?=$head_assets_css ?>
	<?=$head_assets_js ?>
	
	<title><?= $title ?></title>
</head>
<body>
	<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light justify-content-between header">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<a class="navbar-brand" href="<?php echo site_url($this->uri->segment(1));?>">
			<?php if ($this->config->item('app_header_logo') != ''):?>
				<img src="<?php echo base_url($this->config->item('app_header_logo'));?>" alt="<?php echo $this->config->item('app_name');?>" />
			<?php else:?>
				<?php echo $this->config->item('app_name');?>
			<?php endif;?>
		</a>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav">
					<a class="nav-link" href="<?php echo site_url($admin_url);?>">Dashboard</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Quiz
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?php echo site_url($admin_url.'/quiz');?>">Quiz</a>
						<a class="dropdown-item" href="<?php echo site_url($admin_url.'/quiz_group');?>">Group</a>
						<a class="dropdown-item" href="<?php echo site_url($admin_url.'/quiz_group_items');?>">Group Items</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Soal
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="<?php echo site_url($admin_url.'/soal/gti');?>">GTI</a>
						<a class="dropdown-item" href="<?php echo site_url($admin_url.'/soal/multiplechoice');?>">Multiplechoice</a>
						<a class="dropdown-item" href="<?php echo site_url($admin_url.'/preview_soal');?>">Preview</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url($admin_url.'/generate_paket_soal');?>">Generate Paket Soal</a>
                        <a class="dropdown-item" href="<?php echo site_url($admin_url.'/soal/generate_exam');?>">Generate Exam</a>
					</div>
				</li>
				<li class="nav">
					<a class="nav-link" href="<?php echo site_url($admin_url.'/sesi');?>">Sesi</a>
				</li>
				<li class="nav">
					<a class="nav-link" href="<?php echo site_url($admin_url.'/formasi');?>">Formasi</a>
				</li>
				<li class="nav">
					<a class="nav-link" href="<?php echo site_url($admin_url.'/users');?>">Users</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle <?=$nav['report']?>"
						href="#" 
						id="navbarDropdown" 
						role="button" 
						data-toggle="dropdown"
						aria-haspopup="true"
						aria-expanded="false">Report</a>
					<div class="dropdown-menu"
						aria-labelledby="navbarDropdown">

						<?php if ($report_url != ''):?>
						<a class="dropdown-item <?=$nav['child']['generate']?>" href="<?=site_url($admin_url).'/'.$report_url?>">Generate</a>
						<?php else:?>
						<a class="dropdown-item <?=$nav['child']['generate']?>" href="<?=site_url($admin_url)?>/report_gti">Generate</a>
						<?php endif;?>

						<a class="dropdown-item <?=$nav['child']['psycogram']?>" href="<?=site_url($admin_url)?>/psycogram">Psycogram</a>
					</div>
				</li>

			 <li class="nav">
					<?php if ($report_url != ''):?>
					<a class="nav-link text-primary" href="<?php echo site_url($admin_url.'/'.$report_url);?>">Report</a>
					<?php else:?>
					<a class="nav-link text-primary" href="<?php echo site_url($admin_url.'/report_gti');?>">Report</a>
					<?php endif;?>
				</li> 

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					System
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="nav-link" href="<?php echo site_url($admin_url.'/custom_reports');?>">Custom Reports</a>
						<a class="nav-link" href="<?php echo site_url($admin_url.'/settings');?>">Settings</a>
						<a class="nav-link" href="<?php echo site_url($admin_url.'/email_job');?>">Email Job</a>
						<a class="nav-link" href="<?php echo site_url($admin_url.'/upload_users');?>">Upload Users&hellip;</a>
						<a class="nav-link" href="<?php echo site_url($admin_url.'/users_quiz_terjadwal');?>">Users Quiz Terjadwal&hellip;</a>
					</div>
				</li> 
			</ul>
		</div>
		
		<div class="col-sm-12 col-lg-2 text-right">
			<a class="btn btn-outline-primary mr-3" href="<?php echo site_url($admin_url.'/change_password');?>"><span class="oi oi-person"></span></a>
			<button class="btn btn-outline-danger" type="button" id="logout_button">Logout</button>
		</div>
	</nav>
