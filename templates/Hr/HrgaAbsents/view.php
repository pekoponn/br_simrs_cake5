<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaAbsent $hrgaAbsent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Hrga Absent'), ['action' => 'edit', $hrgaAbsent->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Hrga Absent'), ['action' => 'delete', $hrgaAbsent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaAbsent->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Hrga Absents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Hrga Absent'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaAbsents view content">
            <h3><?= h($hrgaAbsent->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($hrgaAbsent->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($hrgaAbsent->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($hrgaAbsent->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($hrgaAbsent->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee Id') ?></th>
                    <td><?= $this->Number->format($hrgaAbsent->employee_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($hrgaAbsent->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($hrgaAbsent->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Start') ?></th>
                    <td><?= h($hrgaAbsent->date_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date End') ?></th>
                    <td><?= h($hrgaAbsent->date_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($hrgaAbsent->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($hrgaAbsent->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($hrgaAbsent->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
