<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderRadiology $orderRadiology
 * @var string[]|\Cake\Collection\CollectionInterface $orders
 * @var string[]|\Cake\Collection\CollectionInterface $masterTindakan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderRadiology->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderRadiology->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Order Radiologies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderRadiologies form content">
            <?= $this->Form->create($orderRadiology) ?>
            <fieldset>
                <legend><?= __('Edit Order Radiology') ?></legend>
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
