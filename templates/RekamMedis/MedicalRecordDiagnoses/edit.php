<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordDiagnosis $medicalRecordDiagnosis
 * @var string[]|\Cake\Collection\CollectionInterface $medicalRecords
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $medicalRecordDiagnosis->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordDiagnosis->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Medical Record Diagnoses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalRecordDiagnoses form content">
            <?= $this->Form->create($medicalRecordDiagnosis) ?>
            <fieldset>
                <legend><?= __('Edit Medical Record Diagnosis') ?></legend>
                <?php
                    echo $this->Form->control('medical_record_id', ['options' => $medicalRecords]);
                    echo $this->Form->control('type');
                    echo $this->Form->control('code');
                    echo $this->Form->control('diagnosis');
                    echo $this->Form->control('is_primary');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
