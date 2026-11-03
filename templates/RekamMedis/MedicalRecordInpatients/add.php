<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordInpatient $medicalRecordInpatient
 * @var \Cake\Collection\CollectionInterface|string[] $medicalRecords
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Medical Record Inpatients'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalRecordInpatients form content">
            <?= $this->Form->create($medicalRecordInpatient) ?>
            <fieldset>
                <legend><?= __('Add Medical Record Inpatient') ?></legend>
                <?php
                    echo $this->Form->control('medical_record_id', ['options' => $medicalRecords]);
                    echo $this->Form->control('jenis');
                    echo $this->Form->control('pelayanan');
                    echo $this->Form->control('kelas');
                    echo $this->Form->control('ruang');
                    echo $this->Form->control('tgl_masuk', ['empty' => true]);
                    echo $this->Form->control('tgl_keluar', ['empty' => true]);
                    echo $this->Form->control('tgl_operasi', ['empty' => true]);
                    echo $this->Form->control('nama_dokter');
                    echo $this->Form->control('keadaan_keluar_rs');
                    echo $this->Form->control('cara_keluar');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
