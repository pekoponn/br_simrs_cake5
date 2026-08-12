<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccJournalLine Entity
 *
 * @property int $id
 * @property string $branch_id
 * @property int $acc_journal_id
 * @property int $journal_sub_id
 * @property int $journal_sub_line_id
 * @property int|null $acc_chart_of_account_id
 * @property string $acc_chart_of_account_code
 * @property int $position
 * @property string|null $ledger_dc
 * @property string|null $name
 * @property string|null $debet
 * @property string|null $credit
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\AccJournal $acc_journal
 * @property \App\Model\Entity\JournalSub $journal_sub
 * @property \App\Model\Entity\JournalSubLine $journal_sub_line
 * @property \App\Model\Entity\AccChartOfAccount $acc_chart_of_account
 */
class AccJournalLine extends Entity
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
    protected $_accessible = [
        'branch_id' => true,
        'acc_journal_id' => true,
        'journal_sub_id' => true,
        'journal_sub_line_id' => true,
        'acc_chart_of_account_id' => true,
        'acc_chart_of_account_code' => true,
        'position' => true,
        'ledger_dc' => true,
        'name' => true,
        'is_log' => true,
        'debet' => true,
        'credit' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'status' => true,
        'branch' => true,
        'acc_journal' => true,
        // 'journal_sub' => true,
        // 'journal_sub_line' => true,
        'acc_chart_of_account' => true,
    ];
}
