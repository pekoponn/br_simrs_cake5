<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientBillingItem Entity
 *
 * @property int $id
 * @property int $billing_id
 * @property string $item_type
 * @property string|null $item_code
 * @property string $item_name
 * @property string $quantity
 * @property string|null $unit
 * @property string $unit_price
 * @property string $total_price
 * @property string $discount_amount
 * @property string $final_price
 * @property string|null $notes
 * @property bool $is_covered
 * @property int $sort_order
 * @property bool|null $is_delete
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\OutpatientBilling $outpatient_billing
 */
class OutpatientBillingItem extends Entity
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
        'billing_id' => true,
        'item_type' => true,
        'item_code' => true,
        'item_name' => true,
        'quantity' => true,
        'unit' => true,
        'unit_price' => true,
        'total_price' => true,
        'discount_amount' => true,
        'final_price' => true,
        'notes' => true,
        'is_covered' => true,
        'sort_order' => true,
        'is_delete' => true,
        'created' => true,
        'outpatient_billing' => true,
    ];
}
