<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MedicalResume[]|\Cake\Collection\CollectionInterface $medicalResumes
 */
?>
<div class="medicalResumes index content">
    <?= $this->Html->link(__('New Medical Resume'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Medical Resumes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('outpatient_visit_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor1_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor2_name') ?></th>
                    <th><?= $this->Paginator->sort('doctor3_name') ?></th>
                    <th><?= $this->Paginator->sort('doctor4_name') ?></th>
                    <th><?= $this->Paginator->sort('consultant1_name') ?></th>
                    <th><?= $this->Paginator->sort('consultant2_name') ?></th>
                    <th><?= $this->Paginator->sort('condition_on_discharge') ?></th>
                    <th><?= $this->Paginator->sort('prognosis') ?></th>
                    <th><?= $this->Paginator->sort('follow_up_treatment') ?></th>
                    <th><?= $this->Paginator->sort('control_date') ?></th>
                    <th><?= $this->Paginator->sort('print_classic') ?></th>
                    <th><?= $this->Paginator->sort('send_digital_claim') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($medicalResumes as $medicalResume): ?>
                <tr>
                    <td><?= $this->Number->format($medicalResume->id) ?></td>
                    <td><?= $medicalResume->has('outpatient_visit') ? $this->Html->link($medicalResume->outpatient_visit->id, ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'view', $medicalResume->outpatient_visit->id]) : '' ?></td>
                    <td><?= $medicalResume->has('registration') ? $this->Html->link($medicalResume->registration->id, ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $medicalResume->registration->id]) : '' ?></td>
                    <td><?= $medicalResume->has('patient') ? $this->Html->link($medicalResume->patient->id, ['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'view', $medicalResume->patient->id]) : '' ?></td>
                    <td><?= $this->Number->format($medicalResume->doctor1_id) ?></td>
                    <td><?= h($medicalResume->doctor2_name) ?></td>
                    <td><?= h($medicalResume->doctor3_name) ?></td>
                    <td><?= h($medicalResume->doctor4_name) ?></td>
                    <td><?= h($medicalResume->consultant1_name) ?></td>
                    <td><?= h($medicalResume->consultant2_name) ?></td>
                    <td><?= h($medicalResume->condition_on_discharge) ?></td>
                    <td><?= h($medicalResume->prognosis) ?></td>
                    <td><?= h($medicalResume->follow_up_treatment) ?></td>
                    <td><?= h($medicalResume->control_date) ?></td>
                    <td><?= h($medicalResume->print_classic) ?></td>
                    <td><?= h($medicalResume->send_digital_claim) ?></td>
                    <td><?= h($medicalResume->created) ?></td>
                    <td><?= h($medicalResume->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $medicalResume->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicalResume->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicalResume->id], ['confirm' => __('Are you sure you want to delete # {0}?', $medicalResume->id)]) ?>
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
