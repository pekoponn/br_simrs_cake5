<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordDiagnosis[]|\Cake\Collection\CollectionInterface $medicalRecordDiagnoses
 */
?>
<div class="medicalRecordDiagnoses index content">
    <?= $this->Html->link(__('New Medical Record Diagnosis'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Medical Record Diagnoses') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('medical_record_id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('is_primary') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicalRecordDiagnoses as $medicalRecordDiagnosis): ?>
                <tr>
                    <td><?= $this->Number->format($medicalRecordDiagnosis->id) ?></td>
                    <td><?= $medicalRecordDiagnosis->has('medical_record') ? $this->Html->link($medicalRecordDiagnosis->medical_record->id, ['prefix' => 'RekamMedis', 'controller' => 'MedicalRecords', 'action' => 'view', $medicalRecordDiagnosis->medical_record->id]) : '' ?></td>
                    <td><?= h($medicalRecordDiagnosis->type) ?></td>
                    <td><?= h($medicalRecordDiagnosis->code) ?></td>
                    <td><?= h($medicalRecordDiagnosis->is_primary) ?></td>
                    <td><?= h($medicalRecordDiagnosis->created) ?></td>
                    <td><?= h($medicalRecordDiagnosis->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $medicalRecordDiagnosis->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicalRecordDiagnosis->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicalRecordDiagnosis->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordDiagnosis->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
