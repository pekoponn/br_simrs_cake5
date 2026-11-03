<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BedHistory $bedHistory
 * @var \Cake\Collection\CollectionInterface|string[] $beds
 * @var \Cake\Collection\CollectionInterface|string[] $rooms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bed Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bedHistories form content">
            <?= $this->Form->create($bedHistory) ?>
            <fieldset>
                <legend><?= __('Add Bed History') ?></legend>
                <?php
                    echo $this->Form->control('bed_id', ['options' => $beds]);
                    echo $this->Form->control('room_id', ['options' => $rooms]);
                    echo $this->Form->control('patient_name');
                    echo $this->Form->control('registration_no');
                    echo $this->Form->control('check_in_date', ['empty' => true]);
                    echo $this->Form->control('check_out_date', ['empty' => true]);
                    echo $this->Form->control('status_before');
                    echo $this->Form->control('status_after');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('created_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
