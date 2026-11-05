<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ItemRequestsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('item_requests');
        $this->setPrimaryKey('id');
        $this->addBehavior('Timestamp');
        $this->hasMany('ItemRequestItems', ['foreignKey' => 'item_request_id', 'dependent' => true]);
    }
}