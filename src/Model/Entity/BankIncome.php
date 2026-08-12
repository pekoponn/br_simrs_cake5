<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * BankIncome Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property string|null $ubs
 * @property int|null $acc_coa_id
 * @property string|null $payment_type
 * @property string $nominal
 * @property string|null $description
 * @property string|null $file_1
 * @property string|null $file_2
 * @property int|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string $is_active
 * @property string|null $is_log
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\AccCoa $acc_coa
 */
class BankIncome extends Entity
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
        'ubs' => true,
        'acc_coa_id' => true,
        'payment_type' => true,
        'nominal' => true,
        'description' => true,
        'file_1' => true,
        'file_2' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'is_active' => true,
        'is_log' => true,
        'branch' => true,
        'acc_coa' => true,
    ];
}
