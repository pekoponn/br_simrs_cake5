<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccChartOfAccount Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property int $parent_id
 * @property int|null $lft
 * @property int|null $rght
 * @property int|null $level
 * @property string|null $parent_account
 * @property string|null $header_account
 * @property string|null $sub_header_account
 * @property string|null $code
 * @property string|null $name
 * @property string|null $type
 * @property string|null $contra_account
 * @property string|null $mapping
 * @property string $groups
 * @property string $sub_group
 * @property string $sub_group_no
 * @property string|null $default
 * @property string|null $journal_type
 * @property string $transaction
 * @property string $description
 * @property string $character
 * @property string $code_additional
 * @property int $additional
 * @property string|null $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\DateTime|null $deleted
 * @property string|null $status
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\ParentAccChartOfAccount $parent_acc_chart_of_account
 * @property \App\Model\Entity\AccAccountMapping[] $acc_account_mappings
 * @property \App\Model\Entity\AccBeginningBalance[] $acc_beginning_balances
 * @property \App\Model\Entity\ChildAccChartOfAccount[] $child_acc_chart_of_accounts
 * @property \App\Model\Entity\AccJournalBankLine[] $acc_journal_bank_lines
 * @property \App\Model\Entity\AccJournalCashLine[] $acc_journal_cash_lines
 * @property \App\Model\Entity\AccJournalLine[] $acc_journal_lines
 * @property \App\Model\Entity\AccJournalMapping[] $acc_journal_mappings
 * @property \App\Model\Entity\AccJournalMemorialLine[] $acc_journal_memorial_lines
 * @property \App\Model\Entity\Calk[] $calks
 */
class AccChartOfAccount extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        // 'branch_id' => true,
        // 'parent_id' => true,
        // 'lft' => true,
        // 'rght' => true,
        // 'level' => true,
        // 'parent_account' => true,
        // 'header_account' => true,
        // 'sub_header_account' => true,
        // 'code' => true,
        // 'name' => true,
        // 'type' => true,
        // 'normal_balance' => true,
        // 'contra_account' => true,
        // 'mapping' => true,
        // 'groups' => true,
        // 'sub_group' => true,
        // 'sub_group_no' => true,
        // 'default' => true,
        // 'journal_type' => true,
        // 'beginning_balance' => true,
        // 'beginning_balance_debet' => true,
        // 'beginning_balance_credit' => true,
        // 'beginning_balance_date' => true,
        // 'ending_balance_bank' => true,
        // 'transaction' => true,
        // 'description' => true,
        // 'character' => true,
        // 'code_additional' => true,
        // 'additional' => true,
        // 'is_log' => true,
        // 'is_create' => true,
        // 'created' => true,
        // 'is_update' => true,
        // 'modified' => true,
        // 'is_delete' => true,
        // 'deleted' => true,
        // 'status' => true,
        // 'is_active' => true,
        // 'branch' => true,
        // 'parent_acc_chart_of_account' => true,
        // 'acc_account_mappings' => true,
        // 'acc_beginning_balances' => true,
        // 'child_acc_chart_of_accounts' => true,
        // // 'acc_journal_bank_lines' => true,
        // // 'acc_journal_cash_lines' => true,
        // 'acc_journal_lines' => true,
        // 'acc_journal_mappings' => true,
        // // 'acc_journal_memorial_lines' => true,
        // 'customers' => true,
        // 'calks' => true,
        '*' => true,
        'id' => false
    ];
}
