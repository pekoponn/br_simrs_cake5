<?php
use Cake\Chronos\Date;
$dataChild = $this->Html->link('Ijin Pulang', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Mengetahui') ?>

<div class="panel panel-inverse">
    <?= $this->Form->create($permissionLate) ?>
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Ijin Terlambat</h4>
                    <hr>
                    <div class="row m-b-15">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Nama Pemohon</b></div>
                                <div class="col-4 col-sm-4">: <span><?= $permissionLate->user->name ?></span>
                                <?= $this->Form->control('is_knowing', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                                <?= $this->Form->control('knowing', ['type' => 'hidden', 'value' => new Date()]); ?>                                
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Tanggal</b></div>
                                <div class="col-4 col-sm-4">: <span><?php echo date_format($permissionLate->date, 'd M Y') ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Jam Datang</b></div>
                                <div class="col-4 col-sm-4">: <span><?php echo $permissionLate->time_in ?></span></div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>File pendukung</b></div>
                                <div class="col-4 col-sm-4"> : 
                                    <?php if (!empty($permissionLate->files)) : ?>
                                        <a href="<?= $this->Url->build('/files/' . h($permissionLate->files)) ?>"
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
                                <div class="col-6 col-sm-6"><span><?= $this->Krs->fDecode($permissionLate->description) ?></span></div>
                            </div>
                            <?php if (!empty($permissionLate->desc_approve)) : ?>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Catatan Approve</b></div>
                                <div class="col-2 col-sm-2">:</span></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-6"><span><?= $permissionLate->desc_approve ?></span></div>
                            </div>
                            <?php endif; ?>
                            <?= $this->Form->control('desc_knowing', ['label' => 'Catatan Mengetahui', 'class' => 'form-control', 'type' => 'textarea']); ?>
                            <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <div class="form-check">
                                <?= $this->Form->checkbox('status_knowing', ['value' => 'Y', 'hiddenField' => 'N', 'checked' => true, 'id' => 'checkbox-approve', 'class' => 'form-check-input'
                                ]); ?>
                                <label for="checkbox-approve" class="form-check-label ml-1">
                                    Setujui Izin Terlambat ini
                                </label>
                            </div>
                            <small class="text-muted d-block ml-4 mt-1">
                                Centang untuk menyetujui, hapus centang untuk menolak
                            </small>
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
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'PermissionLates', 'action' => 'knowing', $permissionLate->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
        $('.select2').select2({
            allowClear: true,
            placeholder: 'Pilih salah satu status',
        });
    });
</script>