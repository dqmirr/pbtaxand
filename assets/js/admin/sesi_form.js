// const tagify = require("../../tagify/tagify");


$(function() {
    $('#pesertaModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var code = button.data('code');
        var expaired = button.data('expaired');
        var modal = $(this);
        modal.find('input[name=id]').val(code);
        modal.find('textarea#val_peserta').attr('data-code', code);
        var btn_submit = modal.find('button#btn_submit');
        btn_submit.attr('disabled', false);

        if(expaired != '1') {
            btn_submit.remove();
        } else {
            btn_submit.remove();
            modal.find('.modal-footer').append(admSesi.buttonSubmit());
        }

        var dataPeserta = admSesi.getAllPeserta();
        var inputElm = document.querySelector('textarea[name=users]');
        var valPeserta = admSesi.getDataPeserta(code);

        // suggestionItemTemplate(inputElm);
        var tagify = new Tagify(inputElm, {
            keepInvalidTags: true,
            dropdown: {
                closeOnSelect: true,
                enabled: 0,
                maxItems: 20,
                classname: 'users-list',
                searchKeys: ['fullname','username'],
                highlightFirst: true
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
            whitelist: dataPeserta,
            originalInputValueFormat: valuesArr => valuesArr.map(item => item.value).join(',')
        })
        
        
        if(valPeserta.length > 0) {
            tagify.removeAllTags();
            tagify.addTags(valPeserta);
        } else {
            tagify.removeAllTags();
        }
        
    });

    function tagTemplate(tagData){
        return `<tag title="${tagData.username}"
                    contenteditable='false'
                    spellcheck='false'
                    tabIndex="-1"
                    class="tagify__tag ${tagData.class ? tagData.class : ""}"
                    ${this.getAttributes(tagData)}>
                <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                <div>
                    <span class='tagify__tag-text'>${tagData.fullname}</span>
                </div>
            </tag>`
    }

    function suggestionItemTemplate(tagData){
        return `<div ${this.getAttributes(tagData)}
                class='tagify__dropdown__item ${tagData.class ? tagData.class : ""}'
                tabindex="0"
                role="option">
                    <b>${tagData.fullname}</b>
                    <div class='text-right'>${tagData.username}</div>
            </div>`
    }

    $('a#btn_delete').on('click', function(event) {
        var button = $(event.currentTarget);
        var code = button.data('code');
        let text = "Apakah Anda Yakin akan menghapus "+code+"?";
        if(confirm(text) == true) {
            return true;
        } else {
            return false;
        }
    });

    $("form#sesi_form").validate({
        rules: {
            code: 'required',
            label: 'required',
            time_from: 'required',
            time_to: 'required'
        },
        errorElement: 'span',
        submitHandler: function(form) { 
            var path = window.location.pathname.split('/');
            var method = path[3];
            var code = $('input[name=code]').val();
            var valid;
            if(method == 'add') {
                var valid = admSesi.validCodeAdd(code);
            } else {
                var code_ori = $('input[name=code_ori').val();
                var valid = admSesi.validCodeEdit(code_ori, code);
            }

            if(valid['status'] == false) {
                var parent = $('input[name=code]').parent();
                var msg = valid['message'];
                admSesi.customValidMsg(parent, msg);
            } else {
                let text = "Apakah Anda Yakin?";
                if(confirm(text) == true) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    });
});




class AdminSesi 
{
    constructor(array) {
        this.param = array;
    }

    getDataPeserta(code) 
    {
        var data = new Array();
        $.ajax({
            url: `${this.param.base}/ajax_sesi/get_val_peserta_for_tags`,
            type: 'post',
            data: {code_sesi:code},
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

    getAllPeserta()
    {
        var data = new Array();
        $.ajax({
            url: `${this.param.base}/ajax_sesi/get_all_peserta_for_tags`,
            type: 'post',
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
        })
        return data;
    }

    validateUsername(username) 
    {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(username)
    }

    parseFullValue(value) 
    {
        var parts = value.split(/<(.*?)>/g),
            fullname = parts[0].trim(),
            username = parts[1]?.replace(/<(.*?)>/g, '').trim();
    
        return {fullname, username}
    }

    submitPeserta()
    {
        var form_pilihan = $('form#form_peserta');
        var dt_form = form_pilihan.serializeArray();
        $.ajax({
            url: `${this.param.base}/ajax_sesi/submit_peserta`,
            type: 'post',
            dataType: 'json',
            data: {form:dt_form},
            success: function(res, status, xhr) {
                alert(res.message);
                if(status == 'success') {
                    $('#pesertaModal button#btn_submit').attr('disabled',true);
                    admSesi.afterSubmit(res.data);
                }
            },
            error: function(jqXhr, textStatus, errorMessage) {
                alert(errorMessage);
            }
        })
    }

    afterSubmit(code)
    {
        var dt = admSesi.getDataPeserta(code);
        $('button[data-code="'+code+'"]').text(dt.length+' Peserta');
        $('textarea#val_peserta').val('');
        setTimeout(function() {
            $('textarea#val_peserta').val(JSON.stringify(dt)); 
        },100);
        setTimeout(function() {
            $('#pesertaModal').modal('toggle');
        },1000);
        setTimeout(function() {
            window.location = 'sesi';
        },1400);
    }

    buttonSubmit()
    {
        return `<button type="button" id="btn_submit" class="btn btn-primary btn-submit" onclick="admSesi.submitPeserta()">Simpan</button>`;
    }

    validCodeAdd(code) 
    {
        var data = new Array();
        $.ajax({
            url: `${this.param.base}/ajax_sesi/valid_code_add`,
            type: 'post',
            data: {val:code},
            dataType: 'json',
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                if(status == 'success') {
                    data = res;
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

    validCodeEdit(original, new_code)
    {
        var data = new Array();
        $.ajax({
            url: `${this.param.base}/ajax_sesi/valid_code_edit`,
            type: 'post',
            data: {
                ori: original,
                new: new_code,
            },
            dataType: 'json',
            async: false,
            timeout: 500,
            success: function(res, status, xhr) {
                if(status == 'success') {
                    data = res;
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

    customValidMsg(parent, msg)
    {
        var elm = `<span class="error">`+msg+`</span>`;
        $(parent).find('span').remove();
        parent.append(elm);
    }
}



