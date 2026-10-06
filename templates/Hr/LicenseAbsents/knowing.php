<?php
use Cake\Chronos\Date;
$dataChild = $this->Html->link('Tidak Masuk', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Mengetahui') ?>

<div class="panel panel-inverse">
    <?= $this->Form->create($licenseAbsent) ?>
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Tidak Masuk</h4>
                    <hr>
                    <div class="row m-b-15">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Nama Pemohon</b></div>
                                <div class="col-4 col-sm-4">: <span><?= $licenseAbsent->user->name ?></span>
                                <?= $this->Form->control('knowing', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                                <?= $this->Form->control('knwoing_date', ['type' => 'hidden', 'value' => new Date()]); ?>                                
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Tanggal</b></div>
                                <div class="col-4 col-sm-4">: <span><?php echo date_format($licenseAbsent->date_from, 'd M Y') . ' - ' . date_format($licenseAbsent->date_end, 'd M Y') ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>File pendukung</b></div>
                                <div class="col-4 col-sm-4"> : 
                                    <?php if (!empty($licenseAbsent->files)) : ?>
                                        <a href="<?= $this->Url->build('/files/' . h($licenseAbsent->files)) ?>"
                                        target="_blank"
                                        class="btn btn-xs btn-info mt-1">
                                            <i class="fa fa-eye"></i> Lihat
                                        </a>
                                    <?php else : ?>
                                        <span class="text-muted">Tidak ada file</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Deskripsi</b></div>
                                <div class="col-2 col-sm-2">:</span></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-6"><span><?= $this->Krs->fDecode($licenseAbsent->description) ?></span></div>
                            </div>
                             <div class="row">
                                <div class="col-2 col-sm-2"><b>Catatan Penyetuju</b></div>
                                <div class="col-2 col-sm-2">:</span></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-6"><span><?= $licenseAbsent->desc_approve ?: 'Tidak ada catatan' ?></span></div>
                            </div>
                            <hr>
                            <?= $this->Form->control('desc_knowing', ['label' => 'Catatan Mengetahui', 'class' => 'form-control', 'type' => 'textarea']); ?>
                            <br>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Status Kesesuaian Tidak Masuk</b></div>
                                <div class="col-4 col-sm-2">
                                    <?= $this->form->control('check_status',[
                                        'label' => false,
                                        'class' => 'form-control select2',
                                        'options' => $this->Krs->statusTidakMasuk(),
                                        'empty' => '-- Pilih Status --',
                                    ]) ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="form-check">
                                        <?= $this->Form->checkbox('status_knowing', [
                                            'value' => 'Y',
                                            'hiddenField' => 'N',
                                            'checked' => true,
                                            'id' => 'checkbox-approve',
                                            'class' => 'form-check-input'
                                        ]); ?>
                                        <label for="checkbox-approve" class="form-check-label ml-1">
                                            Mengetahui Tidak Masuk ini
                                        </label>
                                    </div>
                                    <small class="text-muted d-block ml-4 mt-1">
                                        Centang untuk mengetahui, hapus centang untuk menolak
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Mengetahui', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>


<script>
    $(document).ready(() => {
        var confirmTitle = "Apakah anda ingin mengetahui data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'LicenseAbsents', 'action' => 'knowing', $licenseAbsent->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
        $('.select2').select2({
            allowClear: true,
            placeholder: 'Pilih salah satu status',
        });
    });
</script>