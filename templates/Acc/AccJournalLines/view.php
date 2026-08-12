<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournalLine $accJournalLine
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Acc Journal Line'), ['action' => 'edit', $accJournalLine->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Acc Journal Line'), ['action' => 'delete', $accJournalLine->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalLine->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Acc Journal Lines'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Acc Journal Line'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accJournalLines view content">
            <h3><?= h($accJournalLine->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $accJournalLine->has('branch') ? $this->Html->link($accJournalLine->branch->name, ['controller' => 'Branches', 'action' => 'view', $accJournalLine->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('From') ?></th>
                    <td><?= h($accJournalLine->from) ?></td>
                </tr>
                <tr>
                    <th><?= __('Acc Journal') ?></th>
                    <td><?= $accJournalLine->has('acc_journal') ? $this->Html->link($accJournalLine->acc_journal->name, ['controller' => 'AccJournals', 'action' => 'view', $accJournalLine->acc_journal->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Acc Chart Of Account') ?></th>
                    <td><?= $accJournalLine->has('acc_chart_of_account') ? $this->Html->link($accJournalLine->acc_chart_of_account->name, ['controller' => 'AccChartOfAccounts', 'action' => 'view', $accJournalLine->acc_chart_of_account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Acc Chart Of Account Code') ?></th>
                    <td><?= h($accJournalLine->acc_chart_of_account_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manifest') ?></th>
                    <td><?= $accJournalLine->has('manifest') ? $this->Html->link($accJournalLine->manifest->id, ['controller' => 'Manifests', 'action' => 'view', $accJournalLine->manifest->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Hutang') ?></th>
                    <td><?= $accJournalLine->has('invoice_hutang') ? $this->Html->link($accJournalLine->invoice_hutang->id, ['controller' => 'InvoiceHutangs', 'action' => 'view', $accJournalLine->invoice_hutang->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice') ?></th>
                    <td><?= $accJournalLine->has('invoice') ? $this->Html->link($accJournalLine->invoice->id, ['controller' => 'Invoices', 'action' => 'view', $accJournalLine->invoice->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Ledger Dc') ?></th>
                    <td><?= h($accJournalLine->ledger_dc) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($accJournalLine->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($accJournalLine->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($accJournalLine->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($accJournalLine->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($accJournalLine->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($accJournalLine->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Journal Sub Id') ?></th>
                    <td><?= $this->Number->format($accJournalLine->journal_sub_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Journal Sub Line Id') ?></th>
                    <td><?= $this->Number->format($accJournalLine->journal_sub_line_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= $this->Number->format($accJournalLine->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Debet') ?></th>
                    <td><?= $this->Number->format($accJournalLine->debet) ?></td>
                </tr>
                <tr>
                    <th><?= __('Credit') ?></th>
                    <td><?= $this->Number->format($accJournalLine->credit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($accJournalLine->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($accJournalLine->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($accJournalLine->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Is Log') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($accJournalLine->is_log)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
