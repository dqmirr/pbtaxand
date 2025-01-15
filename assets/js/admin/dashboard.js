


$(function() {
    var data = dashboard.getDataUser();
    var html = dashboard.setTableHtml(data);
    dashboard.appendTable(html);
    $('#header_users').text('User '+dashboard.sesiName());

    $('#data_users').on('click', 'td.dt-control', function() {    
        var id = $(this).data('id');
        var tr = $(this).closest('tr');
        var tr_detail = $('#data_users tr.detail-'+id);
        var tr_shown = $(this).hasClass('shown-'+id);
        
        if(tr_shown == false) {
            tr_detail.show();
            tr.addClass('shown')
            $(this).addClass('shown-'+id);
        } else {
            tr_detail.hide();
            tr.removeClass('shown')
            $(this).removeClass('shown-'+id);
        }
    });

    dashboard.setChart();
})

class Dash {
    constructor(param) {
        this.base = param.base;
        this.code = param.code;
        this.tahun = param.tahun;
        this.sesi = param.sesi;
    }

    sesiName()
    {
        return this.sesi;
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
            url: `${this.base}/ajax_dashboard/get_userquiz`,
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

    setTableHtml(data)
    {
        var tr = '';
        if(data === undefined) {
            tr = '<tr>'+
                '<td colspan="6">Tidak ada data</td>'+
            '</tr>';
        } else {
            $.each(data, function(key, val) {
                var detail_tr = '';
                if(val.jml_quiz > 0) {
                    $.each(val.quiz, function(key2, val2) {
                        detail_tr += '<tr>'+
                            '<td>'+(key2+1)+'</td>'+
                            '<td align="left">'+val2.label+'</td>'+
                            '<td><span class="badge '+val2.badge+'">'+val2.status+'</span></td>'+
                        '</tr>';
                    });
                    var detail = '<table cellpadding="0" cellspacing="0" border="0" style="width: 100% !important" class="tb_detail">'+
                        '<th>No</th>'+
                        '<th>Quiz</th>'+
                        '<th>Status</th>'+detail_tr+'</table>';
                    
                    tr += '<tr class="shown">'+
                        '<td>'+(key+1)+'</td>'+
                        '<td>'+val.fullname+'</td>'+
                        '<td>'+val.formasi+'</td>'+
                        '<td>'+val.jml_quiz+'</td>'+
                        '<td>'+val.status+'</td>'+
                        '<td class="dt-control shown-'+val.id+'" data-id="'+val.id+'"></td>'+
                    '</tr>'+
                    '<tr class="detail-'+val.id+'">'+
                        '<td></td>'+
                        '<td colspan="5" class="detail">'+detail+'</td>'+
                    '</tr>';
                } else {
                    tr += '<tr>'+
                        '<td>'+(key+1)+'</td>'+
                        '<td>'+val.fullname+'</td>'+
                        '<td>'+val.formasi+'</td>'+
                        '<td>'+val.jml_quiz+'</td>'+
                        '<td>'+val.status+'</td>'+
                        '<td></td>'+
                    '</tr>';
                }
            });
        } 
        return tr;
    }

    appendTable(html)
    {
        $('#data_users').slideUp('fast');
        $('table#data_users tbody tr').remove();
        setTimeout(function() {
            $('table#data_users tbody').append(html);
        }, 600);
        $('#data_users').slideDown();
    }

    viewUser(th)
    {
        var text = $(th).text();
        var code = $(th).data('code');
        var data = this.getDataUser(code);
        var html = this.setTableHtml(data);
        this.appendTable(html);
        $('#header_users').text('User '+text);
    }

    getListID(tahun)
    {
        if(!tahun) {
            var thn = this.tahun;
        } else {
            var thn = tahun;
        }

        var data = new Array();
        $.ajax({
            url: `${this.base}/ajax_dashboard/get_list`,
            type: 'post',
            data: {tahun:thn},
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
        var data = this.getListID();
        $.each(data, function(key, val) {
            var elm = 'myChart_'+val['code'];
            var set = val['chart'];
            var dou = 'doug_'+val['code'];
            dashboard.configPieChart(elm, set);
            dashboard.configDoughnut(dou, set);
        });
    }

    configPieChart(elm, dataset)
    {
        const pieChart = new Chart(elm, {
            type: 'pie',
            data: { 
                labels: ['Belum','Proses','Selesai'],
                datasets: [{
                    label: 'My First Dataset',
                    data: dataset,
                    backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 205, 86)',
                    'rgb(54, 162, 235)'
                    ],
                    hoverOffset: 14
                }]
            },
            options: {
                responsive: true,
                legend: { 
                    display: false 
                },
                plugins: {
                    tooltip: {
                        enabled: false
                    }
                }
            }
        });
    }

    configDoughnut(elm, dataset)
    {
        const pieChart = new Chart(elm, {
            type: 'doughnut',
            data: { 
                labels: ['Belum','Proses','Selesai'],
                datasets: [{
                    borderWidth: 0,
                    showLine: false,
                    data: dataset,
                    hoverOffset: 1,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(255, 205, 86)',
                        'rgb(54, 162, 235)'
                    ],
                }]
            },
            options: {
                maintainAspectRatio: true,
                responsive: true,
                legend: { 
                    display: false,
                },
                tooltips: {
                    enabled: false,
                },
                plugins: {
                    datalabels: {
                        display: false
                    }
                }
            },
        }); 
    }

    detail(th)
    {
        var code = $(th).data('code');
        $('#detail_'+code).slideToggle();
        setTimeout(function() {
            $(th).toggleClass('dt-hide');
        }, 400);
    }
}
