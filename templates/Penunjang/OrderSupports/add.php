<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderSupport $orderSupport
 * @var \Cake\Collection\CollectionInterface|string[] $orders
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Order Supports'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderSupports form content">
            <?= $this->Form->create($orderSupport) ?>
            <fieldset>
                <legend><?= __('Add Order Support') ?></legend>
                <?php
                    echo $this->Form->control('order_id', ['options' => $orders]);
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('support_code');
                    echo $this->Form->control('support_name');
                    echo $this->Form->control('tariff');
                    echo $this->Form->control('qty');
                    echo $this->Form->control('total');
                    echo $this->Form->control('unit');
                    echo $this->Form->control('approval_note');
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
