<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccAccountMapping $accAccountMapping
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Acc Account Mapping'), ['action' => 'edit', $accAccountMapping->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Acc Account Mapping'), ['action' => 'delete', $accAccountMapping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accAccountMapping->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Acc Account Mappings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Acc Account Mapping'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accAccountMappings view content">
            <h3><?= h($accAccountMapping->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $accAccountMapping->has('branch') ? $this->Html->link($accAccountMapping->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $accAccountMapping->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Acc Chart Of Account') ?></th>
                    <td><?= $accAccountMapping->has('acc_chart_of_account') ? $this->Html->link($accAccountMapping->acc_chart_of_account->name, ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'view', $accAccountMapping->acc_chart_of_account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= h($accAccountMapping->group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($accAccountMapping->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Desc') ?></th>
                    <td><?= h($accAccountMapping->desc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($accAccountMapping->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($accAccountMapping->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($accAccountMapping->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($accAccountMapping->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($accAccountMapping->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($accAccountMapping->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($accAccountMapping->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($accAccountMapping->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($accAccountMapping->deleted) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
