<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HealthFacility $healthFacility
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Health Facility'), ['action' => 'edit', $healthFacility->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Health Facility'), ['action' => 'delete', $healthFacility->id], ['confirm' => __('Are you sure you want to delete # {0}?', $healthFacility->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Health Facilities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Health Facility'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="healthFacilities view content">
            <h3><?= h($healthFacility->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($healthFacility->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Int') ?></th>
                    <td><?= h($healthFacility->code_int) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($healthFacility->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($healthFacility->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Ppk') ?></th>
                    <td><?= h($healthFacility->code_ppk) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($healthFacility->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($healthFacility->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($healthFacility->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($healthFacility->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($healthFacility->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($healthFacility->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($healthFacility->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($healthFacility->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($healthFacility->address)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($healthFacility->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
