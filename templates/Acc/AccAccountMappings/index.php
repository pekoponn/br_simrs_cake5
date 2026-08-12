<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccAccountMapping[]|\Cake\Collection\CollectionInterface $accAccountMappings
 */
?>
<div class="accAccountMappings index content">
    <?= $this->Html->link(__('New Acc Account Mapping'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Acc Account Mappings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('acc_chart_of_account_id') ?></th>
                    <th><?= $this->Paginator->sort('group') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('desc') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accAccountMappings as $accAccountMapping): ?>
                <tr>
                    <td><?= $this->Number->format($accAccountMapping->id) ?></td>
                    <td><?= $accAccountMapping->has('branch') ? $this->Html->link($accAccountMapping->branch->name, ['controller' => 'Branches', 'action' => 'view', $accAccountMapping->branch->id]) : '' ?></td>
                    <td><?= $accAccountMapping->has('acc_chart_of_account') ? $this->Html->link($accAccountMapping->acc_chart_of_account->name, ['controller' => 'AccChartOfAccounts', 'action' => 'view', $accAccountMapping->acc_chart_of_account->id]) : '' ?></td>
                    <td><?= h($accAccountMapping->group) ?></td>
                    <td><?= h($accAccountMapping->name) ?></td>
                    <td><?= h($accAccountMapping->desc) ?></td>
                    <td><?= h($accAccountMapping->is_create) ?></td>
                    <td><?= h($accAccountMapping->created) ?></td>
                    <td><?= h($accAccountMapping->is_update) ?></td>
                    <td><?= h($accAccountMapping->modified) ?></td>
                    <td><?= h($accAccountMapping->is_delete) ?></td>
                    <td><?= h($accAccountMapping->deleted) ?></td>
                    <td><?= h($accAccountMapping->status) ?></td>
                    <td><?= h($accAccountMapping->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $accAccountMapping->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accAccountMapping->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accAccountMapping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accAccountMapping->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
