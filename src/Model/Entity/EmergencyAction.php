<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmergencyAction Entity
 *
 * @property int $id
 * @property int $registration_id
 * @property string|null $action_code
 * @property string $action_name
 * @property string $action_category
 * @property int $quantity
 * @property string $unit_price
 * @property string $total_price
 * @property string|null $notes
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Registration $registration
 */
class EmergencyAction extends Entity
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
        'registration_id' => true,
        'action_code' => true,
        'action_name' => true,
        'action_category' => true,
        'quantity' => true,
        'unit_price' => true,
        'total_price' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'registration' => true,
    ];
}