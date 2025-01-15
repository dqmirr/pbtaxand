

<div class="card mb-2 pb-3">
    <div class="card-header">
        <b>Tambah</b>
    </div>
    <div class="card-body row">
        <div class="col">
            <div class="mb-2 row">
                <label for="code"
                    class="col-sm-3 col-form-label">
                    Code Formasi
                </label>
                <div class="col-sm-7">
                    <input type="text"
                        class="form-control"
                        name="code"
                        id="code">
                    <?=form_error('code');?>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="code"
                    class="col-sm-3 col-form-label">
                    Label Formasi
                </label>
                <div class="col-sm-7">
                    <input type="text"
                        class="form-control"
                        name="label"
                        id="label">
                    <?=form_error('label');?>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="code"
                    class="col-sm-3 col-form-label">
                    Pilih Sesi
                </label>
                <div class="col-sm-7">
                    <select class="form-control select2" name="sesi"
                        data-placeholder="Pilih Sesi">
                        <?php foreach($form['select_sesi'] as $val) { ?>
                        <option value="<?=$val['id']?>">
                            <?=$val['label']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?=form_error('sesi');?>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="code"
                    class="col-sm-3 col-form-label">
                    Pilih Divisi
                </label>
                <div class="col-sm-7">
                    <select class="form-control select2" name="divisi"
                        data-placeholder="Pilih Divisi">
                        <?php foreach($form['select_divisi'] as $val) { ?>
                        <option value="<?=$val['id']?>">
                            <?=$val['label']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?=form_error('divisi');?>
                </div>
            </div>

            <div class="mb-2 row">
                <label for="code"
                    class="col-sm-3 col-form-label">
                    Pilih Level
                </label>
                <div class="col-sm-7">
                    <select class="form-control select2" name="level"
                        data-placeholder="Pilih Level">
                        <?php foreach($form['select_level'] as $val) { ?>
                        <option value="<?=$val['id']?>">
                            <?=$val['label']?>
                        </option>
                        <?php } ?>
                    </select>
                    <?=form_error('level');?>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3" style="text-align:center">
            <button type="submit" class="btn btn-primary col-4">
                Simpan
            </button>
        </div>
    </div>

</div>