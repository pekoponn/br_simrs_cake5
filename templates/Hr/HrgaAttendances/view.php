<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaAttendance $hrgaAttendance
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Hrga Attendance'), ['action' => 'edit', $hrgaAttendance->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Hrga Attendance'), ['action' => 'delete', $hrgaAttendance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaAttendance->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Hrga Attendances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Hrga Attendance'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaAttendances view content">
            <h3><?= h($hrgaAttendance->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($hrgaAttendance->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($hrgaAttendance->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($hrgaAttendance->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($hrgaAttendance->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee Id') ?></th>
                    <td><?= $this->Number->format($hrgaAttendance->employee_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jml') ?></th>
                    <td><?= $this->Number->format($hrgaAttendance->jml) ?></td>
                </tr>
                <tr>
                    <th><?= __('Terlambat') ?></th>
                    <td><?= $this->Number->format($hrgaAttendance->terlambat) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($hrgaAttendance->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($hrgaAttendance->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($hrgaAttendance->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($hrgaAttendance->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($hrgaAttendance->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
