<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabNormalValuesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_normal_values');
        $this->setPrimaryKey('id');
        $this->setDisplayField('parameter_name');
        $this->addBehavior('Timestamp');
    }
}