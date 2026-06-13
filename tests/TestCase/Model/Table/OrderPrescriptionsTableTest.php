<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderPrescriptionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderPrescriptionsTable Test Case
 */
class OrderPrescriptionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderPrescriptionsTable
     */
    protected $OrderPrescriptions;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderPrescriptions',
        'app.Orders',
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
        $config = $this->getTableLocator()->exists('OrderPrescriptions') ? [] : ['className' => OrderPrescriptionsTable::class];
        $this->OrderPrescriptions = $this->getTableLocator()->get('OrderPrescriptions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderPrescriptions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderPrescriptionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderPrescriptionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
