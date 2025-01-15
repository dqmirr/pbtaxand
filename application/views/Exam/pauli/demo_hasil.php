<script src="<?php echo base_url('assets/js/Chart.bundle.min.js');?>"></script>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#grafikModal">
  Lihat Grafik
</button>

<!-- Modal -->
<div class="modal fade" id="grafikModal" tabindex="-1" role="dialog" aria-labelledby="grafikModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Grafik Pauli</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	    <canvas id="canvas"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
	$(body).append($('#grafikModal'))
	
	var chartColors = {
		red: 'rgb(255, 99, 132)',
		orange: 'rgb(255, 159, 64)',
		yellow: 'rgb(255, 205, 86)',
		green: 'rgb(75, 192, 192)',
		blue: 'rgb(54, 162, 235)',
		purple: 'rgb(153, 102, 255)',
		grey: 'rgb(201, 203, 207)'
	};

	var chartData = {
		labels: <?php echo json_encode($labels);?>,
		datasets: [{
			type: 'line',
			label: 'Salah',
			borderColor: chartColors.red,
			borderWidth: 2,
			fill: false,
			data: <?php echo json_encode($salah);?>,
		}, {
			type: 'bar',
			label: 'Benar',
			backgroundColor: chartColors.blue,
			data: <?php echo json_encode($benar);?>,
			borderColor: 'white',
			borderWidth: 2
		}]
	}
	
	var ctx = document.getElementById('canvas').getContext('2d');
	var myMixedChart = new Chart(ctx, {
		type: 'bar',
		data: chartData,
		options: {
			responsive: true,
			title: {
				display: true,
				text: 'Grafik Pauli'
			},
			tooltips: {
				mode: 'index',
				intersect: true
			}
		}
	});
})
</script>
