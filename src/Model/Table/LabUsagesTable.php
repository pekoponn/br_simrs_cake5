<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabUsagesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_usages');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('LabUsageItems', ['foreignKey' => 'lab_usage_id', 'dependent' => true]);
    }
}