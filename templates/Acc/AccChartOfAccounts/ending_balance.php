<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount $accChartOfAccount
 */
$dataChild = $this->Html->link('Perkiraan', ['action' => 'index'], ['full_base'=>true]);
?>

<?= $this->Krs->breadcrumb('Accounting', $dataChild, 'Ending Balance Bank') ?>
<div class="panel panel-inverse">
    <?= $this->Krs->heading('Saldo Akhir Bank'); ?>
    <?= $this->Form->create($accChartOfAccount) ?>
    <div class="panel-body bg-gray-100">
        <div class="form-group row m-b-15">
            <label class="col-form-label col-md-1">Kode COA</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $getUser->id]);

                echo $this->Form->control('code', ['label' => false, 'class' => 'form-control', 'readonly' => true]);
                ?>
            </div>
            <label class="col-form-label col-md-1">Nama COA</label>
            <div class="col-md-2">
                <?php
                echo $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'readonly' => true]);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <h6>Beginning Balance</h6>
                    <?= $this->Form->control('beginning_balance', ['label' => false, 'class' => 'form-control text-right', 'readonly' => true]) ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <h6>Beginning Balance Debet</h6>
                    <?= $this->Form->control('beginning_balance_debet', [
                        'label' => false,
                        'class' => 'form-control text-right',
                        'readonly' => true
                    ]) ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <h6>Beginning Balance Credit</h6>
                    <?= $this->Form->control('beginning_balance_credit', [
                        'label' => false,
                        'class' => 'form-control text-right',
                        'readonly' => true
                    ]) ?>
                </div>
            </div>

        </div>

        <hr>

        <div class="form-group">
            <h6>Ending Balance Bank <span class="text-danger">*</span></h6>

            <?= $this->Form->control('ending_balance_bank', [
                'label' => false,
                'class' => 'form-control text-right',
                'placeholder' => 'Masukkan saldo akhir bank'
            ]) ?>
        </div>

    </div>

    <?= $this->Krs->btnSave() ?>

    <?= $this->Form->end() ?>
</div>