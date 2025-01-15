<script>
	app.controller('main', function($scope, $http, $window) {
		$scope.quiz_url = '<?php echo $quiz_url;?>';
		$scope.arr_code = <?php echo json_encode($arr_code);?>;
		$scope.arr_quiz = <?php echo json_encode($arr_quiz);?>;
		$scope.quiz_url_suffix = '<?php echo $quiz_url_suffix;?>';

		$scope.done = function(code, done) {
			if (done == 1) {
				return true
			}
			else {
				return false
			}
		}

		$scope.handleOpen = function(code){
			const nextUrl = `${$scope.quiz_url}${code}${$scope.quiz_url_suffix}`;
			
			// checkUser()
			
			$window.location.href = nextUrl;
		}
	})

</script>
<style>
	.new-wrap{
		background-color:#F7F7F7; 
		border: 3px solid #FCB034;
		border-radius: 0.25rem;
	}

	.btn-yellow {
		color: #fff;
		background-color: #FCB034;
		border-color: #FCB034;
	}

	.alert-yellow{
		color: #FCB034;
		background-color: #FCB03420;
		border-color: #FCB03420;
	}

</style>
<div class="container mt-5">
	<div class="row mt-3">
		<div class="col-lg-3 col-sm-12">
			<div class="card card-transparent new-wrap">
				<div class="card-body">
					<div class="row">
						<div class="col"><strong class="text-secondary">Nama Peserta</strong></div>
					</div>
					<div class="row mb-3">
						<div class="col"><h2><?php echo $user->nama;?></h2></div>
					</div>
					<div class="row">
						<div class="col"><strong class="text-secondary">Kode Peserta</strong></div>
					</div>
					<div class="row">
						<div class="col"><h2><?php echo $user->kode;?></h2></div>
					</div>
					<div class="row mt-3">
						<div class="col"><strong>Waktu Ujian</strong></div>
					</div>
					<div class="row">
						<div class="col-12"><?php echo $user->time_from;?></div>
						<div class="col-12">Sampai</div>
						<div class="col-12"><?php echo $user->time_to;?></div>
					</div>
					<?php if (isset($part) && $part != ''):?>
					<div class="row mt-4">
						<div class="col">
							<h3 class="alert alert-dark text-center">
								<strong><?php echo $part;?></strong>
							</h3>
						</div>
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>
		<div class="col-lg-9 col-sm-12">
			<div class="container new-wrap p-3" style="height: 100%">
					<h2 class="mb-4">
					<?php echo $greeting == '' ? $this->config->item('app_name') : $greeting;?>
					</h2>
				
				<div class="row" ng-controller="main" ng-cloak>
					<div class="col-12">
						<div class="container">
							<div class="row">
								<div class="col-7" style="height:250px;">
									<div class="col mb-4" style="height:250px; border-bottom: 3px solid #FCB03450" ng-repeat="quiz in arr_quiz">
										<div class="d-flex flex-column justify-content-between py-2" style="height:100%;">
											<div class="d-flex">
												<h6>{{quiz.label}}</h6>
												<p>{{quiz.description}}</p>
											</div>
											<div class="d-flex">
												<button ng-if="done(quiz.code, quiz.done) == false" ng-click="handleOpen(quiz.code)" title="Open Questions" class="btn btn-warning"><i style="width:1rem; height:1rem; margin-bottom: -2px;" data-feather="arrow-right-circle"></i>&nbsp;Open</button>
												<?php /*
												<a ng-if="done(quiz.code) == true" ng-click="restart(quiz.code)" id="quiz_{{quiz.code}}" class="btn btn-warning">Ulangi</a> */;?>
												<span ng-if="done(quiz.code, quiz.done) == true" class="alert alert-yellow">Sudah dilaksanakan</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-5">
									<img src="/assets/images/bg-content.png" width="80%" alt="bg-content"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
