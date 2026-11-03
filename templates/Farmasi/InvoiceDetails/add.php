<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceDetail $invoiceDetail
 * @var \Cake\Collection\CollectionInterface|string[] $invoices
 * @var \Cake\Collection\CollectionInterface|string[] $medicines
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Invoice Details'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="invoiceDetails form content">
            <?= $this->Form->create($invoiceDetail) ?>
            <fieldset>
                <legend><?= __('Add Invoice Detail') ?></legend>
                <?php
                    echo $this->Form->control('invoice_id', ['options' => $invoices]);
                    echo $this->Form->control('medicine_id', ['options' => $medicines, 'empty' => true]);
                    echo $this->Form->control('kode_barang');
                    echo $this->Form->control('nama_barang');
                    echo $this->Form->control('qty');
                    echo $this->Form->control('satuan');
                    echo $this->Form->control('harga');
                    echo $this->Form->control('discount_percent');
                    echo $this->Form->control('discount_rp');
                    echo $this->Form->control('tax');
                    echo $this->Form->control('total_harga');
                    echo $this->Form->control('tgl_kadaluarsa', ['empty' => true]);
                    echo $this->Form->control('po_no');
                    echo $this->Form->control('histori');
                    echo $this->Form->control('nilai_diskon');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
