<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BedHistory $bedHistory
 * @var string[]|\Cake\Collection\CollectionInterface $beds
 * @var string[]|\Cake\Collection\CollectionInterface $rooms
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $bedHistory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $bedHistory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Bed Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bedHistories form content">
            <?= $this->Form->create($bedHistory) ?>
            <fieldset>
                <legend><?= __('Edit Bed History') ?></legend>
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
