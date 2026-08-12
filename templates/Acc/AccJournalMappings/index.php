<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournalMapping[]|\Cake\Collection\CollectionInterface $accJournalMappings
 */
?>
<div class="accJournalMappings index content">
    <?= $this->Html->link(__('New Acc Journal Mapping'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Acc Journal Mappings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('acc_chart_of_account_id') ?></th>
                    <th><?= $this->Paginator->sort('group') ?></th>
                    <th><?= $this->Paginator->sort('sub_group') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('ledger_dc') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('commentary') ?></th>
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
                <?php foreach ($accJournalMappings as $accJournalMapping): ?>
                <tr>
                    <td><?= $this->Number->format($accJournalMapping->id) ?></td>
                    <td><?= $accJournalMapping->has('branch') ? $this->Html->link($accJournalMapping->branch->name, ['controller' => 'Branches', 'action' => 'view', $accJournalMapping->branch->id]) : '' ?></td>
                    <td><?= $accJournalMapping->has('acc_chart_of_account') ? $this->Html->link($accJournalMapping->acc_chart_of_account->name, ['controller' => 'AccChartOfAccounts', 'action' => 'view', $accJournalMapping->acc_chart_of_account->id]) : '' ?></td>
                    <td><?= h($accJournalMapping->group) ?></td>
                    <td><?= h($accJournalMapping->sub_group) ?></td>
                    <td><?= h($accJournalMapping->type) ?></td>
                    <td><?= h($accJournalMapping->ledger_dc) ?></td>
                    <td><?= h($accJournalMapping->name) ?></td>
                    <td><?= h($accJournalMapping->commentary) ?></td>
                    <td><?= h($accJournalMapping->desc) ?></td>
                    <td><?= h($accJournalMapping->is_create) ?></td>
                    <td><?= h($accJournalMapping->created) ?></td>
                    <td><?= h($accJournalMapping->is_update) ?></td>
                    <td><?= h($accJournalMapping->modified) ?></td>
                    <td><?= h($accJournalMapping->is_delete) ?></td>
                    <td><?= h($accJournalMapping->deleted) ?></td>
                    <td><?= h($accJournalMapping->status) ?></td>
                    <td><?= h($accJournalMapping->is_active) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $accJournalMapping->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accJournalMapping->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accJournalMapping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMapping->id)]) ?>
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
