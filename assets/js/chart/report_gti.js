var ReportGTI = function (result) {
	const {meta:{ keterangan_warna }, data} = result;
	function colorRange(value){
		keterangan_warna.sort((a,b)=>{
			if(a.value > b.value){
				return -1;
			}else if(a.value < b.value){
				return 1;
			}else{
				return 0;
			}
		});
		const warna = keterangan_warna.find(item => {
			if(value >= parseInt(item.value)){
				return item;
			}
		});
		return warna.color;
	}
	$(document).ready(function(){
		const config = {
			maximum: 140
		}
	
		const ctx = document.querySelector('#report_gti').getContext('2d');
		const myChart = new Chart(ctx, {
			type: 'bar',
			data: {
					labels: ['Speed 6 Accuracy', 'Reasoning', 'Focus & Attention', 'Numberical Ability', 'Technical Problem'],
					datasets: [{
							data: [
								data["letter_checking"]||0, 
								data["reasoning"]||0, 
								data["letter_distance"]||0, 
								data["number_distance"]||0, 
								data["spatial_oriantation"]||0,
							],
							backgroundColor:function(context) {
								const index = context.dataIndex;
								const value = context.dataset.data[index];
								return colorRange(value);
								
							},
					}]
			},
			options: {
				indexAxis: 'y',
				scales: {
						x: {
								beginAtZero: true,
								max: config['maximum'],
						}
				},
				plugins: {
					legend: {
						display:false,
						labels:{
							color:'#00ff00'
						}
					},
				}
			}
	});
	
	})
}
