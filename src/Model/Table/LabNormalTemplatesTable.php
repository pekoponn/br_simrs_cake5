<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabNormalTemplatesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_normal_templates');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
    }
}