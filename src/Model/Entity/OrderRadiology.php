<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class OrderRadiology extends Entity
{
    protected $_accessible = [
        'order_id' => true,
        'master_tindakan_id' => true,
        'code' => true,
        'examination_name' => true,
        'price' => true,
        'approval_note' => true,
        'created' => true,
        'modified' => true,
        'order' => true,
        'master_tindakan' => true,
    ];
}
