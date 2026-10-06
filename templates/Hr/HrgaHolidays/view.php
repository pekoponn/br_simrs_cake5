<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrgaHoliday $hrgaHoliday
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Hrga Holiday'), ['action' => 'edit', $hrgaHoliday->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Hrga Holiday'), ['action' => 'delete', $hrgaHoliday->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrgaHoliday->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Hrga Holidays'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Hrga Holiday'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="hrgaHolidays view content">
            <h3><?= h($hrgaHoliday->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($hrgaHoliday->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($hrgaHoliday->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($hrgaHoliday->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($hrgaHoliday->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($hrgaHoliday->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($hrgaHoliday->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($hrgaHoliday->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($hrgaHoliday->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($hrgaHoliday->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($hrgaHoliday->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
