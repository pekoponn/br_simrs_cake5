<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PatientHistory $patientHistory
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Patient Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="patientHistories form content">
            <?= $this->Form->create($patientHistory) ?>
            <fieldset>
                <legend><?= __('Add Patient History') ?></legend>
                <?php
                    echo $this->Form->control('registration_id', ['options' => $registrations]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('is_create');
                    echo $this->Form->control('is_update');
                    echo $this->Form->control('is_delete');
                    echo $this->Form->control('deleted', ['empty' => true]);
                    echo $this->Form->control('delete_log');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
