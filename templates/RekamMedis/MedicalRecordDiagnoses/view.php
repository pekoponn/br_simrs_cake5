<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordDiagnosis $medicalRecordDiagnosis
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medical Record Diagnosis'), ['action' => 'edit', $medicalRecordDiagnosis->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medical Record Diagnosis'), ['action' => 'delete', $medicalRecordDiagnosis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordDiagnosis->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medical Record Diagnoses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medical Record Diagnosis'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalRecordDiagnoses view content">
            <h3><?= h($medicalRecordDiagnosis->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Medical Record') ?></th>
                    <td><?= $medicalRecordDiagnosis->has('medical_record') ? $this->Html->link($medicalRecordDiagnosis->medical_record->id, ['prefix' => 'RekamMedis', 'controller' => 'MedicalRecords', 'action' => 'view', $medicalRecordDiagnosis->medical_record->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($medicalRecordDiagnosis->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($medicalRecordDiagnosis->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicalRecordDiagnosis->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicalRecordDiagnosis->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicalRecordDiagnosis->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Primary') ?></th>
                    <td><?= $medicalRecordDiagnosis->is_primary ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Diagnosis') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalRecordDiagnosis->diagnosis)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
