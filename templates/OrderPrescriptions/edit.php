<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderPrescription $orderPrescription
 * @var string[]|\Cake\Collection\CollectionInterface $orders
 * @var string[]|\Cake\Collection\CollectionInterface $medicines
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderPrescription->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderPrescription->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Order Prescriptions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderPrescriptions form content">
            <?= $this->Form->create($orderPrescription) ?>
            <fieldset>
                <legend><?= __('Edit Order Prescription') ?></legend>
                <?php
                    echo $this->Form->control('order_id', ['options' => $orders]);
                    echo $this->Form->control('medicine_id', ['options' => $medicines]);
                    echo $this->Form->control('medicine_unit');
                    echo $this->Form->control('is_kronis');
                    echo $this->Form->control('jml_per_hari');
                    echo $this->Form->control('qty_min');
                    echo $this->Form->control('jml_hari');
                    echo $this->Form->control('qty_satuan');
                    echo $this->Form->control('aturan_pakai');
                    echo $this->Form->control('harga');
                    echo $this->Form->control('total_harga');
                    echo $this->Form->control('keterangan');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
