<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DoctorSchedule $doctorSchedule
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Doctor Schedule'), ['action' => 'edit', $doctorSchedule->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Doctor Schedule'), ['action' => 'delete', $doctorSchedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $doctorSchedule->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Doctor Schedules'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Doctor Schedule'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="doctorSchedules view content">
            <h3><?= h($doctorSchedule->code) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($doctorSchedule->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Doctor') ?></th>
                    <td><?= $doctorSchedule->has('doctor') ? $this->Html->link($doctorSchedule->doctor->doctor_name, ['controller' => 'Doctors', 'action' => 'view', $doctorSchedule->doctor->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Day') ?></th>
                    <td><?= h($doctorSchedule->day) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($doctorSchedule->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($doctorSchedule->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quota') ?></th>
                    <td><?= $doctorSchedule->quota === null ? '' : $this->Number->format($doctorSchedule->quota) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $doctorSchedule->is_create === null ? '' : $this->Number->format($doctorSchedule->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $doctorSchedule->is_update === null ? '' : $this->Number->format($doctorSchedule->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $doctorSchedule->is_delete === null ? '' : $this->Number->format($doctorSchedule->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h($doctorSchedule->start_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= h($doctorSchedule->end_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($doctorSchedule->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($doctorSchedule->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($doctorSchedule->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($doctorSchedule->note)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($doctorSchedule->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
