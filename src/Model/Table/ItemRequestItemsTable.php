<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

class ItemRequestItemsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->setTable('item_request_items');
        $this->setPrimaryKey('id');
        $this->belongsTo('ItemRequests', ['foreignKey' => 'item_request_id']);
    }
}