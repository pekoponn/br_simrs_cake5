<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Absence $absence
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Absence'), ['action' => 'edit', $absence->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Absence'), ['action' => 'delete', $absence->id], ['confirm' => __('Are you sure you want to delete # {0}?', $absence->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Absences'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Absence'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="absences view content">
            <h3><?= h($absence->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $absence->has('user') ? $this->Html->link($absence->user->name, ['controller' => 'Users', 'action' => 'view', $absence->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Latitude') ?></th>
                    <td><?= h($absence->latitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Longitude') ?></th>
                    <td><?= h($absence->longitude) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($absence->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Location') ?></th>
                    <td><?= h($absence->location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expression') ?></th>
                    <td><?= h($absence->expression) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inout Mode') ?></th>
                    <td><?= h($absence->inout_mode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time In') ?></th>
                    <td><?= h($absence->time_in) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time Out') ?></th>
                    <td><?= h($absence->time_out) ?></td>
                </tr>
                <tr>
                    <th><?= __('Device') ?></th>
                    <td><?= h($absence->device) ?></td>
                </tr>
                <tr>
                    <th><?= __('Browser Type') ?></th>
                    <td><?= h($absence->browser_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($absence->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($absence->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($absence->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($absence->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($absence->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($absence->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($absence->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($absence->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($absence->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($absence->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($absence->delete_log)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($absence->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
