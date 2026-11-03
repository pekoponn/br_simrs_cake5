<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordInpatient[]|\Cake\Collection\CollectionInterface $medicalRecordInpatients
 */
?>
<div class="medicalRecordInpatients index content">
    <?= $this->Html->link(__('New Medical Record Inpatient'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Medical Record Inpatients') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('medical_record_id') ?></th>
                    <th><?= $this->Paginator->sort('jenis') ?></th>
                    <th><?= $this->Paginator->sort('pelayanan') ?></th>
                    <th><?= $this->Paginator->sort('kelas') ?></th>
                    <th><?= $this->Paginator->sort('ruang') ?></th>
                    <th><?= $this->Paginator->sort('tgl_masuk') ?></th>
                    <th><?= $this->Paginator->sort('tgl_keluar') ?></th>
                    <th><?= $this->Paginator->sort('tgl_operasi') ?></th>
                    <th><?= $this->Paginator->sort('nama_dokter') ?></th>
                    <th><?= $this->Paginator->sort('keadaan_keluar_rs') ?></th>
                    <th><?= $this->Paginator->sort('cara_keluar') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicalRecordInpatients as $medicalRecordInpatient): ?>
                <tr>
                    <td><?= $this->Number->format($medicalRecordInpatient->id) ?></td>
                    <td><?= $medicalRecordInpatient->has('medical_record') ? $this->Html->link($medicalRecordInpatient->medical_record->id, ['prefix' => 'RekamMedis', 'controller' => 'MedicalRecords', 'action' => 'view', $medicalRecordInpatient->medical_record->id]) : '' ?></td>
                    <td><?= h($medicalRecordInpatient->jenis) ?></td>
                    <td><?= h($medicalRecordInpatient->pelayanan) ?></td>
                    <td><?= h($medicalRecordInpatient->kelas) ?></td>
                    <td><?= h($medicalRecordInpatient->ruang) ?></td>
                    <td><?= h($medicalRecordInpatient->tgl_masuk) ?></td>
                    <td><?= h($medicalRecordInpatient->tgl_keluar) ?></td>
                    <td><?= h($medicalRecordInpatient->tgl_operasi) ?></td>
                    <td><?= h($medicalRecordInpatient->nama_dokter) ?></td>
                    <td><?= h($medicalRecordInpatient->keadaan_keluar_rs) ?></td>
                    <td><?= h($medicalRecordInpatient->cara_keluar) ?></td>
                    <td><?= h($medicalRecordInpatient->created) ?></td>
                    <td><?= h($medicalRecordInpatient->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $medicalRecordInpatient->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicalRecordInpatient->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicalRecordInpatient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordInpatient->id)]) ?>
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
