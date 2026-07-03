<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderLaboratoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderLaboratoriesTable Test Case
 */
class OrderLaboratoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderLaboratoriesTable
     */
    protected $OrderLaboratories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.OrderLaboratories',
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
        $config = $this->getTableLocator()->exists('OrderLaboratories') ? [] : ['className' => OrderLaboratoriesTable::class];
        $this->OrderLaboratories = $this->getTableLocator()->get('OrderLaboratories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->OrderLaboratories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\OrderLaboratoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\OrderLaboratoriesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
