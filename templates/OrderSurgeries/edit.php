<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OrderSurgery $orderSurgery
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
                ['action' => 'delete', $orderSurgery->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $orderSurgery->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Order Surgeries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orderSurgeries form content">
            <?= $this->Form->create($orderSurgery) ?>
            <fieldset>
                <legend><?= __('Edit Order Surgery') ?></legend>
                <?php
                    echo $this->Form->control('order_id', ['options' => $orders]);
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('surgery_date', ['empty' => true]);
                    echo $this->Form->control('surgery_time', ['empty' => true]);
                    echo $this->Form->control('operator_id');
                    echo $this->Form->control('operator_name');
                    echo $this->Form->control('operation_type_id');
                    echo $this->Form->control('surgery_code');
                    echo $this->Form->control('surgery_name');
                    echo $this->Form->control('tariff');
                    echo $this->Form->control('unit');
                    echo $this->Form->control('approval_note');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('approved_queue_no');
                    echo $this->Form->control('approved_date', ['empty' => true]);
                    echo $this->Form->control('approved_time', ['empty' => true]);
                    echo $this->Form->control('operating_room');
                    echo $this->Form->control('approved_operator');
                    echo $this->Form->control('approved_surgery_name');
                    echo $this->Form->control('anesthesia_type');
                    echo $this->Form->control('approved_by');
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
