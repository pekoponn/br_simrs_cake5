<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Insurance $insurance
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Insurance'), ['action' => 'edit', $insurance->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Insurance'), ['action' => 'delete', $insurance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $insurance->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Insurances'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Insurance'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="insurances view content">
            <h3><?= h($insurance->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($insurance->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Region') ?></th>
                    <td><?= h($insurance->region) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($insurance->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($insurance->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Name') ?></th>
                    <td><?= h($insurance->bank_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Account Number') ?></th>
                    <td><?= h($insurance->bank_account_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Bank Account Name') ?></th>
                    <td><?= h($insurance->bank_account_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number Rs') ?></th>
                    <td><?= h($insurance->phone_number_rs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email Rs') ?></th>
                    <td><?= h($insurance->email_rs) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($insurance->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($insurance->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= $this->Number->format($insurance->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= $this->Number->format($insurance->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= $this->Number->format($insurance->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($insurance->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($insurance->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($insurance->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delete Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($insurance->delete_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
