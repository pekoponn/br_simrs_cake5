<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderSurgeriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderSurgeriesTable Test Case
 */
class OrderSurgeriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderSurgeriesTable
     */
    protected $OrderSurgeries;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderSurgeries',
        'app.Orders',
        'app.Registrations',
        'app.Patients',
        'app.Doctors',
        'app.Operators',
        'app.OperationTypes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderSurgeries') ? [] : ['className' => OrderSurgeriesTable::class];
        $this->OrderSurgeries = $this->getTableLocator()->get('OrderSurgeries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderSurgeries);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderSurgeriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderSurgeriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
