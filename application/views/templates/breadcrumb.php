<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a id="home_button" href="<?php echo site_url('/');?>">Home</a></li>
		<?php foreach ($items as $item):?>
		<li class="breadcrumb-item active" aria-current="page"><?php echo $item;?></li>
		<li class="breadcrumb-item" ng-if="subtest" ng-cloak>{{subtest}}</li>
		
		<?php endforeach;?>
		<li style="position:absolute; right: 0" class="mr-3">
			<a ng-if="petunjuk_button" href="#" ng-click="toggle_petunjuk()"><i style="margin-bottom: -5px;" data-feather="help-circle"></i> Petunjuk</a>
		</li>
	</ol>
</nav>
