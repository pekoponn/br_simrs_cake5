<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OutpatientCpptNote $outpatientCpptNote
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Outpatient Cppt Note'), ['action' => 'edit', $outpatientCpptNote->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Outpatient Cppt Note'), ['action' => 'delete', $outpatientCpptNote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $outpatientCpptNote->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Outpatient Cppt Notes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Outpatient Cppt Note'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="outpatientCpptNotes view content">
            <h3><?= h($outpatientCpptNote->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Outpatient Visit') ?></th>
                    <td><?= $outpatientCpptNote->has('outpatient_visit') ? $this->Html->link($outpatientCpptNote->outpatient_visit->id, ['prefix' => 'RawatJalan', 'controller' => 'OutpatientVisits', 'action' => 'view', $outpatientCpptNote->outpatient_visit->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration') ?></th>
                    <td><?= $outpatientCpptNote->has('registration') ? $this->Html->link($outpatientCpptNote->registration->id, ['prefix' => 'Registrasi', 'controller' => 'Registrations', 'action' => 'view', $outpatientCpptNote->registration->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient') ?></th>
                    <td><?= $outpatientCpptNote->has('patient') ? $this->Html->link($outpatientCpptNote->patient->id, ['prefix' => 'Registrasi', 'controller' => 'Patients', 'action' => 'view', $outpatientCpptNote->patient->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $outpatientCpptNote->has('doctor') ? $this->Html->link($outpatientCpptNote->doctor->doctor_name, ['prefix' => 'Master', 'controller' => 'Doctors', 'action' => 'view', $outpatientCpptNote->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Health Worker Name') ?></th>
                    <td><?= h($outpatientCpptNote->health_worker_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor Name') ?></th>
                    <td><?= h($outpatientCpptNote->doctor_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nurse Name') ?></th>
                    <td><?= h($outpatientCpptNote->nurse_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($outpatientCpptNote->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($outpatientCpptNote->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Noted At') ?></th>
                    <td><?= h($outpatientCpptNote->noted_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($outpatientCpptNote->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($outpatientCpptNote->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Assessment Text') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outpatientCpptNote->assessment_text)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Instruction') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($outpatientCpptNote->instruction)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
