<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournalLine[]|\Cake\Collection\CollectionInterface $accJournalLines
 */
?>
<div class="accJournalLines index content">
    <?= $this->Html->link(__('New Acc Journal Line'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Acc Journal Lines') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('branch_id') ?></th>
                    <th><?= $this->Paginator->sort('from') ?></th>
                    <th><?= $this->Paginator->sort('acc_journal_id') ?></th>
                    <th><?= $this->Paginator->sort('journal_sub_id') ?></th>
                    <th><?= $this->Paginator->sort('journal_sub_line_id') ?></th>
                    <th><?= $this->Paginator->sort('acc_chart_of_account_id') ?></th>
                    <th><?= $this->Paginator->sort('acc_chart_of_account_code') ?></th>
                    <th><?= $this->Paginator->sort('manifest_id') ?></th>
                    <th><?= $this->Paginator->sort('invoice_hutang_id') ?></th>
                    <th><?= $this->Paginator->sort('invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('position') ?></th>
                    <th><?= $this->Paginator->sort('ledger_dc') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('debet') ?></th>
                    <th><?= $this->Paginator->sort('credit') ?></th>
                    <th><?= $this->Paginator->sort('is_create') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('is_update') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('is_delete') ?></th>
                    <th><?= $this->Paginator->sort('deleted') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accJournalLines as $accJournalLine): ?>
                <tr>
                    <td><?= $this->Number->format($accJournalLine->id) ?></td>
                    <td><?= $accJournalLine->has('branch') ? $this->Html->link($accJournalLine->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $accJournalLine->branch->id]) : '' ?></td>
                    <td><?= h($accJournalLine->from) ?></td>
                    <td><?= $accJournalLine->has('acc_journal') ? $this->Html->link($accJournalLine->acc_journal->name, ['prefix' => 'Acc', 'controller' => 'AccJournals', 'action' => 'view', $accJournalLine->acc_journal->id]) : '' ?></td>
                    <td><?= $this->Number->format($accJournalLine->journal_sub_id) ?></td>
                    <td><?= $this->Number->format($accJournalLine->journal_sub_line_id) ?></td>
                    <td><?= $accJournalLine->has('acc_chart_of_account') ? $this->Html->link($accJournalLine->acc_chart_of_account->name, ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'view', $accJournalLine->acc_chart_of_account->id]) : '' ?></td>
                    <td><?= h($accJournalLine->acc_chart_of_account_code) ?></td>
                    <td><?= $accJournalLine->has('manifest') ? $this->Html->link($accJournalLine->manifest->id, ['controller' => 'Manifests', 'action' => 'view', $accJournalLine->manifest->id]) : '' ?></td>
                    <td><?= $accJournalLine->has('invoice_hutang') ? $this->Html->link($accJournalLine->invoice_hutang->id, ['controller' => 'InvoiceHutangs', 'action' => 'view', $accJournalLine->invoice_hutang->id]) : '' ?></td>
                    <td><?= $accJournalLine->has('invoice') ? $this->Html->link($accJournalLine->invoice->id, ['prefix' => 'Farmasi', 'controller' => 'Invoices', 'action' => 'view', $accJournalLine->invoice->id]) : '' ?></td>
                    <td><?= $this->Number->format($accJournalLine->position) ?></td>
                    <td><?= h($accJournalLine->ledger_dc) ?></td>
                    <td><?= h($accJournalLine->name) ?></td>
                    <td><?= $this->Number->format($accJournalLine->debet) ?></td>
                    <td><?= $this->Number->format($accJournalLine->credit) ?></td>
                    <td><?= h($accJournalLine->is_create) ?></td>
                    <td><?= h($accJournalLine->created) ?></td>
                    <td><?= h($accJournalLine->is_update) ?></td>
                    <td><?= h($accJournalLine->modified) ?></td>
                    <td><?= h($accJournalLine->is_delete) ?></td>
                    <td><?= h($accJournalLine->deleted) ?></td>
                    <td><?= h($accJournalLine->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $accJournalLine->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $accJournalLine->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $accJournalLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalLine->id)]) ?>
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
