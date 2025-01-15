



<div class="card mt-4">
    <div class="card-header">
        <b>Soal Multiplechoice</b>
    </div>
    <div class="card-body" style="padding: 0 !important;">
        <table class="table table-bordered mb-0" id="table_multi">
            <thead>
                <tr>
                    <th width="120">Jenis Soal</th>
                    <th width="150">Nomor</th>
                    <th width="150">Sulit</th>
                    <th>Question</th>
                    <th>Multiplechoice img code</th>
                    <th width="110">Jawaban</th>
                    <?php if($this->uri->segment(3) != 'view') { ?>
                    <th width="60">Action</th>
                    <?php } ?>
                </tr>
            </thead>


            

            <?php 
            $dt_multiple = $form['soal']['multiple']['data'];
            $jml = count($dt_multiple);
            if($this->uri->segment(3) === 'view') { 
                echo "<tbody>";
                if($jml > 0) {
                    foreach($dt_multiple as $key => $val) { 
                        ?>
                        <tr>
                            <td><?=$val['jenis_soal']?></td>
                            <td><?=$val['nomor']?></td>
                            <td><?=$val['sulit']?></td>
                            <td><?=$val['question']?></td>
                            <td><?=$val['multiple_img_code']?></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="5" align="center">Tidak ada data</td>
                    </tr>
                    <?php
                }
                echo "</tbody>";
            } else {
                echo "<tbody>";
                $code = $form['quiz']['data']['code'];
                if($jml > 0) {
                    foreach($dt_multiple as $key => $val) { 
                        ?>
                        <tr>
                            <td>
                                <?=$val['jenis_soal']?>
                                <input type="hidden" name="id[]" value="<?=$val['id']?>">
                            </td>
                            <td>
                                <input type="number" class="form-control col-sm-7" name="nomor[]" value="<?=$val['nomor']?>">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="sulit[]" value="<?=$val['sulit']?>">
                            </td>
                            <td>
                                <textarea class="form-control" name="question[]"><?=$val['question']?></textarea>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="multi_img[]" value="<?=$val['multiple_img_code']?>">
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#pilihanModal" data-pilihan="<?=$val['id']?>">Edit Pilihan</button>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-sm btn-outline-danger" data-id="<?=$val['id']?>" onclick="admQuiz.minRow(this)">
                                    <span class="oi oi-trash"></span>
                                </button>
                            </td>
                        </tr>
                        <?php
                    } 
                } else { 
                    ?>
                    <tr>
                        <td colspan="7" align="center" data-elm="0">Tidak ada Data</td>
                    </tr>
                    <?php
                } 
                ?>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="border-right: 0"></td>
                        <td align="center" style="border-left: 0">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="admQuiz.addMultiple('<?=$code?>')">
                                <span class="oi oi-plus"></span>
                            </button>
                        </td>
                    </tr>
                </tfoot>

            <?php } ?>
        </table>
    </div>
</div>