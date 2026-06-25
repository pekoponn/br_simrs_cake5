<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InpatientEntry $inpatientEntry
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inpatient Entry'), ['action' => 'edit', $inpatientEntry->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inpatient Entry'), ['action' => 'delete', $inpatientEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inpatientEntry->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inpatient Entries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inpatient Entry'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="inpatientEntries view content">
            <h3><?= h($inpatientEntry->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $inpatientEntry->has('registration') ? $this->Html->link($inpatientEntry->registration->id, ['controller' => 'Registrations', 'action' => 'view', $inpatientEntry->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration No') ?></th>
                    <td><?= h($inpatientEntry->registration_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $inpatientEntry->has('patient') ? $this->Html->link($inpatientEntry->patient->id, ['controller' => 'Patients', 'action' => 'view', $inpatientEntry->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Name') ?></th>
                    <td><?= h($inpatientEntry->patient_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Rm') ?></th>
                    <td><?= h($inpatientEntry->patient_rm) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $inpatientEntry->has('doctor') ? $this->Html->link($inpatientEntry->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $inpatientEntry->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor Name') ?></th>
                    <td><?= h($inpatientEntry->doctor_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Room') ?></th>
                    <td><?= $inpatientEntry->has('room') ? $this->Html->link($inpatientEntry->room->id, ['controller' => 'Rooms', 'action' => 'view', $inpatientEntry->room->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Room Name') ?></th>
                    <td><?= h($inpatientEntry->room_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bed') ?></th>
                    <td><?= $inpatientEntry->has('bed') ? $this->Html->link($inpatientEntry->bed->name, ['controller' => 'Beds', 'action' => 'view', $inpatientEntry->bed->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Bed No') ?></th>
                    <td><?= h($inpatientEntry->bed_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($inpatientEntry->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inpatientEntry->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check In Date') ?></th>
                    <td><?= h($inpatientEntry->check_in_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Planned Discharge Date') ?></th>
                    <td><?= h($inpatientEntry->planned_discharge_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check Out Date') ?></th>
                    <td><?= h($inpatientEntry->check_out_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($inpatientEntry->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($inpatientEntry->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $inpatientEntry->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($inpatientEntry->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
