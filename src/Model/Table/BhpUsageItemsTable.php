<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class BhpUsageItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('bhp_usage_items');
        $this->setPrimaryKey('id');
        $this->belongsTo('BhpUsages', ['foreignKey' => 'bhp_usage_id']);
    }
}