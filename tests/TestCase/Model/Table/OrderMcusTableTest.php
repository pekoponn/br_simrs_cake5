<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderMcusTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderMcusTable Test Case
 */
class OrderMcusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderMcusTable
     */
    protected $OrderMcus;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderMcus',
        'app.Orders',
        'app.Registrations',
        'app.Patients',
        'app.Doctors',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderMcus') ? [] : ['className' => OrderMcusTable::class];
        $this->OrderMcus = $this->getTableLocator()->get('OrderMcus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderMcus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderMcusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderMcusTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
