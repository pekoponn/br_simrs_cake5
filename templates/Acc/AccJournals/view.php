<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccJournal $accJournal
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Acc Journal'), ['action' => 'edit', $accJournal->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Acc Journal'), ['action' => 'delete', $accJournal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournal->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Acc Journals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Acc Journal'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accJournals view content">
            <h3><?= h($accJournal->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $accJournal->has('branch') ? $this->Html->link($accJournal->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $accJournal->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Number') ?></th>
                    <td><?= h($accJournal->number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Old') ?></th>
                    <td><?= h($accJournal->code_old) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($accJournal->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $accJournal->has('customer') ? $this->Html->link($accJournal->customer->name, ['prefix' => 'Master', 'controller' => 'Customers', 'action' => 'view', $accJournal->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Journal Type') ?></th>
                    <td><?= h($accJournal->journal_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tax') ?></th>
                    <td><?= h($accJournal->tax) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($accJournal->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($accJournal->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cek Bg') ?></th>
                    <td><?= h($accJournal->cek_bg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recipient Payer') ?></th>
                    <td><?= $accJournal->has('recipient_payer') ? $this->Html->link($accJournal->recipient_payer->name, ['controller' => 'RecipientPayers', 'action' => 'view', $accJournal->recipient_payer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Recipient Payer Name') ?></th>
                    <td><?= h($accJournal->recipient_payer_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Recipient Payer Code') ?></th>
                    <td><?= h($accJournal->recipient_payer_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Type') ?></th>
                    <td><?= h($accJournal->payment_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Cek') ?></th>
                    <td><?= h($accJournal->no_cek) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Ref') ?></th>
                    <td><?= h($accJournal->no_ref) ?></td>
                </tr>
                <tr>
                    <th><?= __('Job') ?></th>
                    <td><?= h($accJournal->job) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($accJournal->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($accJournal->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($accJournal->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($accJournal->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($accJournal->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($accJournal->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Journal Sub Id') ?></th>
                    <td><?= $this->Number->format($accJournal->journal_sub_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Id Ori') ?></th>
                    <td><?= $this->Number->format($accJournal->customer_id_ori) ?></td>
                </tr>
                <tr>
                    <th><?= __('Balance') ?></th>
                    <td><?= $this->Number->format($accJournal->balance) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grand Total') ?></th>
                    <td><?= $this->Number->format($accJournal->grand_total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($accJournal->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Posting') ?></th>
                    <td><?= h($accJournal->date_posting) ?></td>
                </tr>
                <tr>
                    <th><?= __('Warkat Date') ?></th>
                    <td><?= h($accJournal->warkat_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($accJournal->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($accJournal->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($accJournal->deleted) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($accJournal->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Lines') ?></h4>
                <?php if (!empty($accJournal->acc_journal_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Id') ?></th>
                            <th><?= __('Journal Sub Id') ?></th>
                            <th><?= __('Journal Sub Line Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accJournal->acc_journal_lines as $accJournalLines) : ?>
                        <tr>
                            <td><?= h($accJournalLines->id) ?></td>
                            <td><?= h($accJournalLines->branch_id) ?></td>
                            <td><?= h($accJournalLines->acc_journal_id) ?></td>
                            <td><?= h($accJournalLines->journal_sub_id) ?></td>
                            <td><?= h($accJournalLines->journal_sub_line_id) ?></td>
                            <td><?= h($accJournalLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalLines->position) ?></td>
                            <td><?= h($accJournalLines->ledger_dc) ?></td>
                            <td><?= h($accJournalLines->name) ?></td>
                            <td><?= h($accJournalLines->debet) ?></td>
                            <td><?= h($accJournalLines->credit) ?></td>
                            <td><?= h($accJournalLines->is_create) ?></td>
                            <td><?= h($accJournalLines->created) ?></td>
                            <td><?= h($accJournalLines->is_update) ?></td>
                            <td><?= h($accJournalLines->modified) ?></td>
                            <td><?= h($accJournalLines->is_delete) ?></td>
                            <td><?= h($accJournalLines->deleted) ?></td>
                            <td><?= h($accJournalLines->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['prefix' => 'Acc', 'controller' => 'AccJournalLines', 'action' => 'view', $accJournalLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Acc', 'controller' => 'AccJournalLines', 'action' => 'edit', $accJournalLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Acc', 'controller' => 'AccJournalLines', 'action' => 'delete', $accJournalLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
