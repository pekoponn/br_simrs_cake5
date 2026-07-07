<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordOutpatientIgd[]|\Cake\Collection\CollectionInterface $medicalRecordOutpatientIgds
 */
?>
<div class="medicalRecordOutpatientIgds index content">
    <?= $this->Html->link(__('New Medical Record Outpatient Igd'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Medical Record Outpatient Igds') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('medical_record_id') ?></th>
                    <th><?= $this->Paginator->sort('triage') ?></th>
                    <th><?= $this->Paginator->sort('keadaan_keluar') ?></th>
                    <th><?= $this->Paginator->sort('cara_bayar') ?></th>
                    <th><?= $this->Paginator->sort('cara_masuk') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicalRecordOutpatientIgds as $medicalRecordOutpatientIgd): ?>
                <tr>
                    <td><?= $this->Number->format($medicalRecordOutpatientIgd->id) ?></td>
                    <td><?= $medicalRecordOutpatientIgd->has('medical_record') ? $this->Html->link($medicalRecordOutpatientIgd->medical_record->id, ['controller' => 'MedicalRecords', 'action' => 'view', $medicalRecordOutpatientIgd->medical_record->id]) : '' ?></td>
                    <td><?= h($medicalRecordOutpatientIgd->triage) ?></td>
                    <td><?= h($medicalRecordOutpatientIgd->keadaan_keluar) ?></td>
                    <td><?= h($medicalRecordOutpatientIgd->cara_bayar) ?></td>
                    <td><?= h($medicalRecordOutpatientIgd->cara_masuk) ?></td>
                    <td><?= h($medicalRecordOutpatientIgd->created) ?></td>
                    <td><?= h($medicalRecordOutpatientIgd->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $medicalRecordOutpatientIgd->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicalRecordOutpatientIgd->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicalRecordOutpatientIgd->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordOutpatientIgd->id)]) ?>
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
