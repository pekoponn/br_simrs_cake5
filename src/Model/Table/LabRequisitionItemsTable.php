<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabRequisitionItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('lab_requisition_items');
        $this->setPrimaryKey('id');
        $this->belongsTo('LabRequisitions', ['foreignKey' => 'lab_requisition_id']);
    }
}