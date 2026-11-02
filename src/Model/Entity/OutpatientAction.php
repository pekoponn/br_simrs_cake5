<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OutpatientAction Entity
 *
 * @property int $id
 * @property int $outpatient_visit_id
 * @property int|null $master_tindakan_id
 * @property string|null $action_code
 * @property string $action_name
 * @property string|null $action_category
 * @property int $quantity
 * @property string|null $unit_price
 * @property string|null $total_price
 * @property string|null $notes
 * @property string|null $performed_by
 * @property \Cake\I18n\DateTime|null $performed_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\OutpatientVisit $outpatient_visit
 * @property \App\Model\Entity\MasterTindakan $master_tindakan
 */
class OutpatientAction extends Entity
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
        'outpatient_visit_id' => true,
        'master_tindakan_id' => true,
        'action_code' => true,
        'action_name' => true,
        'action_category' => true,
        'quantity' => true,
        'unit_price' => true,
        'total_price' => true,
        'notes' => true,
        'performed_by' => true,
        'performed_at' => true,
        'created' => true,
        'modified' => true,
        'outpatient_visit' => true,
        'master_tindakan' => true,
    ];
}
