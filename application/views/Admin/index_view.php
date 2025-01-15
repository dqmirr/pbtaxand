<script src="<?php echo base_url('assets/js/angular-animate.min.js');?>"></script>
<link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.9.0/loading-bar.min.css' type='text/css' media='all' />
<script type='text/javascript' src='//cdnjs.cloudflare.com/ajax/libs/angular-loading-bar/0.9.0/loading-bar.min.js'></script>
<script>
var app = angular.module('AdminExamPlatform', ['angular-loading-bar','ngAnimate'])
app.controller('dashboard', ['$scope', '$interval', '$http', function($scope, $interval, $http) {
	$scope.arr_formasi = []
	//$scope.arr_beda_jadwal = []
	$scope.arr_tanpa_quiz = []
	$scope.url = '<?php echo $url;?>'
	$scope.refresh_every_minute = 1
	
	$scope.get_formasi = function(){
		
		$http({
			url: $scope.url+'ajax_get_formasi',
			method: 'post',
			data: $.param({}),
			dataType: 'Json',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.then(function(response){

			if (response.data.success) {
				$scope.arr_formasi = response.data.rows
			}
		})
		
	}
	
	$scope.get_tanpa_quiz = function(){
		
		$http({
			url: $scope.url+'ajax_get_tanpa_quiz',
			method: 'post',
			data: $.param({}),
			dataType: 'Json',
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		})
		.then(function(response){

			if (response.data.success) {
				$scope.arr_tanpa_quiz = response.data.rows
			}
		})
		
	}
	
	$scope.get_statistik = function(){
		$.ajax({
			data: {},
			dataType: 'JSON',
			error: function(data) {
				alert('Get Statistik: An Error Occured')
			},
			success: function(data){
				if (data.error) {
					alert(data.msg)
				}
				else {
					
					// Statistik
					chartStatistik.options.title.text = 'Total: '+data.stat.total
					chartStatistik.data.labels = data.stat.labels
					
					$.each(data.stat.data, function(index, datavalue){
						chartStatistik.data.datasets[index].data = datavalue
						chartStatistik.data.datasets[index].backgroundColor = data.stat.colors
					})
					
					chartStatistik.update()
					
					// Statistik Formasi
					chartFormasi.data.labels = data.formasi.labels
					
					$.each(data.formasi.data, function(index, datavalue){
						chartFormasi.data.datasets[index].data = datavalue
					})
					
					chartFormasi.update()
				}
			},
			type: 'POST',
			url: $scope.url+'ajax_get_statistik'
		})
	}
	
	$scope.load = function() {
		$scope.get_formasi()
		$scope.get_statistik()
		$scope.get_tanpa_quiz()
		
		// Update setiap $scope.refresh_every_minute
		stop = $interval(function(){
			$scope.get_formasi()
			$scope.get_statistik()
			$scope.get_tanpa_quiz()
		}, $scope.refresh_every_minute * 60 * 1000);
	}
}])
</script>

<div ng-app="AdminExamPlatform">
	<div ng-controller="dashboard" ng-init="load()">
		<div class="row mt-3">
			<div class="col">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Formasi</h5>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<th>Sesi</th>
									<th class="text-center">Jadwal</th>
									<th>Formasi</th>
									<th class="text-center">Test</th>
									<th class="text-right">Terdaftar</th>
									<th class="text-right">Email Sent</th>
									<th class="text-right">Login #1</th>
									<th class="text-right">Setuju</th>
									<th class="text-right">Aktif</th>
									<th class="text-right">Idle</th>
								</thead>
								<tbody ng-cloak>
									<tr ng-repeat="formasi in arr_formasi">
										<td>{{formasi.sesi}}</td>
										<td class="text-center">{{formasi.time_from}}<br />{{formasi.time_to}}</td>
										<td>{{formasi.formasi}}</td>
										<td class="text-center">
											<strong ng-if="formasi.dimulai == 1" class="text-danger">Sedang Dilaksanakan</strong>
											<span ng-if="formasi.dimulai == 2" class="text-muted">sudah selesai</span>
										</td>
										<td class="text-right">{{formasi.total}}</td>
										<td class="text-right" ng-class="formasi.email_sent == formasi.total ? 'text-success font-weight-bold' : ''">{{formasi.email_sent}}</td>
										<td class="text-right">{{formasi.first_login}}</td>
										<td class="text-right">{{formasi.agree}}</td>
										<td class="text-right">{{formasi.active}}</td>
										<td class="text-right">{{formasi.idle}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row mt-3">
			<!-- statistik -->
			<div class="col-lg-8 col-sm-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Statistik Login &amp; Test</h5>
						<div class="card-text">
							<div class="chart-container">
								<canvas id="chart_statistik"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="col-lg-4 col-sm-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Tidak Punya Quiz (Top 10 Data)</h5>
						<div class="table-responsive">
							<table class="table table-striped">
								<thead>
									<th>Nama</th>
									<th>Edit</th>
								</thead>
								<tbody ng-cloak>
									<tr ng-repeat="row in arr_tanpa_quiz">
										<td>{{row.fullname}}</td>
										<td><a class="btn btn-sm btn-warning" target="_blank" href="{{url}}user_quiz/{{row.id}}"><span class="oi oi-pencil"></span></a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="row mt-3">
			<!-- Formasi -->
			<div class="col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Statistik Formasi</h5>
						<div class="card-text">
							<div class="chart-container">
								<canvas id="chart_formasi" style="height: 400px;"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>

<div class="row mb-5"></div>

<script>
var color = '#FFA500'
var color2 = '#FF0000'

var objChartStatistik = $('#chart_statistik')
var objChartFormasi = $('#chart_formasi')

var dataStatistik = {
    datasets: [
		// Test
		{data: []},
		// Login
		{data: []},
	],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: []
};

var dataFormasi = {
	labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'],
	datasets: [
		// Ikut Test
		{
			label: 'Ikut Test',
			data: [], 
			backgroundColor: color
		},
		// Tidak ikut Test
		{
			label: 'Tidak Ikut Test',
			data: [], 
			backgroundColor: color2
		}
	],
}

var chartStatistik = new Chart(objChartStatistik,{
    type: 'doughnut',
    data: dataStatistik,
    options: {
        legend: {
			position: 'right',
			labels: {
				generateLabels: function(chart) {
                    var data = chart.data;
                    if (data.labels.length && data.datasets.length) {
                        return data.labels.map(function(label, i) {
                            var meta = chart.getDatasetMeta(0);
                            var ds = data.datasets[0];

                            var arc = meta.data[i];
                            var custom = arc && arc.custom || {};
                            var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                            var arcOpts = chart.options.elements.arc;
                            var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                            var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                            var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

							// We get the value of the current label
							var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];
							
							if (value == 0) {
								var meta = chart.getDatasetMeta(1);
								var ds = data.datasets[1];

								var arc = meta.data[i];
								var custom = arc && arc.custom || {};
								var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
								var arcOpts = chart.options.elements.arc;
								var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
								var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
								var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

								// We get the value of the current label
								var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];
							}

                            return {
                                // Instead of `text: label,`
                                // We add the value to the string
                                text: label + " : " + value,
                                fillStyle: fill,
                                strokeStyle: stroke,
                                lineWidth: bw,
                                hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                index: i
                            };
                        });
                    } else {
                        return [];
                    }
                }
			}
		},
		title: {
			display: true,
			text: 'Total: 0'
		},
		pieceLabel: {
			render: function(args){
				return args.value +' (' + args.percentage + '%)';
			},
			fontColor: '#000',
			overlap: true,
		},
		plugins: {
			datalabels: {
				display: false,
			}
		}
	}
});

var chartFormasi = new Chart(objChartFormasi,{
    type: 'bar',
    data: dataFormasi,
    options: {
        scales: {
            xAxes: [{
                stacked: true
            }],
            yAxes: [{
                stacked: true
            }]
        },
        maintainAspectRatio: false,
        plugins: {
		  datalabels: {
			 display: true,
			 align: 'center',
			 anchor: 'center'
		  }
	   }
    }
})

</script>
