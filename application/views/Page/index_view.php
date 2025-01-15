<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-121987486-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-121987486-1');
	</script>
	
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="icon" href="<?php echo base_url('favicon.ico');?>" />
    
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/open-iconic.min.css');?>" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css');?>" />
	
	<style>
		.shadow {box-shadow: 6px 10px 15px rgba(80,80,80,0.2);}
	</style>
	
	<title><?php echo $this->config->item('app_name');?></title>
</head>
<body>
	<nav class="navbar header">
			<h3 class="mx-auto">
				<?php if ($this->config->item('app_logo') != ''):?>
					<img class="img-fluid" src="<?php echo base_url($this->config->item('app_logo'));?>" alt="<?php echo $this->config->item('app_name');?>" />
				<?php else:?>
					<?php echo $this->config->item('app_name');?>
				<?php endif;?>
			</h3>
	</nav>
	<main id="Main">
		<div class="body-bg-image-taxand"></div>
		<div class="container">
			<?php if (isset($login_info['value'])):?>
			<div class="modal" tabindex="-1" role="dialog" id="login_info">
			<div class="modal-dialog modal-dialog-scrollable" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><?php echo strlen($login_info['value']) > 0 ? $login_info['value'] : 'Info';?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p><?php echo $login_info['description'];?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
				</div>
			</div>
			</div>
			<?php endif;?>
			<div class="row">
				<?php if ($survey_mode == 0 && $this->config->item('disable_info_login') != 1 && $btn_class != 'btn-danger'):?>
				<div class="col-lg-6 col-sm-12 px-5 d-flex">
					<div class="main-info mt-3" style="max-height: 85vh; overflow-y:auto;display:none;">
						<h4>Welcome</h4>
						<ul>
							<li>Selamat datang di Platform Online Test <?php echo $this->config->item('app_name'), ' ', date('Y');?>!</li>
						</ul>
						<h2 class="text-center alert alert-danger text-danger" style="font-size: 1.5em; font-weight: bold;">
							BACALAH DENGAN SEKSAMA PETUNJUK DAN KETENTUAN BERIKUT
						</h2>
						
						<h4>Petunjuk Umum</h4>
						<ul>
							<li>Pastikan Anda login dengan menggunakan Laptop. Anda tidak dapat menggunakan <em>Smartphone</em> / <em>Handphone</em> / Tablet untuk mengerjakan <em>Online Test</em> ini.</li>
							<li>Web browser yang direkomendasikan adalah Google Chrome (<a target="_blank" href="https://www.google.com/chrome/browser">https://www.google.com/chrome/browser</a>) dan Mozilla Firefox (<a target="_blank" href="https://www.mozilla.org/en-US/firefox/new/">https://www.mozilla.org/en-US/firefox/new/</a>).
							<br />
							<strong>Test online tidak dapat diakses selain dengan kedua browser tersebut.</strong></li>
							<li>Anda hanya bisa melakukan test sesuai dengan jadwal yang telah ditentukan.</li>
							<li>Pastikan Anda login dengan password dan username yang telah dikirimkan ke email.</li>
							<li>Untuk mencegah terjadinya error semua peserta dilarang melakukan perubahan atau berpindah ke browser lainnya selama pengerjaan test online dikerjakan.</li>
						</ul>
						<?php /*
						<h4>Ketentuan</h4>
						<ul>
							<li>Anda tidak diperkenankan untuk mendelegasikan <em>Online Test</em> ini kepada pihak manapun. Anda harus mengerjakan rangkaian <em>Online Test</em> ini sendiri.</li>
							<li>Setiap bentuk tindakan kecurangan selama <em>Online Test</em> ini akan memiliki konsekuensi sanksi berupa gagal tes dan masuk daftar hitam perusahaan.</li>
						</ul>
						*/;?>
						<div class="row">
							<div class="col text-center">
								<a href="/faq" onclick="this.target = ''; window.open(this.href, '', 'width=1024,height=600'); return false;" style="font-size: 1.5em;" title="Frequently Asked Questions - Online Test Pbtaxand" target="FAQ">FAQ</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-lg-6 col-sm-12 d-flex" style="margin-top:10%;">
					<div class="d-flex justify-content-end align-items-lg-end m-auto">
						<div class="card mx-5 card-login">
							<div class="card-body shadow">
								<form onsubmit="return false;">
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<span class="oi" data-glyph="person"></span>
												</span>
											</div>
											<input type="hidden" name="kick" value="0" />
											<input autocomplete="off" placeholder="Username" type="text" autofocus="autofocus" class="form-control" id="username" name="username" required="required" />
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text">
													<span class="oi" data-glyph="key"></span>
												</span>
											</div>
											<input autocomplete="off" placeholder="Password" type="password" class="form-control" id="password" name="password" required="required" />
										</div>
									</div>
									
									<?php if ($survey_mode == 0 && $this->config->item('disable_info_login') != 1 && $btn_class != 'btn-danger'):?>
									<div class="col-12 form-check">
										<input type="checkbox" id="sudah_membaca" class="form-check-input" />
										<label for="sudah_membaca" class="form-check-label">
										Dengan ini saya telah membaca dan menyetujui petunjuk dan ketentuan yang ada.
										</label>
									</div>
									<?php endif;?>
									
									<div class="col-sm-12 offset-lg-3 col-lg-6">
										<button type="submit" class="btn btn-lg <?php echo $btn_class;?> btn-block">
											Login
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<?php endif;?>
				<?php if ($survey_mode == 1 && $this->config->item('disable_info_login') != 1 && $btn_class == 'btn-danger'):?>
					<div class="col-lg-12 col-sm-12 d-flex pt-5">
						<div class="d-flex justify-content-end align-items-lg-end m-auto">
							<div class="card mx-5 card-login">
								<div class="card-body shadow">
									<form onsubmit="return false;">
										<div class="form-group">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<span class="oi" data-glyph="person"></span>
													</span>
												</div>
												<input type="hidden" name="kick" value="0" />
												<input autocomplete="off" placeholder="Username" type="text" autofocus="autofocus" class="form-control" id="username" name="username" required="required" />
											</div>
										</div>
										<div class="form-group">
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<span class="oi" data-glyph="key"></span>
													</span>
												</div>
												<input autocomplete="off" placeholder="Password" type="password" class="form-control" id="password" name="password" required="required" />
											</div>
										</div>
										
										<div class="col-sm-12 offset-lg-3 col-lg-6">
											<button type="submit" class="btn btn-lg <?php echo $btn_class;?> btn-block">
												Login
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			
			<div class="row mb-5">
				<div class="col"></div>
			</div>
		</div>
	</main>
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
	
	<script>var loginUrl = '<?php echo $login_url;?>';</script>
	<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/init.js');?>"></script>
	<script src="<?php echo base_url('assets/js/page.js');?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js');?>"></script>
	<?php if ($survey_mode == 0 && $this->config->item('disable_info_login') != 1 && $btn_class != 'btn-danger'):?>
	<script>
	$(function(){
		$('button[type="submit"]').hide();
		
		$('#sudah_membaca').on('change', function(){
			if ($(this).is(':checked')) {
				$('button[type="submit"]').show()
			}
			else {
				$('button[type="submit"]').hide()
			}
		})
	})
	</script>
	<?php endif;?>
	<?php if (isset($login_info['value'])):?>
	<script>
	$(function(){
		$('#login_info').modal('show')
	})
	</script>
	<?php endif;?>
</body>
</html>
