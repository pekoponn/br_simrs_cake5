<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReturPembelian $returPembelian
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $returPembelian->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $returPembelian->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Retur Pembelians'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="returPembelians form content">
            <?= $this->Form->create($returPembelian) ?>
            <fieldset>
                <legend><?= __('Edit Retur Pembelian') ?></legend>
                <?php
                    echo $this->Form->control('retur_no');
                    echo $this->Form->control('tgl_retur');
                    echo $this->Form->control('bapb_no');
                    echo $this->Form->control('no_faktur');
                    echo $this->Form->control('gudang_depo');
                    echo $this->Form->control('supplier_id');
                    echo $this->Form->control('nama_supplier');
                    echo $this->Form->control('catatan');
                    echo $this->Form->control('total');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
