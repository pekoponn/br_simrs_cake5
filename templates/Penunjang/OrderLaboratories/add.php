<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderLaboratory $orderLaboratory
 * @var \Cake\Collection\CollectionInterface|string[] $orders
 * @var \Cake\Collection\CollectionInterface|string[] $masterTindakan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Order Laboratories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderLaboratories form content">
            <?= $this->Form->create($orderLaboratory) ?>
            <fieldset>
                <legend><?= __('Add Order Laboratory') ?></legend>
                <?php
                    echo $this->Form->control('order_id', ['options' => $orders]);
                    echo $this->Form->control('master_tindakan_id', ['options' => $masterTindakan, 'empty' => true]);
                    echo $this->Form->control('code');
                    echo $this->Form->control('examination_name');
                    echo $this->Form->control('price');
                    echo $this->Form->control('approval_note');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
