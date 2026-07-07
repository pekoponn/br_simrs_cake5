<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordOutpatientIgd $medicalRecordOutpatientIgd
 * @var \Cake\Collection\CollectionInterface|string[] $medicalRecords
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Medical Record Outpatient Igds'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalRecordOutpatientIgds form content">
            <?= $this->Form->create($medicalRecordOutpatientIgd) ?>
            <fieldset>
                <legend><?= __('Add Medical Record Outpatient Igd') ?></legend>
                <?php
                    echo $this->Form->control('medical_record_id', ['options' => $medicalRecords]);
                    echo $this->Form->control('triage');
                    echo $this->Form->control('keadaan_keluar');
                    echo $this->Form->control('cara_bayar');
                    echo $this->Form->control('cara_masuk');
                    echo $this->Form->control('catatan');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
