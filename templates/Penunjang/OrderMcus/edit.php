<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderMcus $orderMcus
 * @var string[]|\Cake\Collection\CollectionInterface $orders
 * @var string[]|\Cake\Collection\CollectionInterface $registrations
 * @var string[]|\Cake\Collection\CollectionInterface $patients
 * @var string[]|\Cake\Collection\CollectionInterface $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $orderMcus->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderMcus->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Order Mcus'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderMcus form content">
            <?= $this->Form->create($orderMcus) ?>
            <fieldset>
                <legend><?= __('Edit Order Mcus') ?></legend>
                <?php
                    echo $this->Form->control('order_id', ['options' => $orders]);
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('mcu_date', ['empty' => true]);
                    echo $this->Form->control('mcu_time', ['empty' => true]);
                    echo $this->Form->control('mcu_type');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('is_delete');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
