<!-- petunjuk -->
<div id="petunjuk">
    <div class="row">
        <div class="col">
            <p>Petunjuk:</p>
            <p>
                Jawaban berupa essay dan jawablah pertanyaan dengan jawaban yang paling sesuai dengan diri Anda. 
            </p>
        </div>
    </div>
</div>
<!-- main -->
<div id="main" style="display: none;">
	<div class="panel-soal">
    	<div class="row" id="soal_container"></div>
	</div>
    <div class="row" id="jawaban_container"></div>
</div>
<div id="soal_clone" style="display: none;">
    <div class="row">
        <div class="col text-center mb-3">
            <h1></h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <textarea class="form-control" rows="7"></textarea>
        </div>
    </div>
</div>
<script>
set_soal = function() {
    row  = quiz_data[index]
    
    $('#soal_container, #jawaban_container').html('')
    
    // Soal
    var clone = $('#soal_clone > div:eq(0) > .col').clone()
    clone.find('h1:eq(0)').text(row.question)
    
    $('#soal_container').append(clone)
    
    // Jawaban
    clone = $('#soal_clone > div:eq(1) > .col').clone()
    clone.find('textarea').data('id', row.id)
    clone.find('textarea').on('keyup change', function(){
        if ($(this).val() != '') {
            simpan_jawaban($(this).data('id'), $(this).val())
        }
        else {
            hide_next_button()
        }
    })
    
    $('#jawaban_container').append(clone)
}

</script>
