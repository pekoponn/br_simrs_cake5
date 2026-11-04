<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LabExamination $labExamination
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Lab Examination'), ['action' => 'edit', $labExamination->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Lab Examination'), ['action' => 'delete', $labExamination->id], ['confirm' => __('Are you sure you want to delete # {0}?', $labExamination->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Lab Examinations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Lab Examination'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="labExaminations view content">
            <h3><?= h($labExamination->lab_no) ?></h3>
            <table>
                <tr>
                    <th><?= __('Lab No') ?></th>
                    <td><?= h($labExamination->lab_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $labExamination->hasValue('registration') ? $this->Html->link($labExamination->registration->id, ['controller' => 'Registrations', 'action' => 'view', $labExamination->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $labExamination->hasValue('patient') ? $this->Html->link($labExamination->patient->id, ['controller' => 'Patients', 'action' => 'view', $labExamination->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Medical Record No') ?></th>
                    <td><?= h($labExamination->medical_record_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Name') ?></th>
                    <td><?= h($labExamination->patient_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Examination Name') ?></th>
                    <td><?= h($labExamination->examination_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Type') ?></th>
                    <td><?= h($labExamination->patient_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sender Doctor') ?></th>
                    <td><?= h($labExamination->sender_doctor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Origin') ?></th>
                    <td><?= h($labExamination->origin) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($labExamination->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($labExamination->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($labExamination->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Received At') ?></th>
                    <td><?= h($labExamination->received_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Finished At') ?></th>
                    <td><?= h($labExamination->finished_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($labExamination->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($labExamination->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Integration Status') ?></th>
                    <td><?= $labExamination->integration_status ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $labExamination->is_create ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $labExamination->is_update ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $labExamination->is_delete ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>