<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordOutpatientIgd $medicalRecordOutpatientIgd
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medical Record Outpatient Igd'), ['action' => 'edit', $medicalRecordOutpatientIgd->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medical Record Outpatient Igd'), ['action' => 'delete', $medicalRecordOutpatientIgd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordOutpatientIgd->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medical Record Outpatient Igds'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medical Record Outpatient Igd'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalRecordOutpatientIgds view content">
            <h3><?= h($medicalRecordOutpatientIgd->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Medical Record') ?></th>
                    <td><?= $medicalRecordOutpatientIgd->has('medical_record') ? $this->Html->link($medicalRecordOutpatientIgd->medical_record->id, ['prefix' => 'RekamMedis', 'controller' => 'MedicalRecords', 'action' => 'view', $medicalRecordOutpatientIgd->medical_record->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Triage') ?></th>
                    <td><?= h($medicalRecordOutpatientIgd->triage) ?></td>
                </tr>
                <tr>
                    <th><?= __('Keadaan Keluar') ?></th>
                    <td><?= h($medicalRecordOutpatientIgd->keadaan_keluar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cara Bayar') ?></th>
                    <td><?= h($medicalRecordOutpatientIgd->cara_bayar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cara Masuk') ?></th>
                    <td><?= h($medicalRecordOutpatientIgd->cara_masuk) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicalRecordOutpatientIgd->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicalRecordOutpatientIgd->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicalRecordOutpatientIgd->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Catatan') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($medicalRecordOutpatientIgd->catatan)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
