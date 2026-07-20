<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderPembelianDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderPembelianDetailsTable Test Case
 */
class OrderPembelianDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderPembelianDetailsTable
     */
    protected $OrderPembelianDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderPembelianDetails',
        'app.OrderPembelians',
        'app.Barangs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderPembelianDetails') ? [] : ['className' => OrderPembelianDetailsTable::class];
        $this->OrderPembelianDetails = $this->getTableLocator()->get('OrderPembelianDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderPembelianDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderPembelianDetailsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderPembelianDetailsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
