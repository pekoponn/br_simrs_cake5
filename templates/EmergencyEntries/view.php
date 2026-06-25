<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmergencyEntry $emergencyEntry
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Emergency Entry'), ['action' => 'edit', $emergencyEntry->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Emergency Entry'), ['action' => 'delete', $emergencyEntry->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emergencyEntry->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Emergency Entries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Emergency Entry'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="emergencyEntries view content">
            <h3><?= h($emergencyEntry->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $emergencyEntry->has('registration') ? $this->Html->link($emergencyEntry->registration->id, ['controller' => 'Registrations', 'action' => 'view', $emergencyEntry->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration No') ?></th>
                    <td><?= h($emergencyEntry->registration_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $emergencyEntry->has('patient') ? $this->Html->link($emergencyEntry->patient->id, ['controller' => 'Patients', 'action' => 'view', $emergencyEntry->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Rm') ?></th>
                    <td><?= h($emergencyEntry->patient_rm) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Name') ?></th>
                    <td><?= h($emergencyEntry->patient_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $emergencyEntry->has('doctor') ? $this->Html->link($emergencyEntry->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $emergencyEntry->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor Name') ?></th>
                    <td><?= h($emergencyEntry->doctor_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Triage Category') ?></th>
                    <td><?= h($emergencyEntry->triage_category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Blood Pressure') ?></th>
                    <td><?= h($emergencyEntry->blood_pressure) ?></td>
                </tr>
                <tr>
                    <th><?= __('Temperature') ?></th>
                    <td><?= h($emergencyEntry->temperature) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pulse') ?></th>
                    <td><?= h($emergencyEntry->pulse) ?></td>
                </tr>
                <tr>
                    <th><?= __('Respiration') ?></th>
                    <td><?= h($emergencyEntry->respiration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Spo2') ?></th>
                    <td><?= h($emergencyEntry->spo2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($emergencyEntry->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($emergencyEntry->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Service Date') ?></th>
                    <td><?= h($emergencyEntry->service_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Service Time') ?></th>
                    <td><?= h($emergencyEntry->service_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($emergencyEntry->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($emergencyEntry->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $emergencyEntry->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Chief Complaint') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($emergencyEntry->chief_complaint)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Triage Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($emergencyEntry->triage_notes)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Diagnosis') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($emergencyEntry->diagnosis)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($emergencyEntry->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
