<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientCpptNote $outpatientCpptNote
 * @var \Cake\Collection\CollectionInterface|string[] $outpatientVisits
 * @var \Cake\Collection\CollectionInterface|string[] $registrations
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $doctors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Outpatient Cppt Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientCpptNotes form content">
            <?= $this->Form->create($outpatientCpptNote) ?>
            <fieldset>
                <legend><?= __('Add Outpatient Cppt Note') ?></legend>
                <?php
                    echo $this->Form->control('outpatient_visit_id', ['options' => $outpatientVisits]);
                    echo $this->Form->control('registration_id', ['options' => $registrations, 'empty' => true]);
                    echo $this->Form->control('patient_id', ['options' => $patients, 'empty' => true]);
                    echo $this->Form->control('doctor_id', ['options' => $doctors, 'empty' => true]);
                    echo $this->Form->control('noted_at', ['empty' => true]);
                    echo $this->Form->control('health_worker_name');
                    echo $this->Form->control('doctor_name');
                    echo $this->Form->control('nurse_name');
                    echo $this->Form->control('assessment_text');
                    echo $this->Form->control('instruction');
                    echo $this->Form->control('created_by');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
