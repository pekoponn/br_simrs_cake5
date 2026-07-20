<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoice->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="invoices form content">
            <?= $this->Form->create($invoice) ?>
            <fieldset>
                <legend><?= __('Edit Invoice') ?></legend>
                <?php
                    echo $this->Form->control('bapb_no');
                    echo $this->Form->control('nama_supplier');
                    echo $this->Form->control('supplier_id');
                    echo $this->Form->control('tgl_terima');
                    echo $this->Form->control('no_faktur');
                    echo $this->Form->control('sj_no');
                    echo $this->Form->control('tgl_tukar_faktur', ['empty' => true]);
                    echo $this->Form->control('kurs');
                    echo $this->Form->control('rate');
                    echo $this->Form->control('pembayaran');
                    echo $this->Form->control('tgl_jatuh_tempo', ['empty' => true]);
                    echo $this->Form->control('diterima_lokasi_gudang');
                    echo $this->Form->control('materai');
                    echo $this->Form->control('discount_percent');
                    echo $this->Form->control('discount_rp');
                    echo $this->Form->control('ongkos_kirim');
                    echo $this->Form->control('total');
                    echo $this->Form->control('grand_total');
                    echo $this->Form->control('catatan');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
