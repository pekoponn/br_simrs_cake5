<?php
use Cake\Chronos\Date;
$dataChild = $this->Html->link('Form Cuti', ['action' => 'index'], ['full_base' => true]);
?>

<?= $this->Krs->breadcrumb('HRGA', $dataChild, 'Menyetujui') ?>

<div class="panel panel-inverse">
    <?= $this->Form->create($leave) ?>
    <div class="panel-body">
        <div class="table-toolbar">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Form Cuti</h4>
                    <hr>
                    <div class="row m-b-15">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Nama Pemohon</b></div>
                                <div class="col-4 col-sm-4">: <span><?= $leave->user->name ?></span>
                                <?= $this->Form->control('approved', ['type' => 'hidden', 'value' => $getUser->id]); ?>
                                <?= $this->Form->control('approved_date', ['type' => 'hidden', 'value' => new Date()]); ?>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Tanggal</b></div>
                                <div class="col-4 col-sm-4">:
                                    <span>
                                        <?php
                                        if (!empty($leave->date_1)) {
                                            echo $leave->date_1->format('d M Y');
                                        } elseif (!empty($leave->date_from) && !empty($leave->date_end)) {
                                            echo $leave->date_from->format('d M Y') . ' - ' . $leave->date_end->format('d M Y');
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Jenis Cuti</b></div>
                                <div class="col-4 col-sm-4">: <span><?= !empty($leave->type) ? h($leave->type) : '-' ?></span></div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-2 col-sm-2"><b>Perihal</b></div>
                                <div class="col-4 col-sm-4">: <span><?= $leave->type ?></span></div>
                            </div> -->
                            <div class="row">
                                <div class="col-2 col-sm-2"><b>Deskripsi</b></div>
                                <div class="col-2 col-sm-2">:</span></div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-sm-6"><span><?= $this->Krs->fDecode($leave->description) ?></span></div>
                            </div>
                            <div class="row m-b-15">
                                <div class="col-6 col-sm-6">
                                    <?= $this->Form->control('desc_approve', ['label' => 'Catatan Penyetuju', 'class' => 'form-control', 'type' => 'textarea', 'rows' => 3]); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="form-check">
                                        <?= $this->Form->checkbox('status_approve', ['value' => 'Y', 'hiddenField' => 'N', 'checked' => true, 'id' => 'checkbox-approve', 'class' => 'form-check-input'
                                        ]); ?>
                                        <label for="checkbox-approve" class="form-check-label ml-1">
                                            Setujui Cuti ini
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
        </div>
    </div>
    <div class="panel-footer text-right bg-warning">
        <?php
        echo $this->Form->button('Menyetujui', ['class' => 'btn btn-primary', 'type' => 'button', 'escape' => false, 'id' => 'btn-add']);
        ?>
    </div>
    <?= $this->Form->end() ?>
</div>


<script>
    $(document).ready(() => {
        var confirmTitle = "Apakah anda ingin menyetujui data tersebut ?";
        var formAction = "<?php echo $this->Url->build(['prefix' => 'Hr', 'controller' => 'Leaves', 'action' => 'approve', $leave->id], ['fullBase' => true]); ?>";
        handleFormConfirmSubmitValid('GroupAddForm', 'btn-add', confirmTitle, formAction);
    });
</script>
