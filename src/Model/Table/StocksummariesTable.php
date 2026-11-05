<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Read-only: membaca view v_stock_summary.
 */
class StockSummariesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('v_stock_summary');
        $this->setPrimaryKey(['warehouse_id', 'item_id']);
    }
}