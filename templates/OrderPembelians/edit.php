<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPembelian $orderPembelian
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderPembelian->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderPembelian->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Order Pembelians'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderPembelians form content">
            <?= $this->Form->create($orderPembelian) ?>
            <fieldset>
                <legend><?= __('Edit Order Pembelian') ?></legend>
                <?php
                    echo $this->Form->control('supplier_id');
                    echo $this->Form->control('po_no');
                    echo $this->Form->control('tgl_po');
                    echo $this->Form->control('ref_no');
                    echo $this->Form->control('tgl_kirim', ['empty' => true]);
                    echo $this->Form->control('barang_dikirim_ke');
                    echo $this->Form->control('kirim_via');
                    echo $this->Form->control('jenis');
                    echo $this->Form->control('total');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
