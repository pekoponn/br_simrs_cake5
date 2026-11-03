<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RencanaPembelian $rencanaPembelian
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rencanaPembelian->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rencanaPembelian->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Rencana Pembelians'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="rencanaPembelians form content">
            <?= $this->Form->create($rencanaPembelian) ?>
            <fieldset>
                <legend><?= __('Edit Rencana Pembelian') ?></legend>
                <?php
                    echo $this->Form->control('no_perencanaan');
                    echo $this->Form->control('tgl_perencanaan');
                    echo $this->Form->control('no_dokumen');
                    echo $this->Form->control('status');
                    echo $this->Form->control('supplier_id');
                    echo $this->Form->control('nama_supplier');
                    echo $this->Form->control('diminta_oleh');
                    echo $this->Form->control('total_qty_permintaan');
                    echo $this->Form->control('total_permintaan');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
