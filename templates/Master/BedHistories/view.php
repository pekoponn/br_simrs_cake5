<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BedHistory $bedHistory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Bed History'), ['action' => 'edit', $bedHistory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Bed History'), ['action' => 'delete', $bedHistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bedHistory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bed Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Bed History'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="bedHistories view content">
            <h3><?= h($bedHistory->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Bed') ?></th>
                    <td><?= $bedHistory->has('bed') ? $this->Html->link($bedHistory->bed->name, ['prefix' => 'Master', 'controller' => 'Beds', 'action' => 'view', $bedHistory->bed->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Room') ?></th>
                    <td><?= $bedHistory->has('room') ? $this->Html->link($bedHistory->room->id, ['prefix' => 'Master', 'controller' => 'Rooms', 'action' => 'view', $bedHistory->room->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Patient Name') ?></th>
                    <td><?= h($bedHistory->patient_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration No') ?></th>
                    <td><?= h($bedHistory->registration_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= h($bedHistory->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($bedHistory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check In Date') ?></th>
                    <td><?= h($bedHistory->check_in_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Check Out Date') ?></th>
                    <td><?= h($bedHistory->check_out_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($bedHistory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($bedHistory->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Before') ?></th>
                    <td><?= $bedHistory->status_before ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Status After') ?></th>
                    <td><?= $bedHistory->status_after ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bedHistory->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
