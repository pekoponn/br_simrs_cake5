<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AccChartOfAccount $accChartOfAccount
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Acc Chart Of Account'), ['action' => 'edit', $accChartOfAccount->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Acc Chart Of Account'), ['action' => 'delete', $accChartOfAccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accChartOfAccount->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Acc Chart Of Accounts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Acc Chart Of Account'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="accChartOfAccounts view content">
            <h3><?= h($accChartOfAccount->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Branch') ?></th>
                    <td><?= $accChartOfAccount->has('branch') ? $this->Html->link($accChartOfAccount->branch->name, ['prefix' => 'Pengaturan', 'controller' => 'Branches', 'action' => 'view', $accChartOfAccount->branch->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Parent Acc Chart Of Account') ?></th>
                    <td><?= $accChartOfAccount->has('parent_acc_chart_of_account') ? $this->Html->link($accChartOfAccount->parent_acc_chart_of_account->name, ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'view', $accChartOfAccount->parent_acc_chart_of_account->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Parent Account') ?></th>
                    <td><?= h($accChartOfAccount->parent_account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Header Account') ?></th>
                    <td><?= h($accChartOfAccount->header_account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sub Header Account') ?></th>
                    <td><?= h($accChartOfAccount->sub_header_account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($accChartOfAccount->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($accChartOfAccount->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($accChartOfAccount->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Contra Account') ?></th>
                    <td><?= h($accChartOfAccount->contra_account) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mapping') ?></th>
                    <td><?= h($accChartOfAccount->mapping) ?></td>
                </tr>
                <tr>
                    <th><?= __('Group') ?></th>
                    <td><?= h($accChartOfAccount->group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sub Group') ?></th>
                    <td><?= h($accChartOfAccount->sub_group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sub Group No') ?></th>
                    <td><?= h($accChartOfAccount->sub_group_no) ?></td>
                </tr>
                <tr>
                    <th><?= __('Default') ?></th>
                    <td><?= h($accChartOfAccount->default) ?></td>
                </tr>
                <tr>
                    <th><?= __('Journal Type') ?></th>
                    <td><?= h($accChartOfAccount->journal_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transaction') ?></th>
                    <td><?= h($accChartOfAccount->transaction) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($accChartOfAccount->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Character') ?></th>
                    <td><?= h($accChartOfAccount->character) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code Additional') ?></th>
                    <td><?= h($accChartOfAccount->code_additional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Create') ?></th>
                    <td><?= h($accChartOfAccount->is_create) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Update') ?></th>
                    <td><?= h($accChartOfAccount->is_update) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Delete') ?></th>
                    <td><?= h($accChartOfAccount->is_delete) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($accChartOfAccount->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= h($accChartOfAccount->is_active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($accChartOfAccount->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lft') ?></th>
                    <td><?= $this->Number->format($accChartOfAccount->lft) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rght') ?></th>
                    <td><?= $this->Number->format($accChartOfAccount->rght) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($accChartOfAccount->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Additional') ?></th>
                    <td><?= $this->Number->format($accChartOfAccount->additional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($accChartOfAccount->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($accChartOfAccount->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deleted') ?></th>
                    <td><?= h($accChartOfAccount->deleted) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Acc Account Mappings') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_account_mappings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accChartOfAccount->acc_account_mappings as $accAccountMappings) : ?>
                        <tr>
                            <td><?= h($accAccountMappings->id) ?></td>
                            <td><?= h($accAccountMappings->branch_id) ?></td>
                            <td><?= h($accAccountMappings->acc_chart_of_account_id) ?></td>
                            <td><?= h($accAccountMappings->group) ?></td>
                            <td><?= h($accAccountMappings->name) ?></td>
                            <td><?= h($accAccountMappings->desc) ?></td>
                            <td><?= h($accAccountMappings->is_create) ?></td>
                            <td><?= h($accAccountMappings->created) ?></td>
                            <td><?= h($accAccountMappings->is_update) ?></td>
                            <td><?= h($accAccountMappings->modified) ?></td>
                            <td><?= h($accAccountMappings->is_delete) ?></td>
                            <td><?= h($accAccountMappings->deleted) ?></td>
                            <td><?= h($accAccountMappings->status) ?></td>
                            <td><?= h($accAccountMappings->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['prefix' => 'Acc', 'controller' => 'AccAccountMappings', 'action' => 'view', $accAccountMappings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Acc', 'controller' => 'AccAccountMappings', 'action' => 'edit', $accAccountMappings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Acc', 'controller' => 'AccAccountMappings', 'action' => 'delete', $accAccountMappings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accAccountMappings->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Beginning Balances') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_beginning_balances)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Dates') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Position') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Debet') ?></th>
                            <th><?= __('Credit') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accChartOfAccount->acc_beginning_balances as $accBeginningBalances) : ?>
                        <tr>
                            <td><?= h($accBeginningBalances->id) ?></td>
                            <td><?= h($accBeginningBalances->branch_id) ?></td>
                            <td><?= h($accBeginningBalances->acc_chart_of_account_id) ?></td>
                            <td><?= h($accBeginningBalances->dates) ?></td>
                            <td><?= h($accBeginningBalances->status) ?></td>
                            <td><?= h($accBeginningBalances->position) ?></td>
                            <td><?= h($accBeginningBalances->ledger_dc) ?></td>
                            <td><?= h($accBeginningBalances->debet) ?></td>
                            <td><?= h($accBeginningBalances->credit) ?></td>
                            <td><?= h($accBeginningBalances->is_active) ?></td>
                            <td><?= h($accBeginningBalances->is_create) ?></td>
                            <td><?= h($accBeginningBalances->created) ?></td>
                            <td><?= h($accBeginningBalances->is_update) ?></td>
                            <td><?= h($accBeginningBalances->modified) ?></td>
                            <td><?= h($accBeginningBalances->is_delete) ?></td>
                            <td><?= h($accBeginningBalances->deleted) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccBeginningBalances', 'action' => 'view', $accBeginningBalances->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccBeginningBalances', 'action' => 'edit', $accBeginningBalances->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccBeginningBalances', 'action' => 'delete', $accBeginningBalances->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accBeginningBalances->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Chart Of Accounts') ?></h4>
                <?php if (!empty($accChartOfAccount->child_acc_chart_of_accounts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Parent Account') ?></th>
                            <th><?= __('Header Account') ?></th>
                            <th><?= __('Sub Header Account') ?></th>
                            <th><?= __('Code') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Contra Account') ?></th>
                            <th><?= __('Mapping') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Sub Group') ?></th>
                            <th><?= __('Sub Group No') ?></th>
                            <th><?= __('Default') ?></th>
                            <th><?= __('Journal Type') ?></th>
                            <th><?= __('Transaction') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Character') ?></th>
                            <th><?= __('Code Additional') ?></th>
                            <th><?= __('Additional') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accChartOfAccount->child_acc_chart_of_accounts as $childAccChartOfAccounts) : ?>
                        <tr>
                            <td><?= h($childAccChartOfAccounts->id) ?></td>
                            <td><?= h($childAccChartOfAccounts->branch_id) ?></td>
                            <td><?= h($childAccChartOfAccounts->parent_id) ?></td>
                            <td><?= h($childAccChartOfAccounts->lft) ?></td>
                            <td><?= h($childAccChartOfAccounts->rght) ?></td>
                            <td><?= h($childAccChartOfAccounts->level) ?></td>
                            <td><?= h($childAccChartOfAccounts->parent_account) ?></td>
                            <td><?= h($childAccChartOfAccounts->header_account) ?></td>
                            <td><?= h($childAccChartOfAccounts->sub_header_account) ?></td>
                            <td><?= h($childAccChartOfAccounts->code) ?></td>
                            <td><?= h($childAccChartOfAccounts->name) ?></td>
                            <td><?= h($childAccChartOfAccounts->type) ?></td>
                            <td><?= h($childAccChartOfAccounts->contra_account) ?></td>
                            <td><?= h($childAccChartOfAccounts->mapping) ?></td>
                            <td><?= h($childAccChartOfAccounts->group) ?></td>
                            <td><?= h($childAccChartOfAccounts->sub_group) ?></td>
                            <td><?= h($childAccChartOfAccounts->sub_group_no) ?></td>
                            <td><?= h($childAccChartOfAccounts->default) ?></td>
                            <td><?= h($childAccChartOfAccounts->journal_type) ?></td>
                            <td><?= h($childAccChartOfAccounts->transaction) ?></td>
                            <td><?= h($childAccChartOfAccounts->description) ?></td>
                            <td><?= h($childAccChartOfAccounts->character) ?></td>
                            <td><?= h($childAccChartOfAccounts->code_additional) ?></td>
                            <td><?= h($childAccChartOfAccounts->additional) ?></td>
                            <td><?= h($childAccChartOfAccounts->is_create) ?></td>
                            <td><?= h($childAccChartOfAccounts->created) ?></td>
                            <td><?= h($childAccChartOfAccounts->is_update) ?></td>
                            <td><?= h($childAccChartOfAccounts->modified) ?></td>
                            <td><?= h($childAccChartOfAccounts->is_delete) ?></td>
                            <td><?= h($childAccChartOfAccounts->deleted) ?></td>
                            <td><?= h($childAccChartOfAccounts->status) ?></td>
                            <td><?= h($childAccChartOfAccounts->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'view', $childAccChartOfAccounts->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'edit', $childAccChartOfAccounts->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Acc', 'controller' => 'AccChartOfAccounts', 'action' => 'delete', $childAccChartOfAccounts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childAccChartOfAccounts->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Bank Lines') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_journal_bank_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Bank Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
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
                        <?php foreach ($accChartOfAccount->acc_journal_bank_lines as $accJournalBankLines) : ?>
                        <tr>
                            <td><?= h($accJournalBankLines->id) ?></td>
                            <td><?= h($accJournalBankLines->branch_id) ?></td>
                            <td><?= h($accJournalBankLines->acc_journal_bank_id) ?></td>
                            <td><?= h($accJournalBankLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalBankLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalBankLines->ledger_dc) ?></td>
                            <td><?= h($accJournalBankLines->name) ?></td>
                            <td><?= h($accJournalBankLines->debet) ?></td>
                            <td><?= h($accJournalBankLines->credit) ?></td>
                            <td><?= h($accJournalBankLines->is_create) ?></td>
                            <td><?= h($accJournalBankLines->created) ?></td>
                            <td><?= h($accJournalBankLines->is_update) ?></td>
                            <td><?= h($accJournalBankLines->modified) ?></td>
                            <td><?= h($accJournalBankLines->is_delete) ?></td>
                            <td><?= h($accJournalBankLines->deleted) ?></td>
                            <td><?= h($accJournalBankLines->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalBankLines', 'action' => 'view', $accJournalBankLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalBankLines', 'action' => 'edit', $accJournalBankLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalBankLines', 'action' => 'delete', $accJournalBankLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalBankLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Cash Lines') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_journal_cash_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Cash Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id Oris') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
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
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accChartOfAccount->acc_journal_cash_lines as $accJournalCashLines) : ?>
                        <tr>
                            <td><?= h($accJournalCashLines->id) ?></td>
                            <td><?= h($accJournalCashLines->branch_id) ?></td>
                            <td><?= h($accJournalCashLines->acc_journal_cash_id) ?></td>
                            <td><?= h($accJournalCashLines->acc_chart_of_account_id_oris) ?></td>
                            <td><?= h($accJournalCashLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalCashLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalCashLines->ledger_dc) ?></td>
                            <td><?= h($accJournalCashLines->name) ?></td>
                            <td><?= h($accJournalCashLines->debet) ?></td>
                            <td><?= h($accJournalCashLines->credit) ?></td>
                            <td><?= h($accJournalCashLines->is_create) ?></td>
                            <td><?= h($accJournalCashLines->created) ?></td>
                            <td><?= h($accJournalCashLines->is_update) ?></td>
                            <td><?= h($accJournalCashLines->modified) ?></td>
                            <td><?= h($accJournalCashLines->is_delete) ?></td>
                            <td><?= h($accJournalCashLines->deleted) ?></td>
                            <td><?= h($accJournalCashLines->status) ?></td>
                            <td><?= h($accJournalCashLines->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalCashLines', 'action' => 'view', $accJournalCashLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalCashLines', 'action' => 'edit', $accJournalCashLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalCashLines', 'action' => 'delete', $accJournalCashLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalCashLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Lines') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_journal_lines)) : ?>
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
                        <?php foreach ($accChartOfAccount->acc_journal_lines as $accJournalLines) : ?>
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
            <div class="related">
                <h4><?= __('Related Acc Journal Mappings') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_journal_mappings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Group') ?></th>
                            <th><?= __('Sub Group') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Ledger Dc') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Commentary') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accChartOfAccount->acc_journal_mappings as $accJournalMappings) : ?>
                        <tr>
                            <td><?= h($accJournalMappings->id) ?></td>
                            <td><?= h($accJournalMappings->branch_id) ?></td>
                            <td><?= h($accJournalMappings->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalMappings->group) ?></td>
                            <td><?= h($accJournalMappings->sub_group) ?></td>
                            <td><?= h($accJournalMappings->type) ?></td>
                            <td><?= h($accJournalMappings->ledger_dc) ?></td>
                            <td><?= h($accJournalMappings->name) ?></td>
                            <td><?= h($accJournalMappings->commentary) ?></td>
                            <td><?= h($accJournalMappings->desc) ?></td>
                            <td><?= h($accJournalMappings->is_create) ?></td>
                            <td><?= h($accJournalMappings->created) ?></td>
                            <td><?= h($accJournalMappings->is_update) ?></td>
                            <td><?= h($accJournalMappings->modified) ?></td>
                            <td><?= h($accJournalMappings->is_delete) ?></td>
                            <td><?= h($accJournalMappings->deleted) ?></td>
                            <td><?= h($accJournalMappings->status) ?></td>
                            <td><?= h($accJournalMappings->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['prefix' => 'Acc', 'controller' => 'AccJournalMappings', 'action' => 'view', $accJournalMappings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['prefix' => 'Acc', 'controller' => 'AccJournalMappings', 'action' => 'edit', $accJournalMappings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['prefix' => 'Acc', 'controller' => 'AccJournalMappings', 'action' => 'delete', $accJournalMappings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMappings->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Acc Journal Memorial Lines') ?></h4>
                <?php if (!empty($accChartOfAccount->acc_journal_memorial_lines)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Acc Journal Memorial Id') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Acc Chart Of Account Code') ?></th>
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
                        <?php foreach ($accChartOfAccount->acc_journal_memorial_lines as $accJournalMemorialLines) : ?>
                        <tr>
                            <td><?= h($accJournalMemorialLines->id) ?></td>
                            <td><?= h($accJournalMemorialLines->branch_id) ?></td>
                            <td><?= h($accJournalMemorialLines->acc_journal_memorial_id) ?></td>
                            <td><?= h($accJournalMemorialLines->acc_chart_of_account_id) ?></td>
                            <td><?= h($accJournalMemorialLines->acc_chart_of_account_code) ?></td>
                            <td><?= h($accJournalMemorialLines->ledger_dc) ?></td>
                            <td><?= h($accJournalMemorialLines->name) ?></td>
                            <td><?= h($accJournalMemorialLines->debet) ?></td>
                            <td><?= h($accJournalMemorialLines->credit) ?></td>
                            <td><?= h($accJournalMemorialLines->is_create) ?></td>
                            <td><?= h($accJournalMemorialLines->created) ?></td>
                            <td><?= h($accJournalMemorialLines->is_update) ?></td>
                            <td><?= h($accJournalMemorialLines->modified) ?></td>
                            <td><?= h($accJournalMemorialLines->is_delete) ?></td>
                            <td><?= h($accJournalMemorialLines->deleted) ?></td>
                            <td><?= h($accJournalMemorialLines->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'AccJournalMemorialLines', 'action' => 'view', $accJournalMemorialLines->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'AccJournalMemorialLines', 'action' => 'edit', $accJournalMemorialLines->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'AccJournalMemorialLines', 'action' => 'delete', $accJournalMemorialLines->id], ['confirm' => __('Are you sure you want to delete # {0}?', $accJournalMemorialLines->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Calks') ?></h4>
                <?php if (!empty($accChartOfAccount->calks)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Branch Id') ?></th>
                            <th><?= __('Date') ?></th>
                            <th><?= __('Acc Chart Of Account Id') ?></th>
                            <th><?= __('Desc') ?></th>
                            <th><?= __('Is Create') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Is Update') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Is Delete') ?></th>
                            <th><?= __('Deleted') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Is Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($accChartOfAccount->calks as $calks) : ?>
                        <tr>
                            <td><?= h($calks->id) ?></td>
                            <td><?= h($calks->branch_id) ?></td>
                            <td><?= h($calks->date) ?></td>
                            <td><?= h($calks->acc_chart_of_account_id) ?></td>
                            <td><?= h($calks->desc) ?></td>
                            <td><?= h($calks->is_create) ?></td>
                            <td><?= h($calks->created) ?></td>
                            <td><?= h($calks->is_update) ?></td>
                            <td><?= h($calks->modified) ?></td>
                            <td><?= h($calks->is_delete) ?></td>
                            <td><?= h($calks->deleted) ?></td>
                            <td><?= h($calks->status) ?></td>
                            <td><?= h($calks->is_active) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Calks', 'action' => 'view', $calks->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Calks', 'action' => 'edit', $calks->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Calks', 'action' => 'delete', $calks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calks->id)]) ?>
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
