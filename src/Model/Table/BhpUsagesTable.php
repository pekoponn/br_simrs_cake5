<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class BhpUsagesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('bhp_usages');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('BhpUsageItems', ['foreignKey' => 'bhp_usage_id', 'dependent' => true]);
    }
}