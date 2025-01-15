<div class="card mb-3 mt-3">
	<div class="card-body">
		<div class="row">
			<div class="col">
				<span class="text-secondary">Nama Lengkap</span>
				<h4><?php echo $data['fullname'];?></h4>
			</div>
			<div class="col">
				<span class="text-secondary">Email</span>
				<h4><?php echo $data['email'];?></h4>
			</div>
		</div>
	</div>
</div>

<div class="card mb-3 mt-3">
	<div class="card-body">
		<h3 class="card-title">Hasil Test Seleksi General Mental Ability Screening Test</h3>

		<div class="row mb-3">
			<div class="col-lg-6 mb-3">
				<canvas id="general_mental_ability_chart"></canvas>
			</div>
			<div class="col-lg-3 mb-3">
				<canvas id="general_mental_ability_level"></canvas>
			</div>
			<div class="col-lg-3 mb-3">
				<span>Kelanjutan Pada Proses Selanjutnya</span>
				<?php if ($data['lanjut']):?>
				<h1><span class="badge badge-success">LANJUT</span></h1>
				<?php else:?>
				<h1><span class="badge badge-secondary">TIDAK</span></h1>
				<?php endif;?>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<h5>Catatan Kualitatif Hasil Test</h5>
			</div>
		</div>

		<?php foreach ($data['catatan_kualitatif'] as $row):?>
		<div class="row">
			<?php foreach ($row as $label => $info):?>
			<div class="col-lg-4 pb-3">
				<label class="text-secondary"><?php echo $label;?></label>
				<div>
					<?php echo $info;?>
				</div>
			</div>
			<?php endforeach;?>
		</div>
		<?php endforeach;?>
	</div>
</div>

<script>
window.chartColors = {
	red: 'rgb(255, 58, 58)',
	orange: 'rgb(255, 159, 64)',
	yellow: 'rgb(255, 205, 86)',
	green: 'rgb(144, 238, 144)',
	dark_green: 'rgb(59, 116, 59)',
	blue: 'rgb(54, 162, 235)',
	purple: 'rgb(153, 102, 255)',
	grey: 'rgb(201, 203, 207)',
	brown: 'rgb(165, 42, 42)',
	light_brown: 'rgb(221, 162, 162)',
	black: 'rgb(0, 0, 0)',
};

var general_mental_ability_chartData = {
	labels: ['Logika Verbal', 'Spatial 2D', 'Working Memory', 'TAQ', 'Spatial 3D', 'Ketelitian Huruf', 'Kemampuan Numerikal'],
	datasets: [{
		label: 'MENTAL AGILITY SCREENING TEST',
		backgroundColor: [
			window.chartColors.red,
			window.chartColors.orange,
			window.chartColors.yellow,
			window.chartColors.green,
			window.chartColors.blue,
			window.chartColors.purple,
			window.chartColors.grey,
		],
		data: [
			126,
			118,
			104,
			98,
			85,
			80,
			72
		],
	}]
}

var general_mental_ability_ctx = document.getElementById('general_mental_ability_chart').getContext('2d');

window.general_mental_ability1 = new Chart(general_mental_ability_ctx, {
	type: 'horizontalBar',
	data: general_mental_ability_chartData,
	options: {
		legend: {
			display: false,
		},
		responsive: true,
		title: {
			display: true,
			text: 'HASIL TEST SELEKSI GENERAL MENTAL AGILITY SCREENING TEST'
		},
		maintainAspectRatio: true,
		animation: {
			onComplete: function(){
				$('#generate_pdf_button').removeClass('disabled');
				picture = window.general_mental_ability1.toBase64Image();
			}
		},
		plugins: {
			datalabels: {
				display: true,
				anchor: 'end',
			},
		},
	},
});

/* DONAT */
general_mental_ability_abilityData = {
    datasets: [{
        data: [<?php echo $data['agility_level'];?>, <?php echo ($data['agility_max'] - $data['agility_level']);?>],
        backgroundColor: [
			window.chartColors.yellow,
			window.chartColors.grey,
		],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'User',
        'Space',
    ]
};

var general_mental_ability_ctx2 = document.getElementById('general_mental_ability_level').getContext('2d');

window.general_mental_ability2 = new Chart(general_mental_ability_ctx2, {
    type: 'doughnut',
    data: general_mental_ability_abilityData,
    options: {
		title: {
			display: true,
			text: 'LEARNING AGILITY LEVEL'
		},
		tooltips: {
			enabled: false,
		},
		legend: {
			display: false,
		},
		rotation: -1.0 * Math.PI, // start angle in radians
		circumference: Math.PI, // sweep angle in radians
	},
	centerText: {
		display: true,
		text: <?php echo $data['agility_level'];?>
	},
	plugins: [{
        beforeDraw: function(chart, options) {
            var width = chart.chart.width,
			height = chart.chart.height,
			ctx = chart.chart.ctx;
		 
			ctx.restore();
			var fontSize = (height / 114).toFixed(2);
			ctx.font = fontSize + "em sans-serif";
			ctx.textBaseline = "middle";
		 
			var text = chart.config.centerText.text,
			textX = Math.round((width - ctx.measureText(text).width) / 2),
			textY = height / 10 * 9;
		 
			ctx.fillText(text, textX, textY);
			ctx.save();
        }
    }]
});
</script>
