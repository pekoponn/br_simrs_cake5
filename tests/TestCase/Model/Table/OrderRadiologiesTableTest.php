<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderRadiologiesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderRadiologiesTable Test Case
 */
class OrderRadiologiesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderRadiologiesTable
     */
    protected $OrderRadiologies;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderRadiologies',
        'app.Orders',
        'app.MasterTindakan',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderRadiologies') ? [] : ['className' => OrderRadiologiesTable::class];
        $this->OrderRadiologies = $this->getTableLocator()->get('OrderRadiologies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderRadiologies);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderRadiologiesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderRadiologiesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
