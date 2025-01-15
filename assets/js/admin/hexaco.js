$(function() {
    hex.setChart();

    $('#detailModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var fullname = button.data('user');
        var modal = $(this);
        
        modal.find('.modal-title').text('Detail Hexaco - '+fullname);
        hex.setChildBar(id);
    });
})

class hexaco {
    constructor(param) {
        this.base = param.base;
        this.code = param.code;
    }

    getDataRadar(user)
    {
        var data = new Array();
        $.ajax({
            url: `${this.base}/ajax_psycogram/data_radar`,
            type: 'post',
            dataType: 'json',
            data: {data:user},
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                // console.log(res);
                if(status == 'success') {
                    data = res.data;
                } else {
                    data = null;
                    alert(res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        });
        return data;
    }

    getDataUser(code)
    {
        if(!code) {
            var codeSesi = this.code;
        } else {
            var codeSesi = code;
        }

        var data = new Array();
        $.ajax({
            url: `${this.base}/ajax_psycogram/get_usersbysesi`,
            type: 'post',
            data: {code_sesi:codeSesi},
            dataType: 'json',
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                // console.log(res);
                if(status == 'success') {
                    data = res.data;
                } else {
                    data = null;
                    alert(res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        });
        return data;
    }

    setChart()
    {
        var data = this.getDataUser();
        var set = this.getDataRadar(data);

        $.each(set, function(key, val) {
            var elm = 'radar_'+val['id'];
            hex.configRadar(elm, val['grafik']);
        });
    }

    configRadar(elm, data)
    {
        const radarChart = new Chart(elm, {
            type: 'radar',
            data: {
                labels: [
                    'Honesty-Humility',
                    'Emotionality',
                    'eXtroversion',
                    'Agreeableness',
                    'Conscien-tiousness',
                    'Openness'
                ],
                datasets: data
            },
            options: {
                elements: {
                  line: { borderWidth: 2 }
                },
                responsive: true,
                legend: {
                    labels: {
                        padding: 2,
                        fontSize: 10,
                    },
                },
                scale: {
                    display: true,
                    angleLines: {
                        display: true
                    },
                    pointLabels:{
                        fontSize: 11,
                        fontColor: 'black',
                        fontStyle: 'bold',
                        callback: function(value, index, values) {
                          return value;
                        }
                    },
                    ticks: {
                        suggestedMin: 0,
                        suggestedMax: 100,
                        stepSize: 20,
                        maxTicksLimit: 10,
                        display: true,
                        callback: function(value, index, values) {
                            return value+'%';
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            // return context.chart.data.labels[context.value];
                            return '';
                        }
                    },
                    filler: {
                        propagate: false
                    },
                    'samples-filler-analyser': {
                      target: 'chart-analyser'
                    },
                },
                interaction: {
                    intersect: false
                }
                
            },
        });
    }

    getChildBar(user)
    {
        var data = new Array();
        $.ajax({
            url: `${this.base}/ajax_psycogram/child_bar`,
            type: 'post',
            dataType: 'json',
            data: {data:user},
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                // console.log(res);
                if(status == 'success') {
                    data = res.data;
                } else {
                    data = null;
                    alert(res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        });
        return data;
    }

    setChildBar(user)
    {
        var data = this.getChildBar(user);
        $.each(data, function(key, val) {
            var idElm = key.toLowerCase();
            var text = '('+val['head']+'%)';
            $('#nilai-'+idElm).text(text);
            var elmBar = 'bar-'+idElm;
            var setData = val['grafik'];
            hex.configChildBar(elmBar, setData);
        })
    }
	
	barChart = {}
    configChildBar(elm, data)
    {
		if(this.barChart[elm] != null || this.barChart[elm] != undefined){
			this.barChart[elm].destroy();
		}

        this.barChart[elm] = new Chart(elm, {
            type: 'horizontalBar',
            data: data,
            options: {
                legend: {
                    display: false
                },
                responsive: true,
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            return value+'%';
                        }
                    }
                },
                scales: {
                    yAxes: [{
                        afterFit: function(scaleInstance) {
                            scaleInstance.width = 140;
                          }
                    }],
                    xAxes: [{
                        ticks: {
                            suggestedMax: 100,
                            beginAtZero: true,
                            stepSize: 25,
                            callback: function(value, index, values) {
                                return value+'%';
                            }
                        },
                        stacked: true
                    }]
                }
            }
        });
    }
}
