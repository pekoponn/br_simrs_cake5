<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabRequisitionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('lab_requisitions');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('LabRequisitionItems', [
            'foreignKey' => 'lab_requisition_id',
            'dependent' => true,
        ]);
    }
}