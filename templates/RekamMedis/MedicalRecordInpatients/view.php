<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalRecordInpatient $medicalRecordInpatient
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Medical Record Inpatient'), ['action' => 'edit', $medicalRecordInpatient->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Medical Record Inpatient'), ['action' => 'delete', $medicalRecordInpatient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalRecordInpatient->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Medical Record Inpatients'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Medical Record Inpatient'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="medicalRecordInpatients view content">
            <h3><?= h($medicalRecordInpatient->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Medical Record') ?></th>
                    <td><?= $medicalRecordInpatient->has('medical_record') ? $this->Html->link($medicalRecordInpatient->medical_record->id, ['prefix' => 'RekamMedis', 'controller' => 'MedicalRecords', 'action' => 'view', $medicalRecordInpatient->medical_record->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Jenis') ?></th>
                    <td><?= h($medicalRecordInpatient->jenis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pelayanan') ?></th>
                    <td><?= h($medicalRecordInpatient->pelayanan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Kelas') ?></th>
                    <td><?= h($medicalRecordInpatient->kelas) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ruang') ?></th>
                    <td><?= h($medicalRecordInpatient->ruang) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nama Dokter') ?></th>
                    <td><?= h($medicalRecordInpatient->nama_dokter) ?></td>
                </tr>
                <tr>
                    <th><?= __('Keadaan Keluar Rs') ?></th>
                    <td><?= h($medicalRecordInpatient->keadaan_keluar_rs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cara Keluar') ?></th>
                    <td><?= h($medicalRecordInpatient->cara_keluar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($medicalRecordInpatient->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Masuk') ?></th>
                    <td><?= h($medicalRecordInpatient->tgl_masuk) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Keluar') ?></th>
                    <td><?= h($medicalRecordInpatient->tgl_keluar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tgl Operasi') ?></th>
                    <td><?= h($medicalRecordInpatient->tgl_operasi) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($medicalRecordInpatient->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($medicalRecordInpatient->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
