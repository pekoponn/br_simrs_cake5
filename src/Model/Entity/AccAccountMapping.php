<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AccAccountMapping Entity
 *
 * @property int $id
 * @property int $branch_id
 * @property int|null $acc_chart_of_account_id
 * @property string $group
 * @property string|null $name
 * @property string|null $desc
 * @property string|null $is_create
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $is_update
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $is_delete
 * @property \Cake\I18n\FrozenTime|null $deleted
 * @property string|null $status
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\Branch $branch
 * @property \App\Model\Entity\AccChartOfAccount $acc_chart_of_account
 */
class AccAccountMapping extends Entity
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
        'acc_chart_of_account_id' => true,
        'group' => true,
        'name' => true,
        'desc' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_delete' => true,
        'deleted' => true,
        'status' => true,
        'is_active' => true,
        'branch' => true,
        'acc_chart_of_account' => true,
    ];
}
