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
		<div class="body-bg-image-taxand">
			<div class="d-flex flex-column justify-content-center align=items-center text-center" style="margin: 50px; background-color:#ffffff; color:red; z-index: 50;padding:1rem; border-radius: 1.5rem">
				<h2>Anda tidak diperkenankan login multiple user!</h2>
				<h3>Mohon untuk login kembali</h3>
				<button type="button" id="loginUlang" class="btn btn-primary">Login</button>
			</div>
		</div>
	</main>
	<script src="<?php echo base_url('assets/js/jquery-3.2.1.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js');?>"></script>
	<script>
		$(document).ready(()=>{
			const logoutUrl = '<?php echo site_url('auth/ajax_logout');?>' 
			const login = $('#loginUlang')
			login.click((evt)=>{
				logout()
				evt.preventDefault()
			})

			function deleteAllCookies() {
				const cookies = document.cookie.split(";");

				for (let i = 0; i < cookies.length; i++) {
					const cookie = cookies[i];
					const eqPos = cookie.indexOf("=");
					const name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
					document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
				}
			}

			function logout(){
				$.ajax({
					dataType: 'json',
					error: function(data) {
						$('#modal_title').html('Alert')
						$('#msg').html("Silahkan coba beberapa saat lagi.")
						$('#modal').modal('show')
					},
					success: function(data) {
						if (data.redirect) {
							window.localStorage.clear()
							deleteAllCookies()
							window.location.href = data.redirect
						}
					},
					type: 'POST',
					url: logoutUrl
				})
			}
		})
	</script>
</body>
</html>

