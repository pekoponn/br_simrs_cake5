<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecipientPayer Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string|null $code
 * @property string|null $name
 * @property int|null $status
 * @property int|null $position
 * @property string|null $is_active
 * @property string|null $is_log
 * @property int|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\AccJournalBank[] $acc_journal_banks
 * @property \App\Model\Entity\AccJournalCash[] $acc_journal_cashes
 * @property \App\Model\Entity\AccJournalMemorial[] $acc_journal_memorials
 * @property \App\Model\Entity\AccJournal[] $acc_journals
 */
class RecipientPayer extends Entity
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
        'code' => true,
        'name' => true,
        'status' => true,
        'position' => true,
        'is_active' => true,
        'is_log' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'branch' => true,
        'acc_journal_banks' => true,
        'acc_journal_cashes' => true,
        'acc_journal_memorials' => true,
        'acc_journals' => true,
    ];
}
