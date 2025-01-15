<script>var logoutUrl = '<?php echo site_url($admin_url.'/ajax_logout');?>';</script>
	<script src="<?php echo base_url('assets/js/init.js');?>"></script>
	<script src="<?php echo base_url('assets/js/new-main.js');?>"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/popper.min.js');?>"></script>
	<?php if ($this->uri->segment(2) == 'users_quiz_terjadwal'):?>
	<script src="<?php echo base_url('assets/js/moment.min.js');?>"></script>
	<script src="<?php echo base_url('assets/js/tempusdominus-bootstrap-4.min.js');?>"></script>
	<?php endif;?>
</body>
</html>
