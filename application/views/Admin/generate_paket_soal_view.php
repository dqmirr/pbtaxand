<h4 class="my-3"><?php echo $title;?></h4>
<?php if ($error != ''):?>
<div class="alert alert-danger"><?php echo $error;?></div>
<?php endif;?>
<div class="row">
    <div class="col">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Quiz Code</th>
                    <th>Quiz Label</th>
                    <th class="text-center">Paket Soal Quiz</th>
                    <th class="text-center">Paket Soal Tutorial</th>
                    <th>Generate</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($arr_quiz as $row):?>
                <tr>
                    <td>
                        <?php echo $row->code;?>
                        <a name="<?php echo $row->code;?>"></a>
                    </td>
                    <td><?php echo $row->label;?></td>
                    <td class="text-center" id="<?php echo $row->code;?>_total_quiz"><?php echo $row->jumlah_quiz;?></td>
                    <td class="text-center" id="<?php echo $row->code;?>_total_tutorial"><?php echo $row->jumlah_tutorial;?></td>
                    <td>
						<?php if(property_exists($row, 'href')): ?>
							<a href="<?=site_url($admin_url.$row->href) ?>" class="btn btn-primary generate_button">Generate</a>
						<?php else: ?>
							<button type="button" name="code" value="<?php echo $row->code;?>" class="btn btn-primary generate_button">Generate</button>
						<?php endif; ?>
                    </td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function(){
    $('.generate_button').on('click', function(){
        $.ajax({
            data: {code: $(this).val()},
            dataType: 'json',
            error: function(){
                alert('An Error Occured')
            },
            success: function(data) {
                if (data.error) {
                    alert(data.msg)
                }
                else {
                    $('#'+data.code+'_total_quiz').html(data.total_quiz)
                    $('#'+data.code+'_total_tutorial').html(data.total_tutorial)
                }
            },
            type: 'POST',
            url: '<?php echo site_url($admin_url.'/ajax_generate_paket_soal');?>'
        })
    })
})
</script>
