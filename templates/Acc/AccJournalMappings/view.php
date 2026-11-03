<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournalMapping $accJournalMapping
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Acc Journal Mapping'), ['action' => 'edit', $accJournalMapping->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Acc Journal Mapping'), ['action' => 'delete', $accJournalMapping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMapping->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Acc Journal Mappings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Acc Journal Mapping'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accJournalMappings view content">
            <h3><?= h($accJournalMapping->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $accJournalMapping->has('branch') ? $this->Html->link($accJournalMapping->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $accJournalMapping->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Acc Chart Of Account') ?></th>
                    <td><?= $accJournalMapping->has('acc_chart_of_account') ? $this->Html->link($accJournalMapping->acc_chart_of_account->name, ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'view', $accJournalMapping->acc_chart_of_account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= h($accJournalMapping->group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sub Group') ?></th>
                    <td><?= h($accJournalMapping->sub_group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($accJournalMapping->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ledger Dc') ?></th>
                    <td><?= h($accJournalMapping->ledger_dc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($accJournalMapping->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Commentary') ?></th>
                    <td><?= h($accJournalMapping->commentary) ?></td>
                </tr>
                <tr>
                    <th><?= __('Desc') ?></th>
                    <td><?= h($accJournalMapping->desc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($accJournalMapping->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($accJournalMapping->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($accJournalMapping->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($accJournalMapping->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($accJournalMapping->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($accJournalMapping->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($accJournalMapping->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($accJournalMapping->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($accJournalMapping->deleted) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
