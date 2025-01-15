$(function() {
    $('#detailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var fullname = button.data('user');
        var modal = $(this);

        modal.find('.modal-title').text('Detail DISC - '+fullname);
        setChartModal(id);
		// event.preventDefault();
    });
})


function setChartModal(id)
    {
        var data = disc.findData(id);
        var dataDisc = data.disc;
        var changeDisc = [
            dataDisc.c_disc.segment_16_list.D,
            dataDisc.c_disc.segment_16_list.I,
            dataDisc.c_disc.segment_16_list.S,
            dataDisc.c_disc.segment_16_list.C,
        ];
        var leastDisc = [
            dataDisc.l_disc.segment_16_list.D,
            dataDisc.l_disc.segment_16_list.I,
            dataDisc.l_disc.segment_16_list.S,
            dataDisc.l_disc.segment_16_list.C
        ];
        var mostDisc = [
            dataDisc.m_disc.segment_16_list.D,
            dataDisc.m_disc.segment_16_list.I,
            dataDisc.m_disc.segment_16_list.S,
            dataDisc.m_disc.segment_16_list.C,
        ];

        
		$('#chartMost').remove();
		$('#chartLeast').remove();
		$('#chartChange').remove();
		$("#chart-container-most").append('<canvas id="chartMost" height="400"></canvas>');
		$("#chart-container-least").append('<canvas id="chartLeast" height="400"></canvas>');
		$("#chart-container-change").append('<canvas id="chartChange" height="400"></canvas>');
        let ctxMost = document.getElementById("chartMost").getContext("2d");
		let ctxLeast = document.getElementById("chartLeast").getContext("2d");
        let ctxChange = document.getElementById("chartChange").getContext("2d");
        configChartModal(ctxMost, 'Most', mostDisc);
        configChartModal(ctxLeast, 'Least', leastDisc);
        configChartModal(ctxChange, 'Change', changeDisc);
    }

function configChartModal(elm, label, data)
{
	const chartModal = new Chart(elm, {
		type: 'line',
		data: {
			labels: ['D','I','S','C'],
			datasets: [{
				label: label,
				data: data,
				borderColor: 'rgb(254,162,7, 0.5)',
				borderWidth: 8,
				backgroundColor: 'rgb(254,162,7, 0.1)',
				fill: false,
				pointBackgroundColor: 'rgb(254,162,7, 0.5)',
				pointBorderWidth: 0,
			}]
		},
		options: {
			scales: {
				yAxes: [{ 
					ticks: {
						min: -8, 
						max: 8,
					}
				}]
			},
			legend: {
				padding: 20
			},
			elements: {
				line: {
					tension: 0,
				}
			},
			plugins: {
				datalabels: {
					anchor: 'end',
					align: 'bottom',
					font: {
						size: 16,
					},
					formatter: function(value, context) {
						return value;
					}
				}
			}
		}
	});
}

class discJs {
	chartModal = null;
    constructor(param) {
        this.base = param.base;
        this.code = param.code;
        this.data = param.data;
    }

    findData(parID)
    {
        var dataUser = this.data;
        var finder = new Array();
        dataUser.find((value, index) => {
            if(value.id == parID) {
                finder = value;
            }
        });
        return finder;
    }
    
}
