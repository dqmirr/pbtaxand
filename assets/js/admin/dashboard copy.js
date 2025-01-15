
function format(data)
{
    var tr = '';
    $.each(data.quiz, function(key, val) {
        tr += '<tr>'+
            '<td>'+(key+1)+'</td>'+
            '<td align="left">'+val.label+'</td>'+
            '<td>Selesai</td>'+
        '</tr>';
    });
    var table = '<table cellpadding="0" cellspacing="0" border="0" style="width: 93% !important;" class="tb_detail">'+
        '<th>No</th>'+
        '<th>Quiz</th>'+
        '<th>Status</th>'+
        tr+
    '</table>';
    return table;
}

$(function() {

    const pieElm = document.getElementById('myChart_123');
    const pieChart = new Chart(pieElm, {
        type: 'pie',
        data: { 
            labels: ['Belum','Selesai','Proses'],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                  'rgb(255, 99, 132)',
                  'rgb(54, 162, 235)',
                  'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            legend: {
               display: false 
            }
         }
    });


    
    // var html = dashboard.setTableHtml(dataUser);
    // $('#data_users').append(html);
    // $('#data_users').DataTable({
    //     scrollX: true,
    //     scrollY: 260,
    //     paging: false,
    //     info: false,
    //     searching: false,
    //     data: false
    // });

    // $('#data_users').on('click', 'td.details-control', function() {    
    //     var id = $(this).data('id');
    //     var tr = $(this).closest('tr');
    //     var tr_detail = $('#data_users tr.detail-'+id);
    //     var tr_shown = $(this).hasClass('shown-'+id);
        
    //     if(tr_shown == false) {
    //         tr_detail.show();
    //         tr.addClass('shown')
    //         $(this).addClass('shown-'+id);
    //     } else {
    //         tr_detail.hide();
    //         tr.removeClass('shown')
    //         $(this).removeClass('shown-'+id);
    //     }
    // });



    // var dataUser = dashboard.getDataUser();
    // var tab = $('#data_users').DataTable({
    //     scrollX: true,
    //     scrollY: 260,
    //     paging: false,
    //     info: false,
    //     searching: false,
    //     data: dataUser,
    //     columns: [
    //         { data: 'no' },
    //         { data: 'fullname' },
    //         { data: 'formasi' },
    //         { data: 'jml_quiz' },
    //         { data: 'status' },
    //         {
    //             className: 'dt-control',
    //             orderable: false,
    //             data: 'no',
    //             defaultContent: '',
    //             render: function(data, type, row, meta) {
    //                 return '';
    //             }
    //         },
    //     ],
    //     columnDefs: [{
    //         targets: 5,
    //         createdCell: function(td, cellData, rowData, row, col) {
    //                 $(td).addClass('shown-'+rowData.no);
    //                 $(td).attr('data-id', rowData.no);
    //             }
    //         }
    //     ]
    // });

    // $('#data_users').on('click', 'td.dt-control', function () {
    //     var tr = $(this).closest('tr');
    //     var row = tab.row(tr);
 
    //     if (row.child.isShown()) {
    //         row.child.hide();
    //         tr.removeClass('shown');
    //     } else {
    //         console.log(row.data());
    //         row.child(format(row.data())).show();
    //         tr.addClass('shown');
    //     }
    // });

    var dataUser = dashboard.getDataUser();
    dashboard.setDataTable(dataUser);
    // console.log(dataUser);

    

})

class Dash {
    constructor(param) {
        this.base = param.base;
        this.code = param.code;
    }
    
    getDataUser2(code)
    {
        if(!code) {
            var codeSesi = this.code;
        } else {
            var codeSesi = code;
        }

        var data = new Array();
        $.ajax({
            url: `${this.base}`+'/ajax_dashboard/getdata_user',
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
    
    getDataUser(code)
    {
        if(!code) {
            var codeSesi = this.code;
        } else {
            var codeSesi = code;
        }

        var data = new Array();
        $.ajax({
            url: `${this.base}`+'/ajax_dashboard/get_userquiz',
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
        $.each(data, function(key, val) {
            var detail_tr = '';
            if(val.jml_quiz > 0) {
                $.each(val.quiz, function(key2, val2) {
                    detail_tr += '<tr>'+
                        '<td>'+(key2+1)+'</td>'+
                        '<td align="left">'+val2.label+'</td>'+
                        '<td>Selesai</td>'+
                    '</tr>';
                });
                var detail = '<table cellpadding="0" cellspacing="0" border="0" style="width: 100% !important" class="tb_detail">'+
                    '<th>No</th>'+
                    '<th>Quiz</th>'+
                    '<th>Status</th>'+detail_tr+'</table>';
                
                tr += '<tr>'+
                    '<td>'+(key+1)+'</td>'+
                    '<td>'+val.fullname+'</td>'+
                    '<td>'+val.formasi+'</td>'+
                    '<td>'+val.jml_quiz+'</td>'+
                    '<td>'+val.status+'</td>'+
                    '<td class="details-control shown-'+(key+1)+'" data-id="'+(key+1)+'"></td>'+
                '</tr>'+
                '<tr class="detail-'+(key+1)+'">'+
                    '<td></td>'+
                    '<td colspan="5">'+detail+'</td>'+
                '</tr>';
            } else {
                tr += '<tr>'+
                    '<td>'+(key+1)+'</td>'+
                    '<td>'+val.fullname+'</td>'+
                    '<td>'+val.formasi+'</td>'+
                    '<td>'+val.jml_quiz+'</td>'+
                    '<td>'+val.status+'</td>'+
                    '<td class="details-control"></td>'+
                '</tr>';
            }
        });
        return tr;
    }




    viewUser(th)
    {
        var code = $(th).data('code');
        var data = this.getDataUser(code);
        this.setDataTable(data);
    }


    setDataTable(data) 
    {
        $('#data_users').slideUp('fast');
        $('#data_users').DataTable().destroy();
        $('#data_users tbody tr').remove();
        if(data) {
            this.configDataTable(data);
        } else {
            this.configDataTable();
        }
        $('#data_users').slideDown();
        // console.log(data);
    }

    configDataTable(data)
    {
        var tab = $('#data_users').DataTable({
            scrollX: true,
            scrollY: 260,
            paging: false,
            info: false,
            searching: false,
            data: data,
            columns: [
                { data: 'no' },
                { data: 'fullname' },
                { data: 'formasi' },
                { data: 'jml_quiz' },
                { data: 'status' },
                {
                    className: 'dt-control',
                    orderable: false,
                    data: 'no',
                    defaultContent: '',
                    render: function(data, type, row, meta) {
                        return '';
                    }
                },
            ],
            columnDefs: [{
                targets: 5,
                createdCell: function(td, cellData, rowData, row, col) {
                        $(td).addClass('shown-'+rowData.no);
                        $(td).attr('data-id', rowData.code);
                    }
                }
            ]
        });
    
        $('#data_users').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = tab.row(tr);
            var code = $(this).data('id');
            console.log(code);
     
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                var datas = dashboard.getDataUser(code);
                // console.log(row.data());
                row.child(format(datas)).show();
                tr.addClass('shown');
            }
        });
    }


    getDetail(user)
    {
        var data = new Array();
        $.ajax({
            url: `${this.base}`+'/ajax_dashboard/get_detail',
            type: 'post',
            data: {user_id:user},
            dataType: 'json',
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
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
        // console.log(user);
    }
    
}