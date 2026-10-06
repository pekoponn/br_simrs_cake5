<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\WorkOrder $accLoan
 */
$dataChild = $this->Html->link('Surat Perintah Kerja Lembur', ['action' => 'index'], ['full_base' => true]);
use Sabberworm\CSS\Value\Value;
use Cake\Chronos\Date;
?>
<?= $this->Krs->breadcrumb('Form', $dataChild, 'Menyetujui') ?>

<div class="panel panel-inverse">
    <div class="panel-heading">
    <h4 class="panel-title">Surat Perintah Kerja Lembur</h4>
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        </div>
    </div>

    <?= $this->Form->create($workOrder) ?>
    <?= $this->Form->hidden('is_approve', ['value' => $this->request->getSession()->read('Auth.id')]) ?>
<div class="panel-body">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label>Nomor Surat</label>
                <div class="input-group m-b-10">
                    <?= $this->Form->control('code', [
                        'class' => 'form-control', 
                        'placeholder' => 'No..', 
                        'label' => false,
                        'disabled' => true
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Business Unit</label>                        
                <div class="input-group">
                    <?= $this->Form->control('business_unit', [
                        'empty' => false, 
                        'options' => $this->Krs->businessUnit(), 
                        'data-placeholder' => 'Silakan pilih..',  
                        'class' => 'form-control select2Form', 
                        'type' => 'select', 
                        'label' => false,
                        'disabled' => true
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Tanggal</label>                        
                <div class="input-group">
                    <?= $this->Form->control('date', [
                        'data-placeholder' => 'Silakan pilih..', 
                        'class' => 'form-control date1', 
                        'type' => 'text', 
                        'label' => false,
                        'value' => $workOrder->date ? $workOrder->date->format('d-m-Y') : '',
                        'disabled' => true
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= $this->Form->control('description', [
            'label' => 'Keterangan', 
            'type' => 'textarea', 
            'rows' => '6', 
            'cols' => '75', 
            'class' => 'form-control', 
            'placeholder' => 'Keterangan', 
            'disabled' => true
        ]); ?>
    </div> 
    <hr>
    <h4>Rincian Surat Perintah Kerja Lembur</h4>
    <div class="table-responsive">
        <table class="table m-b-0 table-advance">
            <tr class="sum">
                <td>
                    <table cellpadding="0" class="adminlist" cellspacing="0" border="0" id="myTable" width="100%">
                        <thead class="thead-dark text-center">
                            <tr>
                                <th width="25%">Nama</th>
                                <th width="15%">Jam Mulai</th>
                                <th width="15%">Jam Akhir</th>
                                <th width="40%">Rincian Tugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($workOrder->work_order_lines)): ?>
                                <?php foreach ($workOrder->work_order_lines as $i => $line): ?>
                                    <tr>
                                        <td>
                                            <input type="text" 
                                                   class="form-control" 
                                                   value="<?= h($line->user->name ?? '-') ?>" 
                                                   readonly>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="<?= h($line->time_from ?? '-') ?>" 
                                                       readonly>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock"></span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" 
                                                       class="form-control" 
                                                       value="<?= h($line->time_end ?? '-') ?>" 
                                                       readonly>
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock"></span>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" 
                                                   class="form-control" 
                                                   value="<?= h($line->task ?? '-') ?>" 
                                                   readonly>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    
    <hr>
    <div class="form-group">
        <div class="form-check">
            <?= $this->Form->checkbox('status_approve', [
                'value' => 'Y',
                'hiddenField' => 'N',
                'checked' => true,
                'id' => 'checkbox-approve',
                'class' => 'form-check-input'
            ]); ?>

            <label for="checkbox-approve" class="form-check-label ml-1">
                Setujui Surat Perintah Kerja Lembur ini
            </label>
        </div>

        <small class="text-muted d-block ml-4 mt-1">
            Centang untuk menyetujui, hapus centang untuk menolak
        </small>
    </div>
</div>
<div class="panel-footer text-right bg-orange">
    <?= $this->Form->button('Simpan', [
        'class' => 'btn btn-primary', 
        'type' => 'button', 
        'escape' => false, 
        'id' => 'btn-add'
    ]); ?>
</div>   
<?= $this->Form->end() ?>

<script>
$(document).ready(function () {
    $('.date1').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    $('#btn-add').on('click', function (e) {
        e.preventDefault();

        const isChecked = $('#checkbox-approve').is(':checked');
        const message = isChecked 
            ? 'Apakah Anda yakin ingin menyetujui Surat Perintah Kerja Lembur ini?' 
            : 'Apakah Anda yakin ingin menolak Surat Perintah Kerja Lembur ini?';

        SwalHelper.confirm(message, '', 'Ya, simpan', 'Batal').then((result) => {
            if (result.isConfirmed) {
                $('form').submit();
            }
        }); 
    });
});
</script>
