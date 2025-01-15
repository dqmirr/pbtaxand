<div class="card mb-3 mt-3">
	<div class="card-body">
		<h3 class="card-title">Hasil Pemetaan Core Competency Berdasarkan Work Personality Profiling</h3>
		
		<div class="row mb-3">
			<div class="col mb-3">
				<canvas id="profiling_d3d_chart1"></canvas>
			</div>
			<div class="col mb-3">
				<canvas id="profiling_d3d_chart2"></canvas>
			</div>
		</div>
	</div>
</div>

<script>
var profiling_d3d_data1 = {
	labels: ['Narsistic', 'Psychopaty', 'Machiaveli'],
	datasets: [{
		label: 'Value',
		backgroundColor: window.chartColors.brown,
		data: [
			40,
			25,
			75
		],
	},
	{
		label: 'Average',
		backgroundColor: window.chartColors.light_brown,
		data: [
			55,
			50,
			45,
		],
	}]
}

var profiling_d3d_ctx1 = document.getElementById('profiling_d3d_chart1').getContext('2d');

window.profiling_d3d_chart1 = new Chart(profiling_d3d_ctx1, {
	type: 'bar',
	data: profiling_d3d_data1,
	options: {
		legend: {
			display: true,
		},
		responsive: true,
		title: {
			display: true,
			text: 'Average of measurement by condition'
		},
		plugins: {
			datalabels: {
				display: false,
				anchor: 'top',
			},
		},
		scales: {
			yAxes: [{
				display: true,
				ticks: {
					beginAtZero: true,
				}
			}]
		},
	}
})

var profiling_d3d_data2 = {
	labels: ['Narsistic', 'Psychopaty', 'Machiaveli'],
	datasets: [
	{
		label: 'Level 1',
		backgroundColor: window.chartColors.green,
		stack: 'Stack 1',
		data: [
			40,
			40,
			40,
		],
	},
	{
		label: 'Level 2',
		backgroundColor: window.chartColors.yellow,
		stack: 'Stack 1',
		data: [
			15,
			15,
			15,
		],
	},
	{
		label: 'Level 3',
		backgroundColor: window.chartColors.red,
		stack: 'Stack 1',
		data: [
			15,
			15,
			15,
		],
	},
	{
		label: 'Level 4',
		backgroundColor: window.chartColors.brown,
		stack: 'Stack 1',
		data: [
			20,
			20,
			20,
		],
	},
	{
		label: 'Value',
		backgroundColor: window.chartColors.black,
		stack: 'Stack 0',
		data: [
			40,
			25,
			75,
		],
	}]
}

var profiling_d3d_ctx2 = document.getElementById('profiling_d3d_chart2').getContext('2d');

window.profiling_d3d_chart2 = new Chart(profiling_d3d_ctx2, {
	type: 'horizontalBar',
	data: profiling_d3d_data2,
	options: {
		legend: {
			display: true,
		},
		responsive: true,
		title: {
			display: true,
			text: 'Core competency'
		},
		plugins: {
			datalabels: {
				display: false,
				anchor: 'top',
			},
		},
		scales: {
			xAxes: [{
				stacked: true,
			}],
			yAxes: [{
				stacked: true
			}]
		},
	}
})
</script>
