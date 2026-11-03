<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankTopup $bankTopup
 */
?>
<?php
ini_set('precision', 14);
?>


<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Data Topup Bank</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Nama Bank</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankTopup->payment_type ?></div>
                <!-- <div class="col-2 col-sm-2">
                    <h6>UBS</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankTopup->ubs ?? '-' ?></div> -->
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Tanggal TopUp</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankTopup->created->format('d-m-Y') ?></div>
                <div class="col-2 col-sm-2">
                    <h6>Tujuan Topup</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankTopup->acc_chart_of_account->code. ' - ' . $bankTopup->acc_chart_of_account->name ?></div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>COA Penyetor</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankTopup->acc_chart_of_account_to->code. ' - ' . $bankTopup->acc_chart_of_account_to->name ?></div>
                <div class="col-2 col-sm-2">
                    <h6>Nominal</h6>
                </div>
                <div class="col-4 col-sm-4">
                    : Rp. <?= $bankTopup->nominal > 0 ? $this->Krs->nom($bankTopup->nominal) : '-' ?>
                </div>
            </div>
            <div class="row">
                <div class="col-2 col-sm-2">
                    <h6>Deskripsi</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $bankTopup->description ?> </div>
                <!-- <div class="col-2 col-sm-2">
                    <h6>Aktif</h6>
                </div>
                <div class="col-4 col-sm-4">: <?= $isActive ?></div> -->
            </div>
        </div>
    </div>
</div>


<!-- <?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BankTopup $bankTopup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bank Topup'), ['action' => 'edit', $bankTopup->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bank Topup'), ['action' => 'delete', $bankTopup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bankTopup->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bank Topups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bank Topup'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bankTopups view content">
            <h3><?= h($bankTopup->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $bankTopup->has('branch') ? $this->Html->link($bankTopup->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $bankTopup->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Type') ?></th>
                    <td><?= h($bankTopup->payment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($bankTopup->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bankTopup->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acc Coa Id') ?></th>
                    <td><?= $this->Number->format($bankTopup->acc_coa_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nominal') ?></th>
                    <td><?= $this->Number->format($bankTopup->nominal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($bankTopup->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($bankTopup->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($bankTopup->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($bankTopup->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($bankTopup->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($bankTopup->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bankTopup->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bankTopup->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div> -->
