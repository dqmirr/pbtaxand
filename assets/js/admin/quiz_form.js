
$(function() {
    $('#pilihanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('pilihan');
        var modal = $(this);
        modal.find('input[name=id]').val(id);

        data = admQuiz.getDataPilihan(id);
        tbody = $('tbody#tb_pilihan');
        tbody.children().remove();
        if(data === undefined) {
            html = admQuiz.setHTMLDefault();
            tbody.append(html);
        } else {
            html = admQuiz.setHTMLPilihan(data)
            tbody.append(html);
        }
    });

    $('#pilihanModal').on('hide.bs.modal', function (event) {
        let text = "Apakah Anda Yakin?";
        if(confirm(text) == true) {
            return true;
        } else {
            return false;
        }
    });

    $('form').on('submit', function() {
        let text = "Apakah Anda Yakin?";
        if(confirm(text) == true) {
            return true;
        } else {
            return false;
        }
    });
});

class AdminQuiz {
    constructor(array) {
        this.param = array;
    }

    getDataPilihan(id) 
    {
        var data = new Array();
		console.log(id)
        $.ajax({
            url: `${this.param.base}/ajax_quiz/get_pilihan`,
            type: 'post',
            data: {id_multi:id},
            dataType: 'json',
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                if(status == 'success') {
                    data = res.data;
                } else {
                    alert(res.message);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        });
        return data;
    }

    setHTMLPilihan(data)
    {
        var html = '';
        data.forEach(function(item, index, arr) {
            var pilihan = '<input type="text" class="form-control m-0" placeholder="Pilihan" name="pilihan[]" value="'+item.choice+'">';
            var label = '<textarea rows="1" style="max-height: 100px; min-height: 38px" class="form-control m-0" placeholder="Label" name="label[]">'+item.label+'</textarea>';
            var del = '<button type="button" class="btn btn-outline-danger btn-sm" onclick="admQuiz.minRow(this)"><span class="oi oi-trash"></span></button>';
            html += '<tr>'
                +'<td>'+(index+1)+'</td>'
                +'<td>'+pilihan+'</td>'
                +'<td>'+label+'</td>'
                +'<td>'+del+'</td>'
            +'</tr>';
        });
        return html;
    }

    setHTMLDefault(num)
    {
        if(!num) {
            var no = 0;
        } else {
            var no = num;
        }

        var pilihan = '<input type="text" class="form-control m-0" placeholder="Pilihan" name="pilihan[]">';
        var label = '<textarea rows="1" style="max-height: 100px; min-height: 38px" class="form-control m-0" placeholder="Label" name="label[]"></textarea>';
        var del = '<button type="button" class="btn btn-outline-danger btn-sm" onclick="admQuiz.minRow(this)"><span class="oi oi-trash"></span></button>';
        var html = '<tr>'
            +'<td>'+(no+1)+'</td>'
            +'<td>'+pilihan+'</td>'
            +'<td>'+label+'</td>'
            +'<td>'+del+'</td>'
        +'</tr>';
        return html;
    }

    addRowPilihan()
    {
        var tbody = $('tbody#tb_pilihan');
        var tr = $('tbody#tb_pilihan tr');
        var html = this.setHTMLDefault(tr.length);
        tbody.append(html);
    }

    minRow(th)
    {
        $(th).parent().parent().remove();
    }

    submitMultiple()
    {
        var form_pilihan = $('form#form_pilihan');
        var dt_form = form_pilihan.serializeArray();
        $.ajax({
            url: `${this.param.base}`+'/ajax_quiz/submit_pilihan',
            type: 'post',
            dataType: 'json',
            data: dt_form,
            timeout: 500,
            success: function(res, status, xhr) {
                alert(res.message);
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        });
        this.reloadPilihan();
    }

    addMultiple(code)
    {
        var td = $("table#table_multi tbody tr td");
        if(td.data('elm') == 0) {
            $(td).parent().remove();
        }
        var elm = this.elementMultiple(code);
        $("table#table_multi tbody").append(elm);
    }

    elementMultiple(code)
    {
        var inpId = '<input type="hidden" name="id[]">';
        var inpSoal = '<input type="text" class="form-control" name="jenis_soal[]" value="'+code+'" readonly>';
        var inpNomor = '<input type="number" class="form-control col-sm-7" name="nomor[]" placeholder="Nomor">';
        var inpSulit = '<input type="number" class="form-control" name="sulit[]" placeholder="Sulit">';
        var inpQues = '<textarea class="form-control" name="question[]" placeholder="Question"></textarea>';
        var inpImg = '<input type="text" class="form-control" name="multi_img[]" placeholder="Multiplechoice img code">';
        var btnTrash = '<button type="button" class="btn btn-sm btn-outline-danger" onclick="admQuiz.minRow(this)"><span class="oi oi-trash"></span></button>';
        var html =  '<tr>'
            +'<td>'+inpId+inpSoal+'</td>'
            +'<td>'+inpNomor+'</td>'
            +'<td>'+inpSulit+'</td>'
            +'<td>'+inpQues+'</td>'
            +'<td>'+inpImg+'</td>'
            +'<td></td>'
            +'<td align="center">'+btnTrash+'</td>'
        +'</tr>';
        return html;
    }

    reloadPilihan()
    {
        var form_pilihan = $('form#form_pilihan');
        var id = form_pilihan.find('input[name=id]').val();
        data = this.getDataPilihan(id);
        tbody = $('tbody#tb_pilihan');
        tbody.children().remove();

        if(data === undefined) {
            html = this.setHTMLDefault();
        } else {
            html = this.setHTMLPilihan(data);
        }

        tbody.slideUp('slow');
        tbody.append(html);
        tbody.show('slow');
    }

}

