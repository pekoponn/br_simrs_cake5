<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AbsentIssue Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $file_1
 * @property string|null $file_2
 * @property string|null $description
 * @property string|null $status
 * @property int|null $is_done
 * @property \Cake\I18n\DateTime|null $doned
 * @property int $is_create
 * @property \Cake\I18n\DateTime|null $created
 * @property int $is_update
 * @property \Cake\I18n\DateTime|null $modified
 * @property string|null $is_log
 * @property string|null $is_active
 *
 * @property \App\Model\Entity\User $user
 */
class AbsentIssue extends Entity
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
        'user_id' => true,
        'file_1' => true,
        'file_2' => true,
        'description' => true,
        'status' => true,
        'is_done' => true,
        'doned' => true,
        'is_create' => true,
        'created' => true,
        'is_update' => true,
        'modified' => true,
        'is_log' => true,
        'is_active' => true,
        'user' => true,
    ];
}
