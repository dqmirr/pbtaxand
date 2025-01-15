

<?php
if($this->uri->segment(3) != 'edit') {
    ?>
    <div class="card">
        <div class="card-body row">
            <div class="col">
            
                <div class="mb-2 row">
                    <label for="code"
                        class="col-sm-3 col-form-label">
                        Code
                    </label>
                    <div class="col-sm-7">
                        <input type="text"
                            class="form-control"
                            name="code">
                        <?=form_error('code');?>
                    </div>
                    
                </div>

                <div class="mb-2 row">
                    <label for="lib_code"
                        class="col-sm-3 col-form-label">
                        Library Code
                    </label>
                    <div class="col-sm-7">
                        <select class="form-control" name="lib_code">
                            <option value="">Pilih Library Code</option>
                            <?=select_html($form['lib_code']['data'], 'code', 'code', $form['quiz']['data']['library_code'])?>
                        </select>
                        <?=form_error('lib_code');?>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="group_quiz_code"
                        class="col-sm-3 col-form-label">
                        Group Quiz Code
                    </label>
                    <div class="col-sm-7">
                        <select class="form-control" name="group_quiz_code">
                            <option value="">Pilih Group Quiz Code</option>
                            <?=select_html($form['sub_lib']['data'], 'code', 'code', $form['quiz']['data']['group_quiz_code'])?>
                        </select>
                        <?=form_error('group_quiz_code');?>
                    </div>
                </div>

				<div class="mb-2 row">
					<label for="is_show"
                        class="col-sm-3 col-form-label">
                        Is Show
                    </label>
                    <div class="col-sm-7">
						<div class="form-check form-switch float-left">
							<input class="form-check-input" type="checkbox" id="is_show" name="is_show" <?=checked_html(intval($form['quiz']['data']['is_show']))?>>
						</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="mb-2 row">
                    <label for="label"
                        class="col-sm-2 col-form-label">
                        Label
                    </label>
                    <div class="col-sm-8">
                        <input type="text"
                            class="form-control"
                            name="label">
                        <?=form_error('label');?>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="desc"
                        class="col-sm-2 col-form-label">
                        Description
                    </label>
                    <div class="col-sm-8">
                        <textarea class="form-control"
                            name="desc"></textarea>
                        <?=form_error('desc');?>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="seconds"
                        class="col-sm-2 col-form-label">
                        Seconds
                    </label>
                    <div class="col-sm-2">
                        <input type="number"
                            class="form-control"
                            name="seconds"
                            value="0">
                    </div>

                    <div class="col-sm-3 text-right mt-2">
                        <label class="form-check-label mr-3" for="active">Active</label>
                        <div class="form-check form-switch float-right">
                            <input class="form-check-input" type="checkbox" id="active" name="active" checked>
                        </div>
                    </div>

                    <div class="col-sm-3 text-right mt-2">
                        <label class="form-check-label mr-3" for="restart">Allow Restart</label>
                        <div class="form-check form-switch float-right">
                            <input class="form-check-input" type="checkbox" id="restart" name="restart" checked>
                        </div>
                    </div>
                </div>
                <div class="mb-2 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-9">
                        <?=form_error('seconds');?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3 mb-3" style="text-align:center">
            <button type="submit" class="btn btn-primary col-3">
                Simpan
            </button>
        </div>
    </div>



    <?php
} else {
    ?>

    <div class="card">
        <div class="card-header">
            <b>Quiz</b>
        </div>
        <div class="card-body row">
            <div class="col">
            
                <div class="mb-2 row">
                    <label for="code"
                        class="col-sm-3 col-form-label">
                        Code
                    </label>
                    <div class="col-sm-7">
                        <input type="text"
                            class="form-control"
                            id="code"
							name="code"
                            value="<?=$form['quiz']['data']['code']?>"
                            />
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="lib_code"
                        class="col-sm-3 col-form-label">
                        Library Code
                    </label>
                    <div class="col-sm-7">
                        <select class="form-control" name="lib_code">
                            <option value="">Pilih Library Code</option>
                            <?=select_html($form['lib_code']['data'], 'code', 'code', $form['quiz']['data']['library_code'])?>
                        </select>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="group_quiz_code"
                        class="col-sm-3 col-form-label">
                        Group Quiz Code
                    </label>
                    <div class="col-sm-7">
                        <select class="form-control" name="group_quiz_code">
                            <option value="">&lt;Default&gt;</option>
                            <?=select_html($form['sub_lib']['data'], 'code', 'code', $form['quiz']['data']['group_quiz_code'])?>
                        </select>
                    </div>
                </div>

                <div class="mb-2 row">
					<label for="is_show"
                        class="col-sm-3 col-form-label">
                        Is Show
                    </label>
                    <div class="col-sm-7">
						<div class="form-check form-switch float-left">
							<input class="form-check-input" type="checkbox" id="is_show" name="is_show" <?=checked_html(intval($form['quiz']['data']['is_show']))?>>
						</div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="mb-2 row">
                    <label for="label"
                        class="col-sm-2 col-form-label">
                        Label
                    </label>
                    <div class="col-sm-8">
                        <input type="text"
                            class="form-control"
                            id="label"
							name="label"
                            value="<?=$form['quiz']['data']['label']?>"
                            >
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="desc"
                        class="col-sm-2 col-form-label">
                        Description
                    </label>
                    <div class="col-sm-8">
                        <textarea class="form-control"
                            name="desc" ><?=$form['quiz']['data']['description']?></textarea>
                    </div>
                </div>

                <div class="mb-2 row">
                    <label for="seconds"
                        class="col-sm-2 col-form-label">
                        Seconds
                    </label>
                    <div class="col-sm-2">
                        <input type="number"
                            class="form-control"
                            id="seconds"
                            name="seconds"
                            value="<?=$form['quiz']['data']['seconds']?>">
                    </div>

                    <div class="col-sm-3 text-right mt-2">
                        <label class="form-check-label mr-3" for="active">Active</label>
                        <div class="form-check form-switch float-right">
                            <input class="form-check-input" type="checkbox" id="active" name="active" <?=checked_html(intval($form['quiz']['data']['active']))?>>
                        </div>
                    </div>

                    <div class="col-sm-3 text-right mt-2">
                        <label class="form-check-label mr-3" for="restart">Allow Restart</label>
                        <div class="form-check form-switch float-right">
                            <input class="form-check-input" type="checkbox" id="restart" name="restart" disabled
                            <?=checked_html($form['quiz']['data']['allow_restart'])?>>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
