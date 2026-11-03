<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientCpptNote[]|\Cake\Collection\CollectionInterface $outpatientCpptNotes
 */
?>
<div class="outpatientCpptNotes index content">
    <?= $this->Html->link(__('New Outpatient Cppt Note'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Outpatient Cppt Notes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('outpatient_visit_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_id') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('noted_at') ?></th>
                    <th><?= $this->Paginator->sort('health_worker_name') ?></th>
                    <th><?= $this->Paginator->sort('doctor_name') ?></th>
                    <th><?= $this->Paginator->sort('nurse_name') ?></th>
                    <th><?= $this->Paginator->sort('created_by') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($outpatientCpptNotes as $outpatientCpptNote): ?>
                <tr>
                    <td><?= $this->Number->format($outpatientCpptNote->id) ?></td>
                    <td><?= $outpatientCpptNote->has('outpatient_visit') ? $this->Html->link($outpatientCpptNote->outpatient_visit->id, ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'view', $outpatientCpptNote->outpatient_visit->id]) : '' ?></td>
                    <td><?= $outpatientCpptNote->has('registration') ? $this->Html->link($outpatientCpptNote->registration->id, ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $outpatientCpptNote->registration->id]) : '' ?></td>
                    <td><?= $outpatientCpptNote->has('patient') ? $this->Html->link($outpatientCpptNote->patient->id, ['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'view', $outpatientCpptNote->patient->id]) : '' ?></td>
                    <td><?= $outpatientCpptNote->has('doctor') ? $this->Html->link($outpatientCpptNote->doctor->doctor_name, ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'view', $outpatientCpptNote->doctor->id]) : '' ?></td>
                    <td><?= h($outpatientCpptNote->noted_at) ?></td>
                    <td><?= h($outpatientCpptNote->health_worker_name) ?></td>
                    <td><?= h($outpatientCpptNote->doctor_name) ?></td>
                    <td><?= h($outpatientCpptNote->nurse_name) ?></td>
                    <td><?= h($outpatientCpptNote->created_by) ?></td>
                    <td><?= h($outpatientCpptNote->created) ?></td>
                    <td><?= h($outpatientCpptNote->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $outpatientCpptNote->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $outpatientCpptNote->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $outpatientCpptNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientCpptNote->id)]) ?>
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
