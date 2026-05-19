<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Registration[]|\Cake\Collection\CollectionInterface $registrations
 */
?>
<div class="registrations index content">
    <?= $this->Html->link(__('New Registration'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Registrations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('registration_no') ?></th>
                    <th><?= $this->Paginator->sort('patient_id') ?></th>
                    <th><?= $this->Paginator->sort('registration_date') ?></th>
                    <th><?= $this->Paginator->sort('service_type') ?></th>
                    <th><?= $this->Paginator->sort('doctor_id') ?></th>
                    <th><?= $this->Paginator->sort('polyclinic_name') ?></th>
                    <th><?= $this->Paginator->sort('room_id') ?></th>
                    <th><?= $this->Paginator->sort('bed_id') ?></th>
                    <th><?= $this->Paginator->sort('class_name') ?></th>
                    <th><?= $this->Paginator->sort('entry_process') ?></th>
                    <th><?= $this->Paginator->sort('entry_method') ?></th>
                    <th><?= $this->Paginator->sort('payment_method') ?></th>
                    <th><?= $this->Paginator->sort('insurance_type') ?></th>
                    <th><?= $this->Paginator->sort('insurance_card_no') ?></th>
                    <th><?= $this->Paginator->sort('refferal_no') ?></th>
                    <th><?= $this->Paginator->sort('sep_no') ?></th>
                    <th><?= $this->Paginator->sort('person_responsible_id') ?></th>
                    <th><?= $this->Paginator->sort('treatment_type') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registrations as $registration): ?>
                <tr>
                    <td><?= $this->Number->format($registration->id) ?></td>
                    <td><?= h($registration->registration_no) ?></td>
                    <td><?= $registration->has('patient') ? $this->Html->link($registration->patient->id, ['controller' => 'Patients', 'action' => 'view', $registration->patient->id]) : '' ?></td>
                    <td><?= h($registration->registration_date) ?></td>
                    <td><?= h($registration->service_type) ?></td>
                    <td><?= $registration->has('doctor') ? $this->Html->link($registration->doctor->id, ['controller' => 'Doctors', 'action' => 'view', $registration->doctor->id]) : '' ?></td>
                    <td><?= h($registration->polyclinic_name) ?></td>
                    <td><?= $registration->has('room') ? $this->Html->link($registration->room->id, ['controller' => 'Rooms', 'action' => 'view', $registration->room->id]) : '' ?></td>
                    <td><?= $this->Number->format($registration->bed_id) ?></td>
                    <td><?= h($registration->class_name) ?></td>
                    <td><?= h($registration->entry_process) ?></td>
                    <td><?= h($registration->entry_method) ?></td>
                    <td><?= h($registration->payment_method) ?></td>
                    <td><?= h($registration->insurance_type) ?></td>
                    <td><?= h($registration->insurance_card_no) ?></td>
                    <td><?= h($registration->refferal_no) ?></td>
                    <td><?= h($registration->sep_no) ?></td>
                    <td><?= $this->Number->format($registration->person_responsible_id) ?></td>
                    <td><?= h($registration->treatment_type) ?></td>
                    <td><?= h($registration->status) ?></td>
                    <td><?= $this->Number->format($registration->is_create) ?></td>
                    <td><?= h($registration->created) ?></td>
                    <td><?= $this->Number->format($registration->is_update) ?></td>
                    <td><?= h($registration->modified) ?></td>
                    <td><?= $this->Number->format($registration->is_delete) ?></td>
                    <td><?= h($registration->deleted) ?></td>
                    <td><?= h($registration->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $registration->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $registration->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $registration->id], ['confirm' => __('Are you sure you want to delete # {0}?', $registration->id)]) ?>
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
