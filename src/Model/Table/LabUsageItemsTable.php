<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class LabUsageItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('lab_usage_items');
        $this->setPrimaryKey('id');
        $this->belongsTo('LabUsages', ['foreignKey' => 'lab_usage_id']);
    }
}