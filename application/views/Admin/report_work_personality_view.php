<div class="card mb-3 mt-3">
	<div class="card-body">
		<h3 class="card-title">Hasil Pemetaan Core Competency Berdasarkan Work Personality Profiling</h3>
		
		<div class="row mb-3">
			<div class="col-lg-6 mb-3">
				<canvas id="work_personality_chart1"></canvas>
			</div>
			<div class="col-lg-6 mb-3">
				<canvas id="work_personality_chart2"></canvas>
			</div>
		</div>
	</div>
</div>

<script>
var work_personality_data1 = {
	labels: ['Authencity', 'Customer Orientation', 'Achievement Orientation', 'Agility', 'Fostering Collaboration'],
	datasets: [{
		label: 'Value',
		backgroundColor: window.chartColors.brown,
		data: [
			40,
			70,
			30,
			18,
			45
		],
	},
	{
		label: 'Average',
		backgroundColor: window.chartColors.light_brown,
		data: [
			58,
			53,
			50,
			45,
			43
		],
	}]
}

var work_personality_ctx1 = document.getElementById('work_personality_chart1').getContext('2d');

window.work_personality_chart1 = new Chart(work_personality_ctx1, {
	type: 'bar',
	data: work_personality_data1,
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
	}
})

var work_personality_data2 = {
	labels: ['Authencity', 'Customer Orientation', 'Achievement Orientation', 'Agility', 'Fostering Collaboration'],
	datasets: [
	{
		label: 'Level 1',
		backgroundColor: window.chartColors.brown,
		stack: 'Stack 1',
		data: [
			50,
			50,
			50,
			50,
			50
		],
	},
	{
		label: 'Level 2',
		backgroundColor: window.chartColors.red,
		stack: 'Stack 1',
		data: [
			19,
			19,
			19,
			19,
			19
		],
	},
	{
		label: 'Level 3',
		backgroundColor: window.chartColors.yellow,
		stack: 'Stack 1',
		data: [
			5,
			5,
			5,
			5,
			5
		],
	},
	{
		label: 'Level 4',
		backgroundColor: window.chartColors.green,
		stack: 'Stack 1',
		data: [
			15,
			15,
			15,
			15,
			15
		],
	},
	{
		label: 'Level 5',
		backgroundColor: window.chartColors.dark_green,
		stack: 'Stack 1',
		data: [
			11,
			11,
			11,
			11,
			11
		],
	},
	{
		label: 'Value',
		backgroundColor: window.chartColors.black,
		stack: 'Stack 0',
		data: [
			40,
			70,
			30,
			18,
			45
		],
	}]
}

var work_personality_ctx2 = document.getElementById('work_personality_chart2').getContext('2d');

window.work_personality_chart2 = new Chart(work_personality_ctx2, {
	type: 'horizontalBar',
	data: work_personality_data2,
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
		}
	}
})
</script>
