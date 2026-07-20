<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MedicineStocksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MedicineStocksTable Test Case
 */
class MedicineStocksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MedicineStocksTable
     */
    protected $MedicineStocks;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.MedicineStocks',
        'app.Branches',
        'app.Medicines',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MedicineStocks') ? [] : ['className' => MedicineStocksTable::class];
        $this->MedicineStocks = $this->getTableLocator()->get('MedicineStocks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->MedicineStocks);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MedicineStocksTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MedicineStocksTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
