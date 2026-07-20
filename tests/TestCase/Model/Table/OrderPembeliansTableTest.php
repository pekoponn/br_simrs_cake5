<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderPembeliansTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderPembeliansTable Test Case
 */
class OrderPembeliansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderPembeliansTable
     */
    protected $OrderPembelians;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderPembelians',
        'app.Suppliers',
        'app.OrderPembelianDetails',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderPembelians') ? [] : ['className' => OrderPembeliansTable::class];
        $this->OrderPembelians = $this->getTableLocator()->get('OrderPembelians', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderPembelians);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderPembeliansTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderPembeliansTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
