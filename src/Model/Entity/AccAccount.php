<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccAccount Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int $parent_id
 * @property int|null $lft
 * @property int|null $rght
 * @property int|null $level
 * @property string|null $code
 * @property string|null $parent_code
 * @property string|null $name
 * @property string|null $type
 * @property string $group
 * @property string|null $journal_type
 * @property string $transaction
 * @property string $description
 * @property string $character
 * @property string $code_additional
 * @property int $additional
 * @property int|null $is_create
 * @property int|null $is_update
 * @property int|null $is_delete
 * @property string|null $is_active
 * @property string|null $who_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $who_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $who_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\ParentAccAccount $parent_acc_account
 * @property \App\Model\Entity\ChildAccAccount[] $child_acc_accounts
 * @property \App\Model\Entity\AccCashLine[] $acc_cash_lines
 */
class AccAccount extends Entity
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
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'level' => true,
        'code' => true,
        'parent_code' => true,
        'name' => true,
        'type' => true,
        'group' => true,
        'journal_type' => true,
        'transaction' => true,
        'description' => true,
        'character' => true,
        'code_additional' => true,
        'additional' => true,
        'is_create' => true,
        'is_update' => true,
        'is_delete' => true,
        'is_active' => true,
        'who_create' => true,
        'created' => true,
        'who_update' => true,
        'modified' => true,
        'who_delete' => true,
        'deleted' => true,
        'status' => true,
        'branch' => true,
        'parent_acc_account' => true,
        'child_acc_accounts' => true,
        'acc_cash_lines' => true,
    ];
}
