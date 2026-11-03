<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Polyclinic $polyclinic
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Polyclinic'), ['action' => 'edit', $polyclinic->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Polyclinic'), ['action' => 'delete', $polyclinic->id], ['confirm' => __('Are you sure you want to delete # {0}?', $polyclinic->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Polyclinics'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Polyclinic'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="polyclinics view content">
            <h3><?= h($polyclinic->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($polyclinic->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($polyclinic->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($polyclinic->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($polyclinic->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($polyclinic->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($polyclinic->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($polyclinic->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($polyclinic->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($polyclinic->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($polyclinic->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($polyclinic->description)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($polyclinic->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
